<?php
/**
 * Admin Home Bootstrap Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::stylesheet('media/com_fabrik/css/admin.css');
ToolBarHelper::title(Text::_('COM_FABRIK_WELCOME'), 'fabrik.png');
?>

<div id="j-main-container">
	<div class="row">
		<div class="col">
			<div style="margin:0 0 25px;width:250px;"><?php echo HTMLHelper::image('media/com_fabrik/images/logo.png', 'Fabrik'); ?></div>
		</div>
		<div class="col-sm-12">
			<ul class="nav nav-tabs" id="Fab_Home_Nav" role="tablist">
				<li class="nav-item" role="">
					<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-about" type="button" role="tab" aria-controls="" aria-selected="true">
						<?php echo Text::_('COM_FABRIK_HOME_ABOUT'); ?>
					</button>
				</li>
				<li class="nav-item" role="">
					<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#home-tools" type="button" role="tab" aria-controls="" aria-selected="false">
						<?php echo Text::_('COM_FABRIK_HOME_TOOLS')?>
					</button>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="home-about">
					<?php echo Text::_('COM_FABRIK_HOME_ABOUT_TEXT'); ?>
				</div>

				<div class="tab-pane" id="home-tools">
					<ul class="adminlist">
						<li>
							<a onclick="return confirm('<?php echo Text::_('COM_FABRIK_HOME_CONFIRM_WIPE', true);?>')" href="index.php?option=com_fabrik&task=home.reset">
								<?php echo Text::_('COM_FABRIK_HOME_RESET_FABRIK') ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
