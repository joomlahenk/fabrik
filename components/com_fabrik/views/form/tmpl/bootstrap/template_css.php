<?php
/**
 * Fabrik Form Template: Bootstrap CSS
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

header('Content-type: text/css');
$c = (int) $_REQUEST['c'];
$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'form';
echo "

.fabrikGroup {
clear: left;
}
.badge {
    color: var(--body-color);
    font-size: 1rem;
}
/*BS5 ajax validation: icons overriding dropdown caret*/
.fabrikinput.form-select.is-invalid,.fabrikinput.form-select.is-valid {
    background-position: right 1rem center, center right 0.1rem !important;
	 padding-right:0 !important;
}
";
?>
