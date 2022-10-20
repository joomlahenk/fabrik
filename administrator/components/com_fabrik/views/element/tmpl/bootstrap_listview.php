<?php
/**
 * Admin Element Edit - List view Tmpl
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

?>
<div class="tab-pane" id="tab-listview">
	<legend><?php echo Text::_('COM_FABRIK_LIST_VIEW_SETTINGS');?></legend>

	<ul class="nav nav-tabs" id="Fab_Elem_NavListview" role="tablist">
		<li class="nav-item" role="">
			<button class="nav-link active" id="" data-bs-toggle="tab" data-bs-target="#listview-details" type="button" role="tab" aria-controls="" aria-selected="true">
				<?php echo Text::_('COM_FABRIK_ELEMENT_LABEL_LIST_SETTINGS_DETAILS'); ?>
			</button>
		</li>
		<li class="nav-item" role="">
			<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#listview-icons" type="button" role="tab" aria-controls="" aria-selected="true">
				<?php echo Text::_('COM_FABRIK_ELEMENT_LABEL_ICONS_SETTINGS_DETAILS'); ?>
			</button>
		</li>
		<li class="nav-item" role="">
			<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#listview-filters" type="button" role="tab" aria-controls="" aria-selected="true">
				<?php echo Text::_('COM_FABRIK_ELEMENT_LABEL_FILTERS_DETAILS'); ?>
			</button>
		</li>
		<li class="nav-item" role="">
			<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#listview-css" type="button" role="tab" aria-controls="" aria-selected="true">
				<?php echo Text::_('COM_FABRIK_ELEMENT_LABEL_CSS_DETAILS'); ?>
			</button>
		</li>
		<li class="nav-item" role="">
			<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#listview-calculations" type="button" role="tab" aria-controls="" aria-selected="true">
				<?php echo Text::_('COM_FABRIK_ELEMENT_LABEL_CALCULATIONS_DETAILS'); ?>
			</button>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="listview-details">
		    <fieldset>
				<?php foreach ($this->form->getFieldset('listsettings') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
				<?php foreach ($this->form->getFieldset('listsettings2') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="listview-icons">
			<fieldset>
				<?php foreach ($this->form->getFieldset('icons') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="listview-filters">
			<fieldset>
				<?php foreach ($this->form->getFieldset('filters') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
				<?php foreach ($this->form->getFieldset('filters2') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="listview-css">
			<fieldset>
				<?php foreach ($this->form->getFieldset('viewcss') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="listview-calculations">
			<fieldset class="row">
				<div class="col-sm-6">
				<?php
				$fieldsets = $this->form->getFieldsets();
				$cals = array('calculations-sum', 'calculations-avg', 'calculations-median');
				foreach ($cals as $cal) :?>
					<legend><?php echo Text::_($fieldsets[$cal]->label); ?></legend>
					<?php foreach ($this->form->getFieldset($cal) as $this->field) :
						echo $this->loadTemplate('control_group');
					endforeach;
				endforeach;
				?>
				</div>
				<div class="col-sm-6">
				<?php
				$cals = array('calculations-count', 'calculations-custom');
				foreach ($cals as $cal) :?>
					<legend><?php echo Text::_($fieldsets[$cal]->label); ?></legend>
					<?php foreach ($this->form->getFieldset($cal) as $this->field) :
						echo $this->loadTemplate('control_group');
					endforeach;
				endforeach;
				?>
				</div>
			</fieldset>
		</div>
	</div>
</div>
