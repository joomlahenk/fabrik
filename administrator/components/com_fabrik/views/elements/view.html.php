<?php
/**
 * View class for a list of elements.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

jimport('joomla.application.component.view');

/**
 * View class for a list of elements.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @since       3.0
 */

class FabrikAdminViewElements extends HtmlView
{
	/**
	 * Elements
	 *
	 * @var  array
	 */
	protected $items;

	/**
	 * Pagination
	 *
	 * @var  Pagination
	 */
	protected $pagination;

	/**
	 * View state
	 *
	 * @var object
	 */
	protected $state;

	/**
	 * The active search filters
	 *
	 * @var  array
	 */
	public $activeFilters;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template
	 *
	 * @return  void
	 */

	public function display($tpl = null)
	{
		if ($this->getLayout() == 'confirmdelete')
		{
			$this->setLayout('bootstrap_confirmdelete');
			$this->confirmdelete();

			return;
		}

		if ($this->getLayout() == 'copyselectgroup')
		{
			$this->copySelectGroup();

			return;
		}
		// Initialise variables.
		$app = Factory::getApplication();
		$input = $app->input;
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->formOptions = $this->get('FormOptions');
		$this->showInListOptions = $this->get('ShowInListOptions');
		$this->groupOptions = $this->get('GroupOptions');
		$this->pluginOptions = $this->get('PluginOptions');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new RuntimeException(implode("\n", $errors), 500);
		}

		FabrikAdminHelper::setViewLayout($this);
		$this->addToolbar();

		FabrikHelperHTML::iniRequireJS();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 */

	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/fabrik.php';
		$canDo = FabrikAdminHelper::getActions($this->state->get('filter.category_id'));

		// Get the toolbar object instance
		$toolbar = Toolbar::getInstance('toolbar');

		ToolbarHelper::title(Text::_('COM_FABRIK_MANAGER_ELEMENTS'), 'checkbox-unchecked');

		if ($canDo->get('core.create'))
		{
			ToolbarHelper::addNew('element.add', 'JTOOLBAR_NEW');
		}

		if ($canDo->get('core.edit'))
		{
			ToolbarHelper::editList('element.edit', 'JTOOLBAR_EDIT');
		}

		ToolbarHelper::custom('elements.copySelectGroup', 'copy.png', 'copy_f2.png', 'COM_FABRIK_COPY');

		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.state') != 2)
			{
				ToolbarHelper::divider();
				ToolbarHelper::custom('elements.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				ToolbarHelper::custom('elements.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}

			ToolbarHelper::divider();
			ToolbarHelper::custom('elements.showInListView', 'publish.png', 'publish_f2.png', 'COM_FABRIK_SHOW_IN_LIST_VIEW', true);
			ToolbarHelper::custom('elements.hideFromListView', 'unpublish.png', 'unpublish_f2.png', 'COM_FABRIK_REMOVE_FROM_LIST_VIEW', true);
		}

		if (Factory::getUser()->authorise('core.manage', 'com_checkin'))
		{
			ToolbarHelper::custom('elements.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			ToolbarHelper::deleteList('', 'elements.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			ToolbarHelper::trash('elements.trash', 'JTOOLBAR_TRASH');
		}

		if ($canDo->get('core.admin'))
		{
			ToolbarHelper::divider();
			ToolbarHelper::preferences('com_fabrik');
		}

		ToolbarHelper::divider();
		ToolbarHelper::help('JHELP_COMPONENTS_FABRIK_ELEMENTS', false, Text::_('JHELP_COMPONENTS_FABRIK_ELEMENTS'));

	}

	/**
	 * Show a screen asking if the user wants to delete the lists forms/groups/elements
	 * and if they want to drop the underlying database table
	 *
	 * @param   string  $tpl  Template
	 *
	 * @return  void
	 */

	protected function confirmdelete($tpl = null)
	{
		$model = $this->getModel();
		$app = Factory::getApplication();
		$input = $app->input;
		$model->setState('filter.cid', $input->get('cid', array(), 'array'));
		$this->items = $this->get('Items');
		$this->addConfirmDeleteToolbar();
		FabrikHelperHTML::iniRequireJS();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar for confirming list deletion
	 *
	 * @return  void
	 */

	protected function addConfirmDeleteToolbar()
	{
		$app = Factory::getApplication();
		$input = $app->input;
		$input->set('hidemainmenu', true);
		ToolbarHelper::title(Text::_('COM_FABRIK_MANAGER_ELEMENT_CONFIRM_DELETE'), 'checkbox-unchecked');
		ToolbarHelper::save('elements.dodelete', 'JTOOLBAR_APPLY');
		ToolbarHelper::cancel('elements.cancel', 'JTOOLBAR_CANCEL');
		ToolbarHelper::divider();
		ToolbarHelper::help('JHELP_COMPONENTS_FABRIK_ELEMENTS_EDIT', true, 'http://www.fabrikar.com/forums/index.php?wiki/element-delete-confirmation/');
	}

	/**
	 * Show a view for selecting which group the element should be copied to
	 *
	 * @param   string  $tpl  Template
	 *
	 * @return  void
	 */

	public function copySelectGroup($tpl = null)
	{
		Session::checkToken() or die('Invalid Token');
		$model = $this->getModel();
		$app = Factory::getApplication();
		$input = $app->input;
		$model->setState('filter.cid', $input->get('cid', array(), 'array'));
		$this->items = $this->get('Items');
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id, name')->from('#__fabrik_groups')->order('name');
		$db->setQuery($query);
		$this->groups = $db->loadObjectList();
		$this->addConfirmCopyToolbar();
		FabrikHelperHTML::iniRequireJS();
		parent::display($tpl);
	}

	/**
	 * Add confirm copy elements toolbar
	 *
	 * @return  void
	 */

	protected function addConfirmCopyToolbar()
	{
		$app = Factory::getApplication();
		$input = $app->input;
		$input->set('hidemainmenu', true);
		ToolbarHelper::title(Text::_('COM_FABRIK_MANAGER_ELEMENT_COPY_TO_WHICH_GROUP'), 'checkbox-unchecked');
		ToolbarHelper::save('element.copy', 'JTOOLBAR_APPLY');
		ToolbarHelper::cancel('elements.cancel', 'JTOOLBAR_CANCEL');
		ToolbarHelper::divider();
		ToolbarHelper::help('JHELP_COMPONENTS_FABRIK_ELEMENTS_EDIT', true, 'http://fabrikar.com/wiki/index.php/Element_copy_confirmation');
	}
}
