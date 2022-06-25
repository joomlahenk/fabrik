<?php
/**
 * Form Comment - JComment Helper
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.form.comment
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Table\Table;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;

require_once JCOMMENTS_BASE . '/jcomments.subscription.php';
require_once JCOMMENTS_BASE . '/jcomments.class.php';

/**
 * Class JCommentsTableObjects
 */
class JCommentsTableObjects extends Table
{
	public function __construct(&$db)
	{
		parent::__construct('#__jcomments_objects', 'id', $db);
	}
}

/**
 * Class FabrikJCommentHelper
 */
class FabrikJCommentHelper
{
	public static function subscribe($formPlugin)
	{
		$formModel     = $formPlugin->getModel();
		$jcObjectId    = $formModel->formData['rowid'];
		$jcObjectGroup = 'com_fabrik_' . $formModel->getId();
		$lang          = Factory::getLanguage();
		$language      = $lang->getTag();

		// Create / update thread
		self::jcUpsertObject($jcObjectId, $jcObjectGroup, $language, $formPlugin);

		// Add subscription
		$manager = JCommentsSubscriptionManager::getInstance();
		$user    = Factory::getUser();
		$manager->subscribe($jcObjectId, $jcObjectGroup, $user->id, $user->email, $user->name, $language);

		self::createJCommentPlugin($jcObjectGroup);
	}

	/**
	 * JComments requires a per fabrik form plugin to ensure that the comments_object data isnt overwritten
	 * @param $jcObjectGroup
	 */
	protected static function createJCommentPlugin($jcObjectGroup)
	{
		$script = "<?php
class jc_com_fabrik_1 extends JCommentsPlugin
{
	function getObjectInfo(\$id, \$lang)
	{
		\$db = Factory::getDbo();
		\$query = \$db->getQuery(true);
		\$query->select('*')->from('#__jcomments_objects')
			->where('object_id = ' . (int) \$id)
			->where('lang = ' . \$db->q(\$lang))
			->where('object_group = ' . \$db->q('com_fabrik_1'));
		\$item = \$db->setQuery(\$query)->loadObject();

		return \$item;
	}
}";
		$script = str_replace('com_fabrik_1', $jcObjectGroup, $script);
		$file = JPATH_SITE . '/components/com_jcomments/plugins/' . $jcObjectGroup . '.plugin.php';
		File::write($file, $script);
	}

	/**
	 * @param $objectId
	 * @param $objectGroup
	 * @param $language
	 *
	 * @return object
	 */
	protected static function jcObjectInfo($objectId, $objectGroup, $language)
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from('#__jcomments_objects')
			->where('object_id = ' . $db->q($objectId))
			->where('object_group = ' . $db->q($objectGroup))
			->where('lang = ' . $db->q($language));

		$db->setQuery($query);
		$info = $db->loadObject();

		return empty($info) ? new stdClass : $info;
	}

	/**
	 * @param $objectId
	 * @param $objectGroup
	 * @param $language
	 * @param $formPlugin
	 */
	protected static function jcUpsertObject($objectId, $objectGroup, $language, $formPlugin)
	{
		$title     = $formPlugin->placeholder('comment_jcomment_title');
		$formModel = $formPlugin->getModel();
		$formId    = $formModel->getId();

		$link = Route::_('index.php?option=com_fabrik&amp;view=details&formid=' . $formId . '&rowid=' . $objectId . '&listid=' . $formId);

		$user      = Factory::getUser();
		$info      = self::jcObjectInfo($objectId, $objectGroup, $language);
		$jObjectId = isset($info->id) ? $info->id : null;
		$row       = Table::getInstance('Objects', 'JCommentsTable');
		$data      = array(
			'access' => 1,
			'userid' => (int) $user->get('id'),
			'expired' => 0,
			'modified' => Factory::getDate()->toSql(),
			'title' => $title,
			'link' => $link,
			'category_id' => ''

		);

		if (!empty($jObjectId))
		{
			$data['id'] = (int) $jObjectId;
		}
		else
		{
			$data['object_id']    = (int) $objectId;
			$data['object_group'] = $objectGroup;
			$data['lang']         = $language;
		}

		if ($data['userid'] !== 0)
		{
			$row->bind($data);
			$row->store();
		}

	}
}