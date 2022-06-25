<?php
/**
 * Abstract Fabrik Admin model
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       1.6
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Session\Session;
use Joomla\CMS\User\User;
use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

/**
 * Abstract Fabrik Admin model
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @since       3.0
 */
abstract class FabModelAdmin extends AdminModel
{
	/**
	 * @var JApplicationCMS
	 */
	protected $app;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var Registry
	 */
	protected $config;

	/**
	 * @var Session
	 */
	protected $session;

	/**
	 * @var JDatabaseDriver
	 */
	protected $db;

	/**
	 * @var FabrikFEModelPluginmanager
	 */
	protected $pluginManager;

	/**
	 * Component name
	 *
	 * @var  string
	 */
	protected $option = 'com_fabrik';

	/**
	 * Constructor.
	 *
	 * @param   array $config An optional associative array of configuration settings.
	 *
	 * @see     BaseDatabaseModel
	 * @since   12.2
	 */
	public function __construct($config = array())
	{
		$this->app           = ArrayHelper::getValue($config, 'app', Factory::getApplication());
		$this->user          = ArrayHelper::getValue($config, 'user', Factory::getUser());
		$this->config        = ArrayHelper::getValue($config, 'config', Factory::getConfig());
		$this->session       = ArrayHelper::getValue($config, 'session', Factory::getSession());
		$this->db            = ArrayHelper::getValue($config, 'db', Factory::getDbo());
		$this->pluginManager = ArrayHelper::getValue($config, 'pluginManager',
			Factory::getApplication()->bootComponent('com_fabrik')->getMVCFactory()->createModel('Pluginmanager', 'FabrikFEModel'));
		parent::__construct($config);
	}

	/**
	 * Get the list's active/selected plug-ins
	 *
	 * @return array
	 */
	public function getPlugins()
	{
		$item = $this->getItem();

		// Load up the active plug-ins
		$plugins = FArrayHelper::getValue($item->params, 'plugins', array());

		return $plugins;
	}
}
