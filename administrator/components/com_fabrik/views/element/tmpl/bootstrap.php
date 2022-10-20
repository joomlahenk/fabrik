<?php
/**
 * Admin Element Edit Tmpl
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
$wa->useScript('jquery');
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::stylesheet('administrator/components/com_fabrik/views/fabrikadmin.css');
HTMLHelper::_('bootstrap.tooltip');
//$debug = JDEBUG;// maybe use later
//HTMLHelper::_('script', 'media/com_fabrik/js/mootools-core.js');
//HTMLHelper::_('script', 'media/com_fabrik/js/mootools-more.js');
FabrikHelperHTML::formvalidation();
HTMLHelper::_('behavior.keepalive');

Text::script('COM_FABRIK_SUBOPTS_VALUES_ERROR');
?>

<script type="text/javascript">

	Joomla.submitbutton = function(task) {
		requirejs(['fab/fabrik'], function (Fabrik) {
			if (task !== 'element.cancel' && !Fabrik.controller.canSaveForm()) {
				window.alert('Please wait - still loading');
				return false;
			}
			if (task == 'element.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
				window.fireEvent('form.save');
				Joomla.submitform(task, document.getElementById('adminForm'));
			} else {
				window.alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
			}
		});
	}
</script>
<form action="<?php JRoute::_('index.php?option=com_fabrik'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

<?php if ($this->item->parent_id != 0)
{
	?>
	<div id="system-message" class="alert alert-notice">
		<strong><?php echo Text::_('COM_FABRIK_ELEMENT_PROPERTIES_LINKED_TO') ?>: <?php echo $this->parent->label ?></strong>

		<p><a href="#" id="swapToParent" class="element_<?php echo $this->parent->id ?>"><span class="icon-pencil"></span>
		<?php echo Text::_('COM_FABRIK_EDIT') . ' ' . $this->parent->label ?></a></p>

		<label><?php echo Text::_('COM_FABRIK_OR')?> <span class="icon-magnet"></span>
		<input id="unlink" name="unlink" id="unlinkFromParent" type="checkbox"> <?php echo Text::_('COM_FABRIK_UNLINK') ?>
		</label>
	</div>
<?php
}?>
<div class="row" id="elementFormTable">
	<ul class="nav nav-tabs" id="Fab_Elem_Nav" role="tablist">
	  <li class="nav-item" role="">
		<button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#tab-details" type="button" role="tab" aria-controls="" aria-selected="true">
			<?php echo Text::_('COM_FABRIK_DETAILS'); ?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="publishing-tab" data-bs-toggle="tab" data-bs-target="#tab-publishing" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_GROUP_LABEL_PUBLISHING_DETAILS')?>
		</button>
	</li>


	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="access-tab" data-bs-toggle="tab" data-bs-target="#tab-access" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_GROUP_LABEL_RULES_DETAILS')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="listview-tab" data-bs-toggle="tab" data-bs-target="#tab-listview" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_LIST_VIEW_SETTINGS')?>
		</button>
	  </li>
	  <li class="nav-item" role="">
		<button class="nav-link" id="validations-tab" data-bs-toggle="tab" data-bs-target="#tab-validations" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_VALIDATIONS')?>
		</button>
		<li class="nav-item" role="">
		<button class="nav-link" id="js-tab" data-bs-toggle="tab" data-bs-target="#tab-javascript" type="button" role="tab" aria-controls="" aria-selected="false">
			<?php echo Text::_('COM_FABRIK_JAVASCRIPT')?>
		</button>
	  </li>
	  </li>
	</ul>
		<div class="col-sm-10 tab-content">
			<?php
			echo $this->loadTemplate('details');
			echo $this->loadTemplate('publishing');
			echo $this->loadTemplate('access');
			echo $this->loadTemplate('listview');
			echo $this->loadTemplate('validations');
			echo $this->loadTemplate('javascript');
			?>
		</div>
</div>	

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="redirectto" value="" />
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
