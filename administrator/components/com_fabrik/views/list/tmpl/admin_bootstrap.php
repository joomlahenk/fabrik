<?php
/**
 * Admin List Edit Tmpl
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
<script type="text/javascript">

	Joomla.submitbutton = function(task) {
		requirejs(['fab/fabrik'], function (Fabrik) {
			if (task !== 'list.cancel' && !Fabrik.controller.canSaveForm()) {
				window.alert('Please wait - still loading');
				return false;
			}
			if (task == 'list.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
				window.fireEvent('form.save');
				Joomla.submitform(task, document.getElementById('adminForm'));
			} else {
				window.alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
			}
		});
	}
</script>

<form action="<?php Route::_('index.php?option=com_fabrik'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row main-card-columns">
		<div class="col-sm-2" id="sidebar">
			<div class="nav flex-column nav-pills">
				<button class="nav-link active" id="" data-bs-toggle="pill" data-bs-target="#detailsX" type="button" role="tab" aria-controls="" aria-selected="true">
					<?php echo Text::_('COM_FABRIK_DETAILS')?>
				</button>
				<button class="nav-link" id="" data-bs-toggle="pill" data-bs-target="#data" type="button" role="tab" aria-controls="" aria-selected="false">
					<?php echo Text::_('COM_FABRIK_DATA')?>
				</button>
				<button class="nav-link" id="" data-bs-toggle="pill" data-bs-target="#publishing" type="button" role="tab" aria-controls="" aria-selected="false">
					<?php echo Text::_('COM_FABRIK_GROUP_LABEL_PUBLISHING_DETAILS')?>
				</button>
				<button class="nav-link" id="" data-bs-toggle="pill" data-bs-target="#access" type="button" role="tab" aria-controls="" aria-selected="false">
					<?php echo Text::_('COM_FABRIK_GROUP_LABEL_RULES_DETAILS')?>
				</button>
				<button class="nav-link" id="" data-bs-toggle="pill" data-bs-target="#tabplugins" type="button" role="tab" aria-controls="" aria-selected="false">
					<?php echo Text::_('COM_FABRIK_GROUP_LABEL_PLUGINS_DETAILS')?>
				</button>
			</div>
		</div>
		<div class="col-sm-10" id="config">
			<div class="tab-content">
				<?php
				echo $this->loadTemplate('details');
				echo $this->loadTemplate('data');
				echo $this->loadTemplate('publishing');
				echo $this->loadTemplate('plugins');
				echo $this->loadTemplate('access');
				?>
			</div>

			<input type="hidden" name="task" value="" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
	</div>
</form>
