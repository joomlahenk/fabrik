<?php
/**
 * Admin Group Edit Tmpl
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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('jquery');HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::stylesheet('administrator/components/com_fabrik/views/fabrikadmin.css');
HTMLHelper::_('bootstrap.tooltip');
FabrikHelperHTML::formvalidation();
HTMLHelper::_('behavior.keepalive');

?>

<form action="<?php Route::_('index.php?option=com_fabrik'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row main-card-columns">
		<div class="col-sm-2" id="sidebar">
			<div class="nav flex-column nav-pills">
				<button class="nav-link active" id="btn-details" data-bs-toggle="pill" data-bs-target="#details-info" type="button" role="tab" aria-controls="" aria-selected="true">
					<?php echo Text::_('COM_FABRIK_DETAILS')?>
				</button>
				<button class="nav-link" id="btn-repeat" data-bs-toggle="pill" data-bs-target="#details-repeat" type="button" role="tab" aria-controls="" aria-selected="true">
					<?php echo Text::_('COM_FABRIK_REPEAT')?>
				</button>
				<button class="nav-link" id="btn-layout" data-bs-toggle="pill" data-bs-target="#details-layout" type="button" role="tab" aria-controls="" aria-selected="true">
					<?php echo Text::_('COM_FABRIK_LAYOUT')?>
				</button>
				<button class="nav-link" id="btn-multipage" data-bs-toggle="pill" data-bs-target="#details-multipage" type="button" role="tab" aria-controls="" aria-selected="true">
					<?php echo Text::_('COM_FABRIK_GROUP_MULTIPAGE')?>
				</button>
			</div>
		</div>
		<div class="col-sm-10" id="config">

			<div class="tab-content">

				<div class="tab-pane active" id="details-info">
					<fieldset>
						<legend>
							<?php echo Text::_('COM_FABRIK_DETAILS');?>
						</legend>
						<?php foreach ($this->form->getFieldset('details') as $this->field) :
							echo $this->loadTemplate('control_group');
						endforeach;
						foreach ($this->form->getFieldset('details2') as $this->field) :
							echo $this->loadTemplate('control_group');
						endforeach;
						?>
					</fieldset>
				</div>

				<div class="tab-pane" id="details-repeat">
					<fieldset>
						<legend>
							<?php echo Text::_('COM_FABRIK_REPEAT');?>
						</legend>
						<?php foreach ($this->form->getFieldset('repeat') as $this->field) :
							echo $this->loadTemplate('control_group');
						endforeach;
						?>
					</fieldset>
				</div>

				<div class="tab-pane" id="details-layout">
					<fieldset>
						<legend>
							<?php echo Text::_('COM_FABRIK_LAYOUT');?>
						</legend>
						<?php foreach ($this->form->getFieldset('layout') as $this->field) :
							echo $this->loadTemplate('control_group');
						endforeach;
						?>
					</fieldset>
				</div>

				<div class="tab-pane" id="details-multipage">
					<fieldset>
						<legend>
							<?php echo Text::_('COM_FABRIK_GROUP_MULTIPAGE');?>
						</legend>
						<?php foreach ($this->form->getFieldset('pagination') as $this->field) :
							echo $this->loadTemplate('control_group');
						endforeach;
						?>
					</fieldset>
				</div>
			</div>

			<input type="hidden" name="task" value="" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
	</div>
</form>
