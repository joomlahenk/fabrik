<?php
/**
 * View to edit a group.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Factory;

/**
 * View to edit a group.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @since       3.0
 */

class FabrikAdminViewGroup extends HtmlView
{
	/**
	 * Form
	 *
	 * @var Form
	 */
	protected $form;

	/**
	 * Group item
	 *
	 * @var Table
	 */
	protected $item;

	/**
	 * View state
	 *
	 * @var object
	 */
	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template
	 *
	 * @return  void
	 */

	public function display($tpl = null)
	{
		// Initialise variables.
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new RuntimeException(implode("\n", $errors), 500);
		}

		$this->addToolbar();
		FabrikAdminHelper::setViewLayout($this);

		$srcs = FabrikHelperHTML::framework();
		FabrikHelperHTML::iniRequireJS();
		FabrikHelperHTML::script($srcs);

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 */

	protected function addToolbar()
	{
		$app = Factory::getApplication();
		$input = $app->input;
		$input->set('hidemainmenu', true);
		$user = Factory::getUser();
		$isNew = ($this->item->id == 0);
		$userId = $user->get('id');
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo = FabrikAdminHelper::getActions($this->state->get('filter.category_id'));
		$title = $isNew ? Text::_('COM_FABRIK_MANAGER_GROUP_NEW') : Text::_('COM_FABRIK_MANAGER_GROUP_EDIT') . ' "' . $this->item->name . '"';
		ToolBarHelper::title($title, 'stack');

		if ($isNew)
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create'))
			{
				ToolBarHelper::apply('group.apply', 'JTOOLBAR_APPLY');
				ToolBarHelper::save('group.save', 'JTOOLBAR_SAVE');
				ToolBarHelper::addNew('group.save2new', 'JTOOLBAR_SAVE_AND_NEW');
			}

			ToolBarHelper::cancel('group.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			// Can't save the record if it's checked out.
			if (!$checkedOut)
			{
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					ToolBarHelper::apply('group.apply', 'JTOOLBAR_APPLY');
					ToolBarHelper::save('group.save', 'JTOOLBAR_SAVE');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($canDo->get('core.create'))
					{
						ToolBarHelper::addNew('group.save2new', 'JTOOLBAR_SAVE_AND_NEW');
					}
				}
			}

			if ($canDo->get('core.create'))
			{
				ToolBarHelper::custom('group.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}

			ToolBarHelper::cancel('group.cancel', 'JTOOLBAR_CLOSE');
		}

		ToolBarHelper::divider();
		ToolBarHelper::help('JHELP_COMPONENTS_FABRIK_GROUPS_EDIT', false, Text::_('JHELP_COMPONENTS_FABRIK_GROUPS_EDIT'));
	}
}
