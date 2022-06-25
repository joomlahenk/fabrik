<?php
/**
 * Admin Visualization Edit Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHTML::stylesheet('administrator/components/com_fabrik/views/fabrikadmin.css');
HTMLHelper::_('behavior.tooltip');
FabrikHelperHTML::formvalidation();
HTMLHelper::_('behavior.keepalive');
?>

<form action="<?php Route::_('index.php?option=com_fabik'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend><?php echo FText::_('COM_FABRIK_DETAILS');?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('details') as $field): ?>
				<li>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				</li>
			<?php endforeach; ?>
			</ul>

		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo FText::_('COM_FABRIK_OPTIONS');?></legend>
			<div id="plugin-container">
				<?php echo $this->pluginFields;?>
			</div>
		</fieldset>
	</div>

<div class="width-50 fltrt">

	<?php echo HTMLHelper::_('sliders.start','list-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
	<?php echo HTMLHelper::_('sliders.panel', FText::_('COM_FABRIK_GROUP_LABEL_PUBLISHING_DETAILS'), 'details');?>

		<fieldset class="adminform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('publishing') as $field): ?>
				<li>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</fieldset>

		<?php echo HTMLHelper::_('sliders.panel', FText::_('COM_FABRIK_VISUALIZATION_LABEL_VISUALIZATION_DETAILS'), 'more');  ?>
		<fieldset class="adminform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('more') as $field): ?>
				<li>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</fieldset>
		<?php echo HTMLHelper::_('sliders.end');?>
</div>

	<input type="hidden" name="task" value="" />
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
