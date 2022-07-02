<?php
/**
 * Renders a list of groups
 *
 * @package     Joomla
 * @subpackage  Form
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ADMINISTRATOR . '/components/com_fabrik/helpers/element.php';

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('groupedlist');

/**
 * Renders a list of groups
 *
 * @package     Joomla
 * @subpackage  Form
 * @since       1.6
 */

class JFormFieldGroupList extends JFormFieldGroupedList
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $name = 'Grouplist';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string	The field input markup.
	 */

	protected function getGroups()
	{
		if ($this->value == '')
		{
			$app = JFactory::getApplication();
			$this->value = $app->getUserStateFromRequest('com_fabrik.elements.filter.group', 'filter_groupId', $this->value);
		}

		// Initialize variables.
		$options = array();
		$db = FabrikWorker::getDbo(true);
		$query = $db->getQuery(true);

		$query->select('g.id AS value, g.name AS text, f.label AS form');
		$query->from('#__fabrik_groups AS g');
		$query->where('g.published <> -2')
		->join('INNER', '#__fabrik_formgroup AS fg ON fg.group_id = g.id')
		->join('INNER', '#__fabrik_forms AS f on fg.form_id = f.id');
		$query->order('f.label, g.name');

		// Get the options.
		$db->setQuery($query);
		
		try
		{
			$db->setQuery($query);
			$options = $db->loadObjectList();
		}
		catch (Exception $e)
		{
			$app->enqueueMessage(JText::_($e->getMessage()), 'error');
		}
		
		$groups = array();

		// Add please select
		$sel = new stdClass;
		$sel->value = '';
		$sel->form = '';
		$sel->text = FText::_('COM_FABRIK_PLEASE_SELECT');
		array_unshift($options, $sel);

		foreach ($options as $option)
		{
			if (!array_key_exists($option->form, $groups))
			{
				$groups[$option->form] = array();
			}

			$groups[$option->form][] = $option;
		}

		// Check for a database error.
//		if ($db->getErrorNum())
//		{
//			JError::raiseWarning(500, $db->getErrorMsg());
//			\Joomla\CMS\Factory::getApplication()->enqueueMessage($db->getErrorMsg(), 'error');
//		}

		return $groups;
	}
}
