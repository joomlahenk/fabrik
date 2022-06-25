<?php

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;

$d = $displayData;

echo HTMLHelper::_('access.level', $d->name, $d->selected, 'class="inputbox" size="6"', $d->options, $d->id);
