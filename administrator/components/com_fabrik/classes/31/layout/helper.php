<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\Registry\Registry;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Layout\LayoutInterface;

/**
 * Helper to render a LayoutInterface object, storing a base path
 *
 * @package     Joomla.Libraries
 * @subpackage  Layout
 * @see         http://docs.joomla.org/Sharing_layouts_across_views_or_extensions_with_LayoutInterface
 * @since       3.1
 */
class LayoutHelper
{
	/**
	 * A default base path that will be used if none is provided when calling the render method.
	 * Note that FileLayout itself will defaults to JPATH_ROOT . '/layouts' if no basePath is supplied at all
	 *
	 * @var    string
	 * @since  3.1
	 */
	public static $defaultBasePath = '';

	/**
	 * Method to render the layout.
	 *
	 * @param   string  $layoutFile   Dot separated path to the layout file, relative to base path
	 * @param   object  $displayData  Object which properties are used inside the layout file to build displayed output
	 * @param   string  $basePath     Base path to use when loading layout files
	 * @param   mixed   $options      Optional custom options to load. Registry or array format
	 *
	 * @return  string
	 *
	 * @since   3.1
	 */
	public static function render($layoutFile, $displayData = null, $basePath = '', $options = null)
	{
		$basePath = empty($basePath) ? self::$defaultBasePath : $basePath;

		// Make sure we send null to FileLayout if no path set
		$basePath = empty($basePath) ? null : $basePath;
		$layout = new FileLayout($layoutFile, $basePath, $options);
		$renderedLayout = $layout->render($displayData);

		return $renderedLayout;
	}
}
