<?php
/**
 * Admin Elements List Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
//JHTML::_('script', 'system/multiselect.js', false, true);
JHTML::_('script','system/multiselect.js', ['relative' => true]);
$config = JComponentHelper::getParams('com_fabrik');
$truncateOpts = array(
    'chars' => true,
    'html' => false,
    'wordcount' => (int)$config->get('fabrik_truncate_length', 0),
    'tip' =>false
);
$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$saveOrder	= $listOrder == 'e.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_fabrik&task=elements.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'elementList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$states	= array(
		1	=> array(
				'hideFromListView',
				'COM_FABRIK_SHOW_IN_LIST',
				'COM_FABRIK_REMOVE_FROM_LIST_VIEW',
				'COM_FABRIK_SHOW_IN_LIST',
				false,
				'publish',
				'publish'
		),
		0	=> array(
				'showInListView',
				'COM_FABRIK_REMOVE_FROM_LIST_VIEW',
				'COM_FABRIK_SHOW_IN_LIST',
				'COM_FABRIK_REMOVE_FROM_LIST_VIEW',
				false,
				'unpublish',
				'unpublish'
		),
);

?>
<form action="<?php echo JRoute::_('index.php?option=com_fabrik&view=elements'); ?>" method="post" name="adminForm" id="adminForm">
<div class="row">
<div class="col-md-12">
	<div id="j-main-container" class="j-main-container">
		<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

	<table class="table table-striped" id="elementList">
		<thead>
			<tr>
				<th width="4%">
					<?php echo JHTML::_('grid.sort', 'JGRID_HEADING_ID', 'e.id', $listDirn, $listOrder); ?>
				</th>

				<th width="30px">
					<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'e.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
				</th>
				<th width="30px">&nbsp;&nbsp;&nbsp;</th>
				<th width="30px"><input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" /></th>

				<th width="13%" >
					<?php echo JHTML::_('grid.sort', 'COM_FABRIK_NAME', 'e.name', $listDirn, $listOrder); ?>
				</th>
				<th width="15%">
					<?php echo JHTML::_('grid.sort', 'COM_FABRIK_LABEL', 'e.label', $listDirn, $listOrder); ?>
				</th>
				<th width="17%">
					<?php echo FText::_('COM_FABRIK_FULL_ELEMENT_NAME');?>
				</th>
				<th width="5%">
					<?php echo FText::_('COM_FABRIK_VALIDATIONS'); ?>
				</th>
				<th width="10%">
				<?php echo JHTML::_('grid.sort', 'COM_FABRIK_GROUP', 'g.name', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHTML::_('grid.sort', 'COM_FABRIK_PLUGIN', 'e.plugin', $listDirn, $listOrder); ?>
				</th>
				<th width="7%">
					<?php echo JHTML::_('grid.sort', 'COM_FABRIK_SHOW_IN_LIST', 'e.show_in_list_summary', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
				<?php echo JHTML::_('grid.sort', 'JPUBLISHED', 'e.published', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="12">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$ordering	= ($listOrder == 'e.ordering');
			$link = JRoute::_('index.php?option=com_fabrik&task=element.edit&id='.(int) $item->id);
			$canCreate	= $user->authorise('core.create',		'com_fabrik.element.'.$item->group_id);
			$canEdit	= $user->authorise('core.edit',			'com_fabrik.element.'.$item->group_id);
			$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
			$canChange	= $user->authorise('core.edit.state',	'com_fabrik.element.'.$item->group_id) && $canCheckin;
			$extraTip = '<strong>' . $item->numValidations . ' ' . FText::_('COM_FABRIK_VALIDATIONS') . '</strong><br />'
				. implode('<br />', $item->validationTip)
				. '<br/><br/><strong>' . $item->numJs . ' ' . FText::_('COM_FABRIK_JAVASCRIPT') . '</strong>';
			?>

			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<?php echo $item->id; ?>
				</td>
				<td>
				<?php if ($canChange) :
						$disableClassName = '';
						$disabledLabel	  = '';

						if (!$saveOrder) :
							$disabledLabel    = FText::_('JORDERINGDISABLED');
							$disableClassName = 'inactive tip-top';
						endif; ?>
						<span class="sortable-handler hasTooltip <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
					<?php else : ?>
						<span class="sortable-handler inactive" >
							<i class="icon-menu"></i>
						</span>
				<?php endif; ?>
				</td>
				<td>
				<?php if ($item->parent_id != 0) :
					echo "<a href='index.php?option=com_fabrik&task=element.edit&id=" . $item->parent_id . "'>"
					. JHTML::image('media/com_fabrik/images/child_element.png', JText::sprintf('COM_FABRIK_LINKED_ELEMENT', $item->parent_id), 'title="' . JText::sprintf('COM_FABRIK_LINKED_ELEMENT', $item->parent_id) . '"')
					. '</a>&nbsp;';
				else :
					if (!empty($item->child_ids)) :
						echo JHTML::image('media/com_fabrik/images/parent_element.png', JText::sprintf('COM_FABRIK_PARENT_ELEMENT', $item->child_ids), 'title="' . JText::sprintf('COM_FABRIK_PARENT_ELEMENT', $item->child_ids) . '"');
					else :
						// Trying out removing the icon all together if it isn't linked
						// echo JHTML::image('media/com_fabrik/images/element.png', FText::_('COM_FABRIK_NONLINKED_ELEMENT'), 'title="' . FText::_('COM_FABRIK_NONLINKED_ELEMENT') . '"');
					endif;
				endif;
				?>
				</td>
				<td>
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td>
					<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'elements.', $canCheckin); ?>
					<?php endif; ?>
					<?php
					if ($item->checked_out && ($item->checked_out != $user->get('id'))) :
						echo  $item->name;
					else :
					?>
					<a href="<?php echo $link; ?>">
						<?php echo $item->name; ?>
					</a>
				<?php endif;
				?>
				</td>
				<td>
					<?php echo str_replace(' ', '&nbsp;', FText::_(FabrikString::truncate($item->label, $truncateOpts))); ?>
				</td>
				<td>
					<span class="hasTooltip" title="<?php echo '<strong>' . $item->name . "</strong><br />" . $item->tip; ?>">
						<?php echo $item->full_element_name; ?>
					</span>
				</td>
				<td class="center">
					<span class="hasTooltip" title="<?php echo $extraTip ?>">
						<?php echo $item->numValidations . '/' . $item->numJs; ?>
					</span>
				</td>
				<td>
					<a href="index.php?option=com_fabrik&task=group.edit&id=<?php echo $item->group_id?>">
						<?php echo $item->group_name; ?>
					</a>
				</td>
				<td>
					<?php echo $item->plugin; ?>
				</td>
				<td class="center">
					<?php
					echo JHtml::_('jgrid.state', $states, $item->show_in_list_summary, $i, 'elements.', true, true);
					?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'elements.', $canChange);?>
				</td>
			</tr>

			<?php endforeach; ?>
		</tbody>
	</table>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
