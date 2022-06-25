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
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHTML::stylesheet('administrator/components/com_fabrik/views/fabrikadmin.css');
HTMLHelper::_('bootstrap.tooltip');
// JHtmlBehavior::framework is deprecated. Update to jquery scripts. HOW??
//HTMLHelper::_('behavior.framework', true);
$debug = JDEBUG;
HTMLHelper::_('script', 'system/mootools-core.js', array('version' => 'auto', 'relative' => true, 'detectDebug' => $debug));
HTMLHelper::_('script', 'system/mootools-more.js', array('version' => 'auto', 'relative' => true, 'detectDebug' => $debug));
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
			var msg = '';
			var jsEvents = document.getElements('select[name*=action]').get('value');
			if (jsEvents.length > 0 && jsEvents.contains('')) {
				msg += '\n ' + Joomla.Text._('COM_FABRIK_ERR_ELEMENT_JS_ACTION_NOT_DEFINED');
			}
			if (task == 'element.cancel' || (msg === '' && document.formvalidator.isValid(document.id('adminForm')))) {
				window.fireEvent('form.save');
				Joomla.submitform(task, document.getElementById('adminForm'));
			} else {
				window.alert('<?php echo $this->escape(FText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>' + msg);
			}
		});
	}
</script>
<form action="<?php Route::_('index.php?option=com_fabrik'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

<?php if ($this->item->parent_id != 0)
{
	?>
	<div id="system-message">
	<dl>
		<dd class="notice">
		<ul>
			<li>
				<?php echo FText::_('COM_FABRIK_ELEMENT_PROPERTIES_LINKED_TO') ?>:
			</li>
			<li>
				<a href="#" id="swapToParent" class="element_<?php echo $this->parent->id ?>"><?php echo $this->parent->label ?></a>
			</li>
			<li>
				<label><input id="unlink" name="unlink" id="unlinkFromParent" type="checkbox"> <?php echo FText::_('COM_FABRIK_UNLINK') ?></label>
			</li>
		</ul>
		</dd>
	</dl>
	</div>
<?php
}?>
<div id="elementFormTable">
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend><?php echo FText::_('COM_FABRIK_DETAILS');?></legend>
			<input type="hidden" id="name_orig" name="name_orig" value="<?php echo $this->item->name; ?>" />
			<input type="hidden" id="plugin_orig" name="plugin_orig" value="<?php echo $this->item->plugin; ?>" />
			<ul class="adminformlist">
				<li>
					<?php echo $this->form->getLabel('css') . $this->form->getInput('css'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('name') . $this->form->getInput('name'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('label') . $this->form->getInput('label'); ?>
				</li>

				<?php foreach ($this->form->getFieldset('details2') as $field) :?>
				<li>
					<?php echo $field->label;
					echo $field->input; ?>
				</li>
				<?php endforeach;?>

				<li>
					<?php echo $this->form->getLabel('plugin') . $this->form->getInput('plugin'); ?>
				</li>
			</ul>
			<div class="clr"> </div>
		</fieldset>

		<div style="margin:10px">
			<?php echo HTMLHelper::_('sliders.start', 'element-sliders-options', array('useCookie' => 1));
			echo HTMLHelper::_('sliders.panel', FText::_('COM_FABRIK_OPTIONS'), 'options-details');
			echo "<div id=\"plugin-container\">$this->pluginFields</div>";
			echo HTMLHelper::_('sliders.end'); ?>
		</div>
	</div>

	<div class="width-50 fltrt">
		<?php echo HTMLHelper::_('tabs.start', 'element', array('useCookie' => 1));
			echo $this->loadTemplate('publishing');
			echo $this->loadTemplate('access');
			echo $this->loadTemplate('settings');
			echo $this->loadTemplate('validations');
			echo $this->loadTemplate('javascript');
		echo HTMLHelper::_('tabs.end'); ?>
	</div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="redirectto" value="" />
	<?php echo HTMLHelper::_('form.token'); ?>
	</div>
</form>
