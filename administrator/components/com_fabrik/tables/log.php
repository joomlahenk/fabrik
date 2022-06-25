<?php
/**
 * Log Fabrik Table
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Table\Table;

/**
 * Log Fabrik Table
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @since       3.0
 */
class FabrikTableLog extends Table
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  database object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__fabrik_log', 'id', $db);
	}
}
