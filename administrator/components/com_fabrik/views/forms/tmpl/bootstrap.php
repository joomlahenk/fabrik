<?php
/**
 * Admin Forms List Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::_('bootstrap.tooltip');
FabrikHelperHTML::formvalidation();
//HTMLHelper::_('script', 'system/multiselect.js', false, true);
//HTMLHelper::_('script','system/multiselect.js', ['relative' => true]);

//HTMLHelper::_('behavior.multiselect');
//HTMLHelper::_('formbehavior.chosen', 'select');
$wa = $this->document->getWebAssetManager();
$wa->useScript('table.columns')
    ->useScript('multiselect');

$user      = Factory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
?>
<form action="<?php echo Route::_('index.php?option=com_fabrik&view=forms'); ?>" method="post" name="adminForm" id="adminForm">
<div class="row">
<div class="col-sm-12">
	<div id="j-main-container" class="j-main-container">
		<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
			<?php if (empty($this->items)) : ?>
				<div class="alert alert-info">
					<span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
					<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
				</div>
			<?php else : ?>

			<table class="table table-striped">
				<thead>
				<tr>
					<th width="2%">
						<?php echo HTMLHelper::_('grid.sort', '#', 'f.id', $listDirn, $listOrder); ?>
					</th>
					<th width="1%">
						<?php echo HTMLHelper::_('grid.checkall'); ?>
					</th>
					<th width="40%">
						<?php echo HTMLHelper::_('grid.sort', 'COM_FABRIK_LABEL', 'f.label', $listDirn, $listOrder); ?>
					</th>
					<th width="10%">
						<?php echo Text::_('COM_FABRIK_ELEMENT'); ?>
					</th>
					<th width="5%">
						<?php echo Text::_('COM_FABRIK_CONTENT_TYPE'); ?>
					</th>
					<th width="20%">
						<?php echo Text::_('COM_FABRIK_UPDATE_DATABASE'); ?>
					</th>
					<th width="15%">
						<?php echo Text::_('COM_FABRIK_VIEW_DATA'); ?>
					</th>
					<th width="5%">
						<?php echo HTMLHelper::_('grid.sort', 'JPUBLISHED', 'f.published', $listDirn, $listOrder); ?>
					</th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="6">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering    = ($listOrder == 'ordering');
					$link       = Route::_('index.php?option=com_fabrik&task=form.edit&id=' . (int) $item->id);
					$canCreate  = $user->authorise('core.create', 'com_fabrik.form.1');
					$canEdit    = $user->authorise('core.edit', 'com_fabrik.form.1');
					$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
					$canChange  = $user->authorise('core.edit.state', 'com_fabrik.form.1') && $canCheckin;
					$params     = new Registry($item->params);

					$elementLink = Route::_('index.php?option=com_fabrik&task=element.edit&id=0&filter_groupId=' . $item->group_id);
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td><?php echo $item->id; ?></td>
						<td><?php echo HTMLHelper::_('grid.id', $i, $item->id); ?></td>
						<td>
							<?php if ($item->checked_out) : ?>
								<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'forms.', $canCheckin); ?>
							<?php endif; ?>
							<?php
							if ($item->checked_out && ($item->checked_out != $user->get('id')))
							{ ?>
								<span class="editlinktip hasTip"
									title="foo <?php echo Text::_($item->label) . "::" . $params->get('note'); ?>"> <?php echo Text::_($item->label); ?>
								</span>
							<?php }
							else
							{
								?>
								<a href="<?php echo $link; ?>">
									<span class="editlinktip hasTip" title="<?php echo Text::_($item->label) . "::" . $params->get('note'); ?>">
										<?php echo Text::_($item->label); ?>
									</span>
								</a>
							<?php } ?>
						</td>
						<td>
							<a href="<?php echo $elementLink ?>">
								<i class="icon-plus"></i> <?php echo Text::_('COM_FABRIK_ADD'); ?>
							</a>
						</td>
						<td>
							<div class="btn-group">
								
								<button data-bs-toggle="dropdown" class="dropdown-toggle btn btn-sm">
									<span class="caret"></span>
									<span class="element-invisible">Actions for: COM_FABRIK_EXPORT_CONTENT_TYPE</span>
								</button>
								<ul class="dropdown-menu">
									<li>
										<a href="javascript://" onclick="Joomla.listItemTask('cb<?php echo $i; ?>', 'form.createContentType')">
											<span class="icon-upload text-nowrap"> <?php echo Text::_('COM_FABRIK_CONTENT_TYPE_EXPORT'); ?></span>
										</a>
									</li>
									<?php
									if ($params->get('content_type_path', '') !== '') :?>
										<li>
											<a href="index.php?option=com_fabrik&task=form.downloadContentType&cid=<?php echo $item->id; ?>">
												<span class="icon-download text-nowrap"> <?php echo Text::_('COM_FABRIK_CONTENT_TYPE_DOWNLOAD'); ?></span>
											</a>
										</li>
										<?php

									endif;
									?>
								</ul>
							</div>
						</td>
						<td>
							<a href="#edit" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>','forms.updateDatabase')">
								<i class="icon-refresh"></i> <?php echo Text::_('COM_FABRIK_UPDATE_DATABASE'); ?>
							</a>
						</td>
						<td>
							<a href="index.php?option=com_fabrik&task=list.view&listid=<?php echo $item->list_id ?>">
								<i class="icon-list-view"></i> <?php echo Text::_('COM_FABRIK_VIEW_DATA'); ?>
							</a>
						</td>
						<td class="center">
							<?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'forms.', $canChange); ?>
						</td>
					</tr>

				<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>

			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
</form>
