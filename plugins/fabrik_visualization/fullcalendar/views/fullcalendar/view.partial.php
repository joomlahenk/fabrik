<?php
/**
 * Fabrik Calendar HTML View
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.visualization.calendar
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;

jimport('joomla.application.component.view');

/**
 * Fabrik Calendar HTML View
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.visualization.calendar
 * @since       3.0
 */
class FabrikViewFullcalendar extends HtmlView
{
	/**
	 * Choose which list to add an event to
	 *
	 * @return  void
	 */
	public function chooseAddEvent()
	{
		$app   = Factory::getApplication();
		$input = $app->input;
		$this->setLayout('chooseAddEvent');
		$model       = $this->getModel();
		$usersConfig = ComponentHelper::getParams('com_fabrik');
		$model->setId($input->getInt('id', $usersConfig->get('visualizationid', $input->getInt('visualizationid', 0))));
		$rows = $model->getEventLists();

		foreach ($rows as $rowkey => $row) {
			$listModel = BaseDatabaseModel::getInstance('List', 'FabrikFEModel');
			$listModel->setId($row->value);
			if (!$listModel->canAdd())
			{
				unset($rows[$rowkey]);
			}
		}

		$model->getVisualization();
		$options   = array();
		$options[] = JHTML::_('select.option', '', FText::_('PLG_VISUALIZATION_FULLCALENDAR_PLEASE_SELECT'));

		$model->getEvents();
		$attribs            = 'class="inputbox" size="1" ';
		$options            = array_merge($options, $rows);
		$this->_eventTypeDd = JHTML::_('select.genericlist', $options, 'event_type', $attribs, 'value', 'text', '', 'fabrik_event_type');

		/*
		 * Tried loading in iframe and as an ajax request directly - however
		 * in the end decided to set a call back to the main calendar object (via the package manager)
		 * to load up the new add event form
		 */
		$ref      = $model->getJSRenderContext();
		$script   = array();
		$script[] = "document.id('fabrik_event_type').addEvent('change', function(e) {";
		$script[] = "var fid = e.target.get('value');";
		$script[] = "var o = ({'id':'','listid':fid,'rowid':0});";
		$script[] = "o.title = Joomla.Text._('PLG_VISUALIZATION_FULLCALENDAR_ADD_EVENT');";

		$script[] = "Fabrik.blocks['" . $ref . "'].addEvForm(o);";
		$script[] = "Fabrik.Windows.chooseeventwin.close();";
		$script[] = "});";

		echo '<h2>' . FText::_('PLG_VISUALIZATION_FULLCALENDAR_PLEASE_CHOOSE_AN_EVENT_TYPE') . ':</h2>';
		echo $this->_eventTypeDd;
		FabrikHelperHTML::addScriptDeclaration(implode("\n", $script));
	}
}
