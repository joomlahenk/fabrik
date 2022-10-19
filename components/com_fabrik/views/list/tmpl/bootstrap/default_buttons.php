<?php
/**
 * Bootstrap List Template - Buttons
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.1
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

?>
<div class="col-sm-8">
	<div class="fabrikButtonsContainer">
		<div class="row row-cols-auto align-items-start">
			<?php if ($this->showAdd) :?>
				<div class="col pe-1">
					<button type="button" class="btn"><a class="addbutton addRecord" href="<?php echo $this->addRecordLink;?>">
						<?php echo FabrikHelperHTML::icon('icon-plus', $this->addLabel);?>
					</a></button>
				</div>
			<?php endif; ?>
				<?php if ($this->showToggleCols) :?>
					<div>
						<?php echo $this->loadTemplate('togglecols');?>
					</div>
				<?php endif; ?>
			<div class="col px-1" style="padding-top:8px">
				<ul class="nav nav-pills">
				<?php
				if ($this->canGroupBy) :

					$displayData = new stdClass;
					$displayData->icon = FabrikHelperHTML::icon('icon-list-view');
					$displayData->label = Text::_('COM_FABRIK_GROUP_BY');
					$displayData->links = array();
					foreach ($this->groupByHeadings as $url => $obj) :
						$displayData->links[] = '<a data-groupby="' . $obj->group_by . '" href="' . $url . '">' . $obj->label . '</a>';
					endforeach;

					$layout = $this->getModel()->getLayout('fabrik-nav-dropdown');
					echo $layout->render($displayData);
					?>
				</ul>
			</div>

			<?php endif;
			if (($this->showClearFilters && (($this->filterMode === 3 || $this->filterMode === 4))  || $this->bootShowFilters == false)) :
				$clearFiltersClass = $this->gotOptionalFilters ? "clearFilters hasFilters" : "clearFilters"; ?>
				<div class="col px-0">
					<button class="btn">
						<a class="<?php echo $clearFiltersClass; ?>" href="#">
							<?php echo FabrikHelperHTML::icon('icon-refresh', Text::_('COM_FABRIK_CLEAR'));?>
						</a>
					</button>
				</div>	
			<?php endif;
			if ($this->showFilters && $this->toggleFilters) :?>
			<div class="col px-1">
				<button class="btn">
					<?php if ($this->filterMode === 5) :
					?>
						<a href="#filter_modal" data-bs-toggle="modal">
							<?php echo $this->buttons->filter;?>
							<span><?php echo Text::_('COM_FABRIK_FILTER');?></span>
						</a>
							<?php
					else:
					?>
					<a href="#" class="toggleFilters" data-filter-mode="<?php echo $this->filterMode;?>">
						<?php echo $this->buttons->filter;?>
						<span><?php echo Text::_('COM_FABRIK_FILTER');?></span>
					</a>
						<?php endif;
					?>
				</button>
			</div>	
			<?php endif;
			if ($this->advancedSearch !== '') : ?>
			<div class="col px-1">
				<button class="btn">
					<a href="<?php echo $this->advancedSearchURL?>" class="advanced-search-link">
						<?php echo FabrikHelperHTML::icon('icon-search', Text::_('COM_FABRIK_ADVANCED_SEARCH'));?>
					</a>
				</button>
			</div>
			<?php endif;
			if ($this->showCSVImport || $this->showCSV) :?>
			<div class="col px-1" style="padding-top:8px">
				<?php
				$displayData = new stdClass;
				$displayData->icon = FabrikHelperHTML::icon('icon-upload');
				$displayData->label = Text::_('COM_FABRIK_CSV');
				$displayData->links = array();
				if ($this->showCSVImport) :
					$displayData->links[] = '<a href="' . $this->csvImportLink . '" class="csvImportButton">' . FabrikHelperHTML::icon('icon-download', Text::_('COM_FABRIK_IMPORT_FROM_CSV'))  . '</a>';
				endif;
				if ($this->showCSV) :
					$displayData->links[] = '<a href="#" class="csvExportButton">' . FabrikHelperHTML::icon('icon-upload', Text::_('COM_FABRIK_EXPORT_TO_CSV')) . '</a>';
				endif;
				$layout = $this->getModel()->getLayout('fabrik-nav-dropdown');
				echo $layout->render($displayData);
				?>
			</div>
			<?php endif;
			if ($this->showRSS) :?>
			<div class="col px-1">
				<button class="btn">
					<a href="<?php echo $this->rssLink;?>" class="feedButton">
						<div class="row row-cols-auto">
							<div class="col pe-0"><?php echo FabrikHelperHTML::image('feed.png', 'list', $this->tmpl);?></div>
							<div class="col ps-1"><?php echo Text::_('COM_FABRIK_SUBSCRIBE_RSS');?></div>
						</div>
					</a>
				</button>
			</div>
			<?php
			endif;
			if ($this->showPDF) :?>
			<div class="col px-1">
						<button class="btn"><a href="<?php echo $this->pdfLink;?>" class="pdfButton">
							<?php echo FabrikHelperHTML::icon('icon-file', Text::_('COM_FABRIK_PDF'));?>
						</a></button>
			</div>			
			<?php endif;
			if ($this->emptyLink) :?>
			<div class="col px-1">
				<button class="btn">
					<a class="doempty" href="<?php echo $this->emptyLink;?>">
						<div class="row row-cols-auto">
							<div class="col px-0"><?php echo $this->buttons->empty;?></div>
							<div class="col ps-1"><?php echo Text::_('COM_FABRIK_EMPTY');?></div>
						</div>
					</a>
				</button>
			</div>
			<?php
			endif;
		?>
	</div>
</div>
</div>
<?php if (array_key_exists('all', $this->filters) || $this->filter_action != 'onchange') {
?>
	<div class="col-sm-4">
		<div class="container-fluid">
			<div class="row row-cols-auto align-items-end"<?php echo $this->filter_action != 'onchange' ? 'class="input-append"' : ''?>>
					<?php
					if (array_key_exists('all', $this->filters)) {
						echo $this->filters['all']->element;
						if ($this->filter_action != 'onchange') {
							echo '<input type="button" class="btn fabrik_filter_submit button" value="' . Text::_('COM_FABRIK_GO') . '" name="filter" >';
						};
					}; ?>
			</div>
		</div>
	</div>
<?php
}
?>
