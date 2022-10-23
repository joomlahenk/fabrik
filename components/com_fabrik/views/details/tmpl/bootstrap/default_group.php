<?php
/**
 * Bootstrap Details Template
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.1
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$rowStarted = false;
$layout          = FabrikHelperHTML::getLayout('form.fabrik-control-group');

foreach ($this->elements as $element) :
	$this->element = $element;
	$this->element->single = $single = $element->startRow && $element->endRow;

	$displayData = array(
		'class' => $element->containerClass . ($element->hidden ? ' d-none' : ''),
		'startRow' => $element->startRow,
		'endRow' => $element->endRow,
		'column' => $element->column,
	);

	$labelsAbove = $element->dlabels;

	if ($labelsAbove == 1)
	{
		$displayData['row'] = $this->loadTemplate('group_labels_above');
	}
	elseif ($labelsAbove == 2)
	{
		$displayData['row'] = $this->loadTemplate('group_labels_none');
	}
	elseif ($labelsAbove == 0)
	{
		$displayData['row'] = $this->loadTemplate('group_labels_side');
	}
	else
	{
		// Multi columns - best to use simplified layout with labels above field
		$displayData['row'] = $this->loadTemplate('group_labels_above');
	}

	echo $layout->render((object) $displayData);
endforeach;
// If the last element was not closing the row add an additional div
if ($rowStarted === true) :?>
</div><!-- end row-fluid for open row -->
<?php endif;?>

