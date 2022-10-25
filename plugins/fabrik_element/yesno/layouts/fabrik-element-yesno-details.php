<?php
/**
 * Layout: Yes/No field list view
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.2
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

$d = $displayData;
$data = $d->value;
$tmpl = $d->tmpl;
$format = $d->format;

$opts = array();
$properties = array();

if ($d->format == 'pdf') :
	$opts['forceImage'] = true;
	FabrikHelperHTML::addPath(COM_FABRIK_BASE . 'plugins/fabrik_element/yesno/images/', 'image', 'list', false);
endif;

if ($data == '1') :
    if (!empty($d->yesIcon))
    {
        $icon = $format != 'pdf' ? $d->yesIcon : '1.png';
    }
    else
    {
        $icon = $format != 'pdf' ? 'checkmark' : '1.png';
    }

	$properties['alt'] = Text::_('JYES');

	echo FabrikHelperHTML::image($icon, 'list', $tmpl, $properties, false, $opts);
else :
    if (!empty($d->noIcon))
    {
        $icon = $format != 'pdf' ? $d->noIcon : '0.png';
    }
    else
    {
        $icon = $format != 'pdf' ? 'remove' : '0.png';
    }

	$properties['alt'] = Text::_('JNO');

	echo FabrikHelperHTML::image($icon, 'list', $tmpl, $properties, false, $opts);
endif;
