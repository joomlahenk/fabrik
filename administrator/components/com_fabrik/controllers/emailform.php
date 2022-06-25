<?php
/**
 * Fabrik Email From Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       1.6
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Factory;

jimport('joomla.application.component.controller');

/**
 * Fabrik Email From Controller
 *
 * @package  Fabrik
 * @since    3.0
 */
class FabrikAdminControllerEmailform extends BaseController
{
	/**
	 * Typical view method for MVC based architecture
	 *
	 * This function is provide as a default implementation, in most cases
	 * you will need to override it in your own controllers.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link InputFilter::clean()}.
	 *
	 * @return  BaseController  A BaseController object to support chaining.
	 *
	 * @since   12.2
	 */
	public function display($cachable = false, $urlparams = array())
	{
		$document = Factory::getDocument();
		$app = Factory::getApplication();
		$input = $app->input;
		$viewName = $input->get('view', 'emailform');
		$viewType = $document->getType();

		// Set the default view name from the Request
		$view = $this->getView($viewName, $viewType);

		// Push a model into the view (may have been set in content plugin already)
		if ($model = Factory::getApplication()->bootComponent('com_fabrik')->getMVCFactory()->createModel('Form', 'FabrikFEModel'))
		{
			$view->setModel($model, true);
		}
		// Display the view
		$view->error = $this->getError();
		$view->display();
	}
}
