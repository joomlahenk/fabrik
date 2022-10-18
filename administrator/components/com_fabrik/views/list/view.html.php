<?php
/**
 * View to edit a list.
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
use Joomla\CMS\HTML\HTMLHelper;

jimport('joomla.application.component.view');

/**
 * View to edit a list.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @since       1.5
 */
class FabrikAdminViewList extends HtmlView
{
	/**
	 * List form
	 *
	 * @var Form
	 */
	protected $form;

	/**
	 * List item
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
	 * JS code
	 *
	 * @var string
	 */
	protected $js;

	/**
	 * Display the list
	 *
	 * @param   string $tpl template
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$model      = $this->getModel();
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$formModel  = $this->get('FormModel');
		$formModel->setId($this->item->form_id);
		$this->state = $this->get('State');
		$this->js    = $model->getJs();
		$this->addToolbar();

		if ($this->item->id == 0)
		{
			$this->order_by = array(Text::_('COM_FABRIK_AVAILABLE_AFTER_SAVE'));
			$this->group_by = Text::_('COM_FABRIK_AVAILABLE_AFTER_SAVE');
		}
		else
		{
			$this->order_by = array();
			$feListModel    = $formModel->getListModel();
			$orderBys       = $feListModel->getOrderBys();

			foreach ($orderBys as $orderBy)
			{
//				$this->order_by[] = $formModel->getElementList('order_by[]', $orderBy, true, false, false, 'id');
				$this->order_by[] = $formModel->getElementList('order_by[]', $orderBy, true, false, false, 'id', 'class="form-select" ');
			}

			if (empty($this->order_by))
			{
//				$this->order_by[] = $formModel->getElementList('order_by[]', '', true, false, false, 'id');
				$this->order_by[] = $formModel->getElementList('order_by[]', '', true, false, false, 'id', 'class="form-select" ');
			}

			$orderDir[] = HTMLHelper::_('select.option', 'ASC', Text::_('COM_FABRIK_ASCENDING'));
			$orderDir[] = HTMLHelper::_('select.option', 'DESC', Text::_('COM_FABRIK_DESCENDING'));

			$orderdirs       = FabrikWorker::JSONtoData($this->item->order_dir, true);
			$this->order_dir = array();
//			$attribs         = 'class="inputbox" size="1" ';
			$attribs         = 'class="form-select" ';

			foreach ($orderdirs as $orderdir)
			{
				$this->order_dir[] = HTMLHelper::_('select.genericlist', $orderDir, 'order_dir[]', $attribs, 'value', 'text', $orderdir);
			}

			if (empty($this->order_dir))
			{
				$this->order_dir[] = HTMLHelper::_('select.genericlist', $orderDir, 'order_dir[]', $attribs, 'value', 'text', '');
			}

			$this->group_by = $formModel->getElementList('group_by', $this->item->group_by, true, false, false);
		}

		FabrikAdminHelper::setViewLayout($this);

		$srcs                  = FabrikHelperHTML::framework();
		$srcs['Fabrik']        = FabrikHelperHTML::mediaFile('fabrik.js');
		$srcs['NameSpace']     = 'administrator/components/com_fabrik/views/namespace.js';
		$srcs['PluginManager'] = 'administrator/components/com_fabrik/views/pluginmanager.js';
		$srcs['AdminList']     = 'administrator/components/com_fabrik/views/list/tmpl/adminlist.js';
		$srcs['ListForm']      = 'administrator/components/com_fabrik/views/listform.js';
		$srcs['adminFilters']  = 'administrator/components/com_fabrik/views/list/tmpl/admin-filters.js';

		$shim                              = array();
		$dep                               = new stdClass;
		$dep->deps                         = array('admin/pluginmanager');
		$shim['admin/list/tmpl/adminlist'] = $dep;
		$shim['adminfields/tables']        = $dep;
		FabrikHelperHTML::iniRequireJS($shim);
		FabrikHelperHTML::script($srcs, $this->js);
		parent::display($tpl);

		/* The following is a hack to fix an issue with the list and group admin forms losing
		 * the sidebar menu item above the one the user clicks on before fabrik is fully loaded. 
		 * This hack forces it to redisplay 
		*/
		Factory::getDocument()->addScriptDeclaration('
			function onReady() {
			    var details = document.getElementById("btn-details");
			    if (typeof Fabrik !== "undefined" && details !== null) {
			    	var buttons = ["btn-details", "btn-data", "btn-publishing", "btn-access", "btn-plugins"];
			    	for (var idx = 0; idx < buttons.length; idx++) {
			    		button = document.getElementById(buttons[idx]);
			    		if (button.style.display == "none") button.style.display = "block";
			    	}
			    } else {
			    	setTimeout(onReady, 100);
			    }
			}

			if (document.readyState !== "loading") {
			    onReady();
			} else {
				document.addEventListener("DOMContentLoaded", onReady());
			}'
		);
	}

	/**
	 * Show the list's linked forms etc
	 *
	 * @param   string $tpl template
	 *
	 * @return  void
	 */
	public function showLinkedElements($tpl = null)
	{
		$model = $this->getModel('Form');
		$this->addLinkedElementsToolbar();
		$this->formGroupEls = $model->getFormGroups(false);
		$this->formTable    = $model->getForm();
		FabrikHelperHTML::iniRequireJS();
		parent::display($tpl);
	}

	/**
	 * See if the user wants to rename the list/form/groups
	 *
	 * @param   string $tpl template
	 *
	 * @return  void
	 */
	public function confirmCopy($tpl = null)
	{
		$app   = Factory::getApplication();
		$input = $app->input;
		$cid   = $input->get('cid', array(0), 'array');
		$lists = array();
		$model = $this->getModel();

		foreach ($cid as $id)
		{
			$model->setId($id);
			$table          = $model->getTable();
			$formModel      = $model->getFormModel();
			$row            = new stdClass;
			$row->id        = $id;
			$row->formid    = $table->form_id;
			$row->label     = $table->label;
			$row->formlabel = $formModel->getForm()->label;
			$groups         = $formModel->getGroupsHiarachy();
			$row->groups    = array();

			foreach ($groups as $group)
			{
				$grouprow       = new stdClass;
				$g              = $group->getGroup();
				$grouprow->id   = $g->id;
				$grouprow->name = $g->name;
				$row->groups[]  = $grouprow;
			}

			$lists[] = $row;
		}

		$this->lists = $lists;
		$this->addConfirmCopyToolbar();
		FabrikHelperHTML::iniRequireJS();
		parent::display($tpl);
	}

	/**
	 * Once a list is saved - we need to display the select content type form.
	 *
	 * @param null $tpl
	 *
	 * @return void
	 */
	public function selectContentType($tpl = null)
	{
		$model      = $this->getModel();
		$this->form = $model->getContentTypeForm();
		$input      = Factory::getApplication()->input;
		$this->data = $input->post->get('jform', array(), 'array');
		$this->addSelectSaveToolBar();
		FabrikHelperHTML::framework();
		FabrikHelperHTML::iniRequireJS();

		parent::display($tpl);
	}

	/**
	 * Add select content type tool bar
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	protected function addSelectSaveToolBar()
	{
		$app         = Factory::getApplication();
		$this->state = $this->get('State');
		$input       = $app->input;
		$input->set('hidemainmenu', true);
		$canDo = FabrikAdminHelper::getActions($this->state->get('filter.category_id'));
		ToolBarHelper::title(Text::_('COM_FABRIK_MANAGER_SELECT_CONTENT_TYPE'), 'puzzle');

		// For new records, check the create permission.
		if ($canDo->get('core.create'))
		{
			ToolBarHelper::apply('list.doSave', 'JTOOLBAR_SAVE');
			ToolBarHelper::cancel('list.cancel', 'JTOOLBAR_CANCEL');
		}
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 */
	protected function addToolbar()
	{
		$app   = Factory::getApplication();
		$input = $app->input;
		$input->set('hidemainmenu', true);
		$user       = Factory::getUser();
		$userId     = $user->get('id');
		$isNew      = ($this->item->id == 0);
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo      = FabrikAdminHelper::getActions($this->state->get('filter.category_id'));
		$title      = $isNew ? Text::_('COM_FABRIK_MANAGER_LIST_NEW') : Text::_('COM_FABRIK_MANAGER_LIST_EDIT') . ' "' . $this->item->label . '"';
		ToolBarHelper::title($title, 'list');

		if ($isNew)
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create'))
			{
				ToolBarHelper::apply('list.apply', 'JTOOLBAR_APPLY');
				ToolBarHelper::save('list.save', 'JTOOLBAR_SAVE');
				ToolBarHelper::addNew('list.save2new', 'JTOOLBAR_SAVE_AND_NEW');
			}

			ToolBarHelper::cancel('list.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			// Can't save the record if it's checked out.
			if (!$checkedOut)
			{
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					ToolBarHelper::apply('list.apply', 'JTOOLBAR_APPLY');
					ToolBarHelper::save('list.save', 'JTOOLBAR_SAVE');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($canDo->get('core.create'))
					{
						ToolBarHelper::addNew('list.save2new', 'JTOOLBAR_SAVE_AND_NEW');
					}
				}
			}
			// If checked out, we can still save
			if ($canDo->get('core.create'))
			{
				ToolBarHelper::custom('list.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}

			ToolBarHelper::cancel('list.cancel', 'JTOOLBAR_CLOSE');
		}

		ToolBarHelper::divider();
		ToolBarHelper::help('JHELP_COMPONENTS_FABRIK_LISTS_EDIT', false, Text::_('JHELP_COMPONENTS_FABRIK_LISTS_EDIT'));
	}

	/**
	 * Add the page title and toolbar for the linked elements page
	 *
	 * @return  void
	 */
	protected function addLinkedElementsToolbar()
	{
		$app   = Factory::getApplication();
		$input = $app->input;
		$input->set('hidemainmenu', true);
		ToolBarHelper::title(Text::_('COM_FABRIK_MANAGER_LIST_LINKED_ELEMENTS'), 'list');
		ToolBarHelper::cancel('list.cancel', 'JTOOLBAR_CLOSE');
		ToolBarHelper::divider();
		ToolBarHelper::help('JHELP_COMPONENTS_FABRIK_LISTS_EDIT');
	}

	/**
	 * Add the page title and toolbar for the confirm copy page
	 *
	 * @return  void
	 */
	protected function addConfirmCopyToolbar()
	{
		$app   = Factory::getApplication();
		$input = $app->input;
		$input->set('hidemainmenu', true);
		ToolBarHelper::title(Text::_('COM_FABRIK_MANAGER_LIST_COPY'), 'list');
		ToolBarHelper::cancel('list.cancel', 'JTOOLBAR_CLOSE');
		ToolBarHelper::save('list.doCopy', 'JTOOLBAR_SAVE');
		ToolBarHelper::divider();
		ToolBarHelper::help('JHELP_COMPONENTS_FABRIK_LISTS_EDIT');
	}
}
