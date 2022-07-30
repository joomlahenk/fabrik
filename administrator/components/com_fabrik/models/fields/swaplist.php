<?php
/**
 * Renders widget for (de)selecting available groups when editing a from
 *
 * @package     Joomla
 * @subpackage  Form
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\Field\ListField;

require_once JPATH_ADMINISTRATOR . '/components/com_fabrik/helpers/element.php';

/**
 * Renders widget for (de)selecting available groups when editing a from
 *
 * @package     Joomla
 * @subpackage  Form
 * @since       1.6
 */
class JFormFieldSwapList extends ListField
{
	/**
	 * Element name
	 * @access	protected
	 * @var		string
	 */
	protected $name = 'SwapList';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string	The field input markup.
	 */
	protected function getInput()
	{
		$from = $this->id . '-from';
		$add = $this->id . '-add';
		$remove = $this->id . '-remove';
		$up = $this->id . '-up';
		$down = $this->id . '-down';
		$script[] = "window.addEvent('domready', function () {";
		$script[] = "\tswaplist = new SwapList('$from', '$this->id','$add', '$remove', '$up', '$down');";
		$script[] = "});";

		FabrikHelperHTML::framework();
		FabrikHelperHTML::iniRequireJS();
		FabrikHelperHTML::script('administrator/components/com_fabrik/models/fields/swaplist.js', implode("\n", $script));

		list($this->currentGroups, $this->currentGroupList) = $this->getCurrentGroupList();
		list($this->groups, $this->groupList) = $this->getGroupList();
		$str = '';

		$checked = empty($this->current_groups) ? 'checked="checked"' : '';

		if (empty($this->groups) && empty($this->currentGroups))
		{
			return Text::_('COM_FABRIK_NO_GROUPS_AVAILABLE');
		}
		else
		{
			$str =	Text::_('COM_FABRIK_AVAILABLE_GROUPS');
			$str .= '<br />' . $this->groupList;
			$str .= '<button class="button btn btn-success btn-small" type="button" id="' . $this->id . '-add">';
			$str .= '<i class="icon-new"></i>' . Text::_('COM_FABRIK_ADD') . '</button>';
			$str .= '<br />' . Text::_('COM_FABRIK_CURRENT_GROUPS');
			$str .= '<br />' . $this->currentGroupList;
			$str .= '<button class="button btn btn-small" type="button" id="' . $this->id . '-up" >';
			$str .= '<i class="icon-arrow-up"></i> ' . Text::_('COM_FABRIK_UP') . '</button> ';
			$str .= '<button class="button btn btn-small" type="button" id="' . $this->id . '-down" >';
			$str .= '<i class="icon-arrow-down"></i> ' . Text::_('COM_FABRIK_DOWN') . '</button> ';
			$str .= '<button class="button btn btn-danger btn-small" type="button" id="' . $this->id . '-remove">';
			$str .= '<i class="icon-delete"></i> ' . Text::_('COM_FABRIK_REMOVE');
			$str .= '</button>';
			return $str;
		}
	}

	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 */
	protected function getLabel()
	{
		return '';
	}

	/**
	 * get a list of unused groups
	 *
	 * @return  array	list of groups, html list of groups
	 */
	public function getGroupList()
	{
		$db = FabrikWorker::getDbo(true);
		$query = $db->getQuery(true);
		$query->select('DISTINCT(group_id)')->from('#__fabrik_formgroup');
		$db->setQuery($query);
		$usedgroups = $db->loadColumn();
		$usedgroups = ArrayHelper::toInteger($usedgroups);
		$query = $db->getQuery(true);
		$query->select('id AS value, name AS text')->from('#__fabrik_groups');

		if (!empty($usedgroups))
		{
			$query->where('id NOT IN(' . implode(',', $usedgroups) . ')');
		}

		$query->where('published <> -2');
		$query->order(FabrikString::safeColName('text'));
		$db->setQuery($query);
		$groups = $db->loadObjectList();
		$style = 'style="width:50%;"';

		$list = HTMLHelper::_('select.genericlist', $groups, 'jform[groups]', 'class="inputbox col-md-12" size="10" ' . $style, 'value', 'text', null,
			$this->id . '-from');

		return array($groups, $list);
	}

	/**
	 * Get a list of groups currently used by the form
	 *
	 * @return  array  list of groups, html list of groups
	 */
	public function getCurrentGroupList()
	{
		$db = FabrikWorker::getDbo(true);
		$query = $db->getQuery(true);
		$query->select('fg.group_id AS value, g.name AS text');
		$query->from('#__fabrik_formgroup AS fg');
		$query->join('LEFT', ' #__fabrik_groups AS g ON fg.group_id = g.id');
		$query->where('fg.form_id = ' . (int) $this->form->getValue('id'));
		$query->where('g.name <> ""');
		$query->order('fg.ordering');
		$db->setQuery($query);
		$currentGroups = $db->loadObjectList();
		$style = 'style="width:50%;"';

		$attribs = 'class="inputbox col-md-12" multiple="multiple" ' . $style . ' size="10" ';
		$list = HTMLHelper::_('select.genericlist', $currentGroups, $this->name, $attribs, 'value', 'text', '/', $this->id);

		return array($currentGroups, $list);
	}
}
