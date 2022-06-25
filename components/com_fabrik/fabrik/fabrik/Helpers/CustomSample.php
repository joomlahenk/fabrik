<?php
/*
* Send sms's
*
* @package     Joomla
* @subpackage  Fabrik.helpers
* @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
* @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

namespace Fabrik\Helpers;

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

/**
 * Custom code
 *
 * To use, copy this file to Custom.php and rename the class from CustomSample to Custom.
 *
 * Add your functions as 'public static' methods.
 *
 * Call them from anywhere you can run PHP code in Fabrik as \Fabrik\Helpers\Custom::doMyThing(),
 * or FabrikCustom::doMyThing().  The latter is a class alias, which may be deprecated in future versions.
 *
 *
 * @package     Joomla
 * @subpackage  Fabrik.helpers
 * @since       3.8
 */
class CustomSample
{
	private static $init = null;

	private static $config = null;

	private static $user = null;

	private static $app = null;

	private static $lang = null;

	private static $date = null;

	private static $session = null;

	private static $formModel = null;

	public static function __initStatic($config = array())
	{
		if (!isset(self::$init))
		{
			self::$config  = ArrayHelper::getValue($config, 'config', \Factory::getConfig());
			self::$user    = ArrayHelper::getValue($config, 'user', \Factory::getUser());
			self::$app     = ArrayHelper::getValue($config, 'app', \Factory::getApplication());
			self::$lang    = ArrayHelper::getValue($config, 'lang', \Factory::getLanguage());
			self::$date    = ArrayHelper::getValue($config, 'date', \Factory::getDate());
			self::$session = ArrayHelper::getValue($config, 'session', \Factory::getSession());
			self::$formModel = ArrayHelper::getValue($config, 'formModel', null);
			self::$init    = true;
		}
	}

	public static function doMyThing()
	{
		return true;
	}
}
