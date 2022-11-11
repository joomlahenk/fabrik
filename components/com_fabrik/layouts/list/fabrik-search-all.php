<?php
/**
 * Layout: Search all
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.4
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;

$d = $displayData;

?>
<div class="col-auto pe-1">
	<input
		type="search"
		size="20"
		placeholder="<?php echo $d->searchLabel; ?>"
		title="<?php echo $d->searchLabel; ?>"
		value="<?php echo $d->v; ?>"
		class="<?php echo $d->class; ?>"
		name="<?php echo $d->requestKey; ?>"
		id="<?php echo $d->id; ?>"
	/>
</div>
<?php
if ($d->advanced) :
	echo '<div class="col-sm-7 ps-1">';
	echo HTMLHelper::_('select.genericList', $d->searchOpts, 'search-mode-advanced', "class='form-select'", 'value', 'text', $d->mode);
	echo '</div>';
endif;
