<?php
/**
 * Render a tag cloud
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Helper\ModuleHelper;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
$cloud = modTagCloudHelper::getCloud($params);
require ModuleHelper::getLayoutPath('mod_tagcloud');
