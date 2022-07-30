<?php

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;

$d = $displayData;
$attribs = 'class="col-md-4 fabrikinput inputbox ' . $d->advancedClass . ' ' . $d->errorCss . '" ';
?>

<div class="fabrikSubElementContainer" id="<?php echo $d->id; ?>">
<?php
	// $d->name already suffixed with [] as element hasSubElements = true
	if ($d->format != 'i:s')
	{
	echo  HTMLHelper::_('select.genericlist', $d->hours, preg_replace('#(\[\])$#', '[0]', $d->name), $attribs, 'value', 'text', $d->hourValue) . ' '
	. $d->sep . ' ';
	}

	echo HTMLHelper::_('select.genericlist', $d->mins, preg_replace('#(\[\])$#', '[1]', $d->name), $attribs, 'value', 'text', $d->minValue);

	if ($d->format != 'H:i')
	{
	echo $d->sep . ' '
	. HTMLHelper::_('select.genericlist', $d->secs, preg_replace('#(\[\])$#', '[2]', $d->name), $attribs, 'value', 'text', $d->secValue);
	}
?>
</div>
