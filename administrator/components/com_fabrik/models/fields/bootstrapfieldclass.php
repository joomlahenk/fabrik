<?php
/**
 * Renders a list of Bootstrap field class sizes
 *
 * @package     Joomla
 * @subpackage  Form
 * @copyright   Copyright (C) 2005-2020  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\Field\ListField;

FormHelper::loadFieldClass('list');

/**
 * Renders a list of Bootstrap field class sizes
 *
 * @package     Joomla
 * @subpackage  Form
 * @since       1.5
 */

class JFormFieldBootstrapfieldclass extends ListField
{
	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 */

	protected function getOptions()
	{
		$sizes = array();
		$sizes[] = HTMLHelper::_('select.option', 'col-md-1');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-2');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-3');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-4');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-5');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-6');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-7');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-8');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-9');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-10');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-11');
		$sizes[] = HTMLHelper::_('select.option', 'col-md-12');

		return $sizes;
	}
}
