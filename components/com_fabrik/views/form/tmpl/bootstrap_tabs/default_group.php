<?php
/**
 * Bootstrap Tabs Form Template - group details
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.1
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$rowStarted      = false;
$layout          = FabrikHelperHTML::getLayout('form.fabrik-control-group');

foreach ($this->elements as $element) :
	$this->element = $element;
	$this->class = 'fabrikErrorMessage';

	// Don't display hidden element's as otherwise they wreck multi-column layouts
	if (trim($element->error) !== '') :
		$element->error = $this->errorIcon . ' ' . $element->error;
		$element->containerClass .= ' error';
		$this->class .= ' help-inline text-danger';
	endif;

	$displayData = array(
		'class' => $element->containerClass . ($element->hidden ? ' d-none' : ''),
		'startRow' => $element->startRow,
		'endRow' => $element->endRow,
		'column' => $element->column,
	);

	$labelsAbove = $element->labels;

	if ($labelsAbove == 1)
	{
		$displayData['row'] = $this->loadTemplate('group_labels_above');
	}
	elseif ($labelsAbove == 2)
	{
		$displayData['row'] = $this->loadTemplate('group_labels_none');
	}
	elseif (isset($element->span) && ($element->span == FabrikHelperHTML::getGridSpan(12) || $element->span == '') || $labelsAbove == 0)
	{
		$displayData['row'] = $this->loadTemplate('group_labels_side');
	}
	else
	{
		// Multi columns - best to use simplified layout with labels above field
		$displayData['row'] = $this->loadTemplate('group_labels_above');
	}

	echo $layout->render((object) $displayData);

	?><?php
endforeach;
