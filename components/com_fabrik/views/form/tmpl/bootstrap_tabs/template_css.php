<?php
/**
 * Fabrik Form View Template: Bootstrap Tab CSS
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

/* color & highlight group with validation errors */
.fabrikErrorGroup {
    background-color: rgb(242, 222, 222) !important;
  color: #b94a48;
}
 
/*BS5 ajax validation: icons overriding dropdown caret*/
.fabrikinput.form-select {
    background-position: right 1rem center, center right 0.1rem !important;
	 padding-right:0 !important;
}
";
?>