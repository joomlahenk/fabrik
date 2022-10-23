<?php
/**
 * Bootstrap Form Template: Group Labels Side
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$element = $this->element; 
$width = 10;	// default input width
if (property_exists($element, 'bsClass') && !empty($element->bsClass)) {
	/* Get the selected value and normalize it withing the 10 columns allowed for the field */
	$width = min((int)substr($element->bsClass, strrpos($element->bsClass, '-')+1), 12);
	$width = (int)round(($width*10)/12);
}
?>
<div class="row mt-3">
	<?php echo $element->label;?>
	<div class="fabrikElement col-sm-<?php echo $width;?>">
		<?php echo $element->element;?>
</div>
</div>