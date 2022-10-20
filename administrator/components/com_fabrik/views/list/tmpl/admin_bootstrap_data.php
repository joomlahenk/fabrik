<?php
/**
 * Admin List Tmpl
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
use Joomla\CMS\Factory;

$doc = Factory::getDocument();
$rtlDir = $doc->direction === 'rtl' ? 'left' : 'right';
$rtlDirInv = $doc->direction === 'rtl' ? 'right' : 'left';
?>
<div class="tab-pane" id="data">

	<ul class="nav nav-tabs" id="Fab_List_NavData" role="tablist">
	  <li class="nav-item" role="">
		<button class="nav-link active" id="" data-bs-toggle="tab" data-bs-target="#data-data" type="button" role="tab" aria-controls="" aria-selected="true">
			<?php echo Text::_('COM_FABRIK_DATA'); ?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#data-groupby" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_GROUP_BY')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#data-prefilter" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_PREFILTER')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#table-sliders-data-joins" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_JOINS')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#data-faceted" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_RELATED_DATA')?>
		</button>
	  </li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="data-data">
			<legend></legend>
			<fieldset>
			<?php
			$this->field = $this->form->getField('connection_id');
			echo $this->loadTemplate('control_group');
			if ($this->item->id == 0) :
				$this->field = $this->form->getField('_database_name');
				echo $this->loadTemplate('control_group');
				echo $this->form->getLabel('or');
			endif;
			$this->field = $this->form->getField('db_table_name');
			echo $this->loadTemplate('control_group');
			$this->field = $this->form->getField('db_primary_key');
			echo $this->loadTemplate('control_group');
			$this->field = $this->form->getField('auto_inc');
			echo $this->loadTemplate('control_group');
			 ?>

			<label for="order_by"><?php echo Text::_('COM_FABRIK_FIELD_ORDER_BY_LABEL'); ?></label>
			<div id="orderByTd" style="margin:4px 0 0 2px">
			<?php
			for ($o = 0; $o < count($this->order_by); $o++) : ?>
			<div class="orderby_container " style="margin-bottom:3px;clear:left;display: flex;">
			<?php
				echo FArrayHelper::getValue($this->order_by, $o, $this->order_by[0]);
				if ((int) $this->item->id !== 0) :
					echo FArrayHelper::getValue($this->order_dir, $o)?>
					<div class="btn-group pull-<?php echo $rtlDir; ?>">
						<a class="btn btn-success addOrder" href="#"><i class="icon-plus"></i> </a>
						<a class="btn btn-danger deleteOrder" href="#"><i class="icon-minus"></i> </a>
					</div>
				<?php endif; ?>
			</div>
			<?php endfor; ?>
			</div>
		</fieldset>
		</div>

		<div class="tab-pane" id="data-groupby">
			<legend></legend>
			<fieldset>
			<?php
			foreach ($this->form->getFieldset('grouping') as $this->field):
				echo $this->loadTemplate('control_group');
		 	endforeach;
		 	foreach ($this->form->getFieldset('grouping2') as $this->field):
		 	echo $this->loadTemplate('control_group');
		 	endforeach;
		 	?>
			</fieldset>
		</div>

		<div class="tab-pane" id="data-prefilter">
			<legend></legend>
			<fieldset>
			<legend><?php echo Text::_('COM_FABRIK_PREFILTERS')?></legend>

			 <a class="btn" href="#" onclick="oAdminFilters.addFilterOption(); return false;">
				<i class="icon-plus"></i> <?php echo Text::_('COM_FABRIK_ADD'); ?>
			</a>
			<div id="prefilters" style="padding-top:20px">
				<table class="table table-striped" width="100%">
					<tbody id="filterContainer">
					</tbody>
				</table>
			</div>
			<?php foreach ($this->form->getFieldset('prefilter') as $this->field):
				echo $this->loadTemplate('control_group');
			 endforeach;
			 ?>
			</fieldset>
		</div>

		<div class="tab-pane" id="table-sliders-data-joins">
			<legend></legend>
			<fieldset>
			<legend>
				<?php echo Text::_('COM_FABRIK_JOINS');?>
			</legend>
			<?php if ($this->item->id != 0) { ?>
			<a href="#" id="addAJoin" class="btn">
				<i class="icon-plus"></i>  <?php echo Text::_('COM_FABRIK_ADD'); ?>
			</a>
			<div id="joindtd" style="margin-top:20px"></div>
			<?php
			foreach ($this->form->getFieldset('joins') as $this->field):
				echo $this->loadTemplate('control_group');
			endforeach;
			?>
			<?php
			} else {
					echo Text::_('COM_FABRIK_AVAILABLE_ONCE_SAVED');
			}
			?>
		</fieldset>
		</div>

		<div class="tab-pane" id="data-faceted">
			<legend></legend>
			<fieldset>
				<legend><?php echo Text::_('COM_FABRIK_RELATED_DATA')?></legend>

				<?php foreach ($this->form->getFieldset('facetedlinks2') as $this->field):
					echo $this->loadTemplate('control_group');
				endforeach;
				?>

				<?php
				foreach ($this->form->getFieldset('facetedlinks') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

	</div>

</div>