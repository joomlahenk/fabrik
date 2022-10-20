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

?>
<div class="tab-pane" id="publishing">

	<ul class="nav nav-tabs" id="Fab_List_NavPublishing" role="tablist">
	  <li class="nav-item" role="">
		<button class="nav-link active" id="" data-bs-toggle="tab" data-bs-target="#publishing-details" type="button" role="tab" aria-controls="" aria-selected="true">
			<?php echo Text::_('COM_FABRIK_GROUP_LABEL_PUBLISHING_DETAILS'); ?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#publishing-rss" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_GROUP_LABEL_RSS')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#publishing-csv" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_GROUP_LABEL_CSV')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#publishing-oai" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_OPEN_ARCHIVE_INITIATIVE'); ?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#publishing-search" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_GROUP_LABEL_SEARCH')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="" data-bs-toggle="tab" data-bs-target="#publishing-dashboard" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_ADMIN_DASHBOARD')?>
		</button>
	  </li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="publishing-details">
			<legend></legend>
		    <fieldset>
				<?php foreach ($this->form->getFieldset('publishing-details') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="publishing-rss">
			<legend></legend>
			<fieldset>
				<?php foreach ($this->form->getFieldset('rss') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="publishing-csv">
			<legend></legend>
			<fieldset>
				<?php
				foreach ($this->form->getFieldset('csv') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				foreach ($this->form->getFieldset('csvauto') as $this->field) :
				echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="publishing-oai">
			<fieldset>
				<div class="alert"><?php echo Text::_('COM_FABRIK_OPEN_ARCHIVE_INITIATIVE'); ?></div>
				<?php foreach ($this->form->getFieldset('open_archive_initiative') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="publishing-search">
			<fieldset>
				<div class="alert"><?php echo Text::_('COM_FABRIK_SPECIFY_ELEMENTS_IN_DETAILS_FILTERS'); ?></div>
				<?php foreach ($this->form->getFieldset('search') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="publishing-dashboard">
			<legend></legend>
			<fieldset>
				<?php foreach ($this->form->getFieldset('dashboard') as $this->field) :
					echo $this->loadTemplate('control_group');
				endforeach;
				?>
			</fieldset>
		</div>

	</div>
</div>
