<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 24/05/2016
 * Time: 09:56
 */

namespace Fabrik\Controllers;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Document\Document;
use Joomla\CMS\Session\Session;
use Joomla\CMS\User\User;
use Joomla\CMS\Factory;
use \Joomla\Utilities\ArrayHelper;
use \Factory;

class Controller extends \BaseController
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
	 * @var string
	 */
	protected $package;

	/**
	 * @var Session
	 */
	protected $session;

	/**
	 * @var Document
	 */
	protected $doc;

	/**
	 * @var JDatabaseDriver
	 */
	protected $db;

	/**
	 * @var Registry
	 */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param   array $config A named configuration array for object construction.
	 *
	 */
	public function __construct($config = array())
	{
		$this->app     = ArrayHelper::getValue($config, 'app', Factory::getApplication());
		$this->user    = ArrayHelper::getValue($config, 'user', Factory::getUser());
		$this->package = $this->app->getUserState('com_fabrik.package', 'fabrik');
		$this->session = ArrayHelper::getValue($config, 'session', Factory::getSession());
		$this->doc     = ArrayHelper::getValue($config, 'doc', Factory::getDocument());
		$this->db      = ArrayHelper::getValue($config, 'db', Factory::getDbo());
		$this->config  = ArrayHelper::getValue($config, 'config', Factory::getConfig());
		parent::__construct($config);
	}
}