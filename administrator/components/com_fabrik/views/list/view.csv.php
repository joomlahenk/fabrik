<?php
/**
 * View to make ajax json object reporting csv file creation progress.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;

jimport('joomla.application.component.view');

class FabrikAdminViewList extends HtmlView
{
	/**
	 * Display the list
	 *
	 * @param   string  $tpl  Template
	 *
	 * @return  void
	 */

	public function display($tpl = null)
	{
		$session = Factory::getSession();
		$app = Factory::getApplication();
		$input = $app->input;
		$exporter = Factory::getApplication()->bootComponent('com_fabrik')->getMVCFactory()->createModel('Csvexport', 'FabrikFEModel');
		$model = Factory::getApplication()->bootComponent('com_fabrik')->getMVCFactory()->createModel('List', 'FabrikFEModel');
		$model->setId($input->getInt('listid'));
		$model->setOutPutFormat('csv');
		$exporter->model =& $model;
		$input->set('limitstart' . $model->getId(), $input->getInt('start', 0));
		$input->set('limit' . $model->getId(), $exporter->getStep());

		// $$$ rob moved here from csvimport::getHeadings as we need to do this before we get
		// the table total
		$selectedFields = $input->get('fields', array(), 'array');
		$model->setHeadingsForCSV($selectedFields);

		$total = $model->getTotalRecords();

		$key = 'fabrik.list.' . $model->getId() . 'csv.total';

		if (is_null($session->get($key)))
		{
			$session->set($key, $total);
		}

		$start = $input->getInt('start', 0);

		if ($start < $total)
		{
			$exporter->writeFile($total);
		}
		else
		{
			$session->clear($key);
			$exporter->downloadFile();
		}

		return;
	}
}
