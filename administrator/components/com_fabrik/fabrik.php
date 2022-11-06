<?php
/**
 * Entry point to Fabrik's administration pages
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\String\StringHelper;
use Joomla\CMS\HTML\HTMLHelper;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_fabrik'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Load front end language file as well
$lang = Factory::getLanguage();
$lang->load('com_fabrik', JPATH_SITE . '/components/com_fabrik');

// Test if the system plugin is installed and published
if (!defined('COM_FABRIK_FRONTEND'))
{
	throw new RuntimeException(Text::_('COM_FABRIK_SYSTEM_PLUGIN_NOT_ACTIVE'), 400);
}

$app = Factory::getApplication();
$input = $app->input;

$view = $app->input->get('view');
$layout = $app->input->get('layout', '');
if (in_array($view, ["element", "list", "form", "group"]) && !in_array($layout, ["confirmupdate"])) {
	$file = 'blockuserinput.js';
	$loc = FabrikHelperHTML::isDebug() ? Juri::root() . 'media/com_fabrik/js/' : Juri::root() .'media/com_fabrik/js/dist/';
	Factory::getDocument()->addScript($loc.$file);
}

// Include dependencies
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

HTMLHelper::stylesheet('administrator/components/com_fabrik/headings.css');

// Check for plugin views (e.g. list email plugin's "email form"
$cName = $input->getCmd('controller');

if (!empty($cName) && StringHelper::strpos($cName, '.') != false)
{
	list($type, $name) = explode('.', $cName);

	if ($type == 'visualization')
	{
		//require_once JPATH_COMPONENT . '/controllers/visualization.php';
		require_once COM_FABRIK_FRONTEND . '/controllers/visualization.php';
	}

	$path = JPATH_SITE . '/plugins/fabrik_' . $type . '/' . $name . '/controllers/' . $name . '.php';

	if (File::exists($path))
	{
		require_once $path;
		$controller = $type . $name;

		$className = 'FabrikController' . StringHelper::ucfirst($controller);
		$controller = new $className;

		// Add in plugin view
		$controller->addViewPath(JPATH_SITE . '/plugins/fabrik_' . $type . '/' . $name . '/views');

		// Add the model path
		BaseDatabaseModel::addIncludePath(JPATH_SITE . '/plugins/fabrik_' . $type . '/' . $name . '/models');
	}
}
else
{
	$controller	= BaseController::getInstance('FabrikAdmin');
}

// Test that they've published some element plugins!
$db = Factory::getDbo();
$query = $db->getQuery(true);
$query->select('COUNT(extension_id)')->from('#__extensions')
		->where('enabled = 1 AND folder = ' . $db->q('fabrik_element'));
$db->setQuery($query);

if ((int)$db->loadResult() === 0)
{
	$app->enqueueMessage(Text::_('COM_FABRIK_PUBLISH_AT_LEAST_ONE_ELEMENT_PLUGIN'), 'notice');
}

// Execute the task.
$controller->execute($input->get('task', 'home.display'));

if ($input->get('format', 'html') === 'html')
{
	FabrikHelperHTML::framework();
}

$controller->redirect();
