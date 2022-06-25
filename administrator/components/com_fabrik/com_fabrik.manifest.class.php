<?php
/**
 * Fabrik: Installer Manifest Class
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @author      Henk
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Factory;

class Com_FabrikInstallerScript
{
	/**
	 * Documents
	 *
	 * @var array
	 */
	protected $documents = array('Partial', 'Pdf');

	/**
	 * Run when the component is installed
	 *
	 * @param   object $parent installer object
	 *
	 * @return bool
	 */
	public function install($parent)
	{
		$parent->getParent()->setRedirectURL('index.php?option=com_fabrik');

		return true;
	}

	/**
	 * Check if there is a connection already installed if not create one
	 * by copying over the site's default connection
	 *
	 * @return  bool
	 */
	protected function setConnection()
	{
		$db               = Factory::getDbo();
		$app              = Factory::getApplication();
		$row              = new stdClass;
		$row->host        = $app->get('host');
		$row->user        = $app->get('user');
		$row->password    = $app->get('password');
		$row->database    = $app->get('db');
		$row->description = 'site database';
		$row->params      = '';
		$row->checked_out = 0;
		$row->published   = 1;
		$row->default     = 1;
		$res              = $db->insertObject('#__fabrik_connections', $row, 'id');

		return $res;
	}

	/**
	 * Test to ensure that the main component params have a default setup
	 *
	 * @return  bool
	 */
	protected function setDefaultProperties()
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('extension_id, params')->from('#__extensions')
			->where('name = ' . $db->q('fabrik'))
			->where('type = ' . $db->q('component'));
		$db->setQuery($query);
		$row                                 = $db->loadObject();
		$opts                                = new stdClass;
		$opts->fbConf_wysiwyg_label          = 0;
		$opts->fbConf_alter_existing_db_cols = 0;
		$opts->spoofcheck_on_formsubmission  = 0;

		if ($row && ($row->params == '{}' || $row->params == ''))
		{
			$json  = $row->params;
			$query = $db->getQuery(true);
			$query->update('#__extensions')->set('params = ' . $db->quote($json))
				->where('extension_id = ' . (int) $row->extension_id);
			$db->setQuery($query);

			if (!$db->execute())
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Move over files into Joomla libraries folder
	 *
	 * @param   object &$installer installer
	 * @param   bool   $upgrade    upgrade
	 *
	 * @return  bool
	 */
	protected function moveFiles(&$installer, $upgrade = false)
	{
		jimport('joomla.filesystem.file');
		$componentFrontend = 'components/com_fabrik';
		// move version check to function preflight
		if (version_compare(JVERSION, '4.1.4', '<')) {
			throw new RuntimeException('Fabrik can not be installed on versions of Joomla older than 4.1.4');
		}
		elseif (version_compare(JVERSION, '5.0.0', '>')) {
			throw new RuntimeException('Fabrik can not yet be installed on Joomla 5');
		}
        else
        {
            $dest = 'libraries/src/Document';

            if (!Folder::exists(JPATH_ROOT . '/' . $dest)) {
                Folder::create(JPATH_ROOT . '/' . $dest);
            }
            // $$$ hugh - have to use false as last arg (use_streams) on Folder::copy(), otherwise
            // it bypasses FTP layer, and will fail if web server does not have write access to J! folders
            $moveRes = Folder::copy($componentFrontend . '/Document', $dest, JPATH_SITE, true, false);

            if ($moveRes !== true) {
                echo "<p style=\"color:red\">failed to copy " . $componentFrontend . '/Document to ' . $dest . '</p>';

                return false;
            }
        }
		$dest = 'libraries/fabrik';

		if (!Folder::exists(JPATH_ROOT . '/' . $dest))
		{
			Folder::create(JPATH_ROOT . '/' . $dest);
		}

		$moveRes = Folder::copy($componentFrontend . '/fabrik', $dest, JPATH_SITE, true, false);

		if ($moveRes !== true)
		{
			echo "<p style=\"color:red\">failed to moved " . $componentFrontend . '/fabrik to ' . $dest . '</p>';

			return false;
		}

		return true;
	}

	/**
	 * Run when the component is uninstalled.
	 *
	 * @param   object $parent installer object
	 *
	 * @return  void
	 */
	public function uninstall($parent)
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$dest = JPATH_ROOT . '/libraries/src/Document';

		foreach ($this->documents as $document)
		{
			if (!empty($document) && File::exists($dest . '/' . $document . 'Document.php'))
			{
				File::delete($dest . '/' . $document . 'Document.php');
			}
		}

		$dest = JPATH_ROOT . '/libraries/src/Document/Renderer';

		foreach ($this->documents as $document)
		{
			if (!empty($document) && Folder::exists($dest . '/' . $document))
			{
				Folder::delete($dest . '/' . $document);
			}
		}

		// TODO: add remove the rest of fabrik
		$dest = JPATH_SITE . '/libraries/fabrik/';
		Folder::delete($dest);
		$dest = JPATH_SITE . '/media/com_fabrik/';
		Folder::delete($dest);
		$dest = JPATH_SITE . '/plugins/fabrik_element/';
		Folder::delete($dest);
		// more plugins to remove

		$this->disableFabrikPlugins();
	}

	/**
	 * Disable Fabrik Plugins
	 *
	 * @return bool
	 */
	protected function disableFabrikPlugins()
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);
		$query
			->update('#__extensions')
			->set('enabled = 0')
			->where('folder LIKE "%fabrik%" OR element LIKE ' . $db->q('%fabrik%'));

		return $db->setQuery($query)->execute();
	}

	/**
	 * God knows why but install component, uninstall component and install
	 * again and component_id is set to 0 for the menu items
	 *
	 * @return  bool
	 */
	protected function fixMenuComponentId()
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('extension_id')->from('#__extensions')->where('element = ' . $db->q('com_fabrik'));
		$db->setQuery($query);
		$id = (int) $db->loadResult();
		$query->clear();
		$query->update('#__menu')->set('component_id = ' . $id)->where('path LIKE ' . $db->q('fabrik%'));

		return $db->setQuery($query)->execute();
	}

	/**
	 * Run when the component is updated
	 *
	 * @param   object $parent installer object
	 *
	 * @return  bool
	 */
	public function update($parent)
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);
		$app   = Factory::getApplication();
		$msg = array();

		// Uninstalled plugins.
		$plugins = array(
			'fabrik_element' => array('fbactivityfeed', 'fblikebox', 'fbrecommendations'),
			'fabrik_form' => array('vbforum')
		);

		// Deprecated - 'timestamp', 'exif'
		$query->select('*')->from('#__extensions');

		foreach ($plugins as $folder => $plugs)
		{
			$query->where('(folder = ' . $db->q($folder) . ' AND element IN (' . implode(', ', $db->q($plugs)) . '))', 'OR');

			foreach ($plugs as $plug)
			{
				$path = JPATH_PLUGINS . '/' . $folder . '/' . $plug;

				if (Folder::exists($path))
				{
					Folder::delete($path);
				}
			}
		}

		$deprecatedPlugins = $db->setQuery($query)->loadObjectList();

		if (!empty($deprecatedPlugins))
		{
			$ids = ArrayHelper::getColumn($deprecatedPlugins, 'extension_id');
			$ids = ArrayHelper::toInteger($ids);

			$query->clear()->delete('#__extensions')->where('extension_id IN ( ' . implode(',', $ids) . ')');
			$db->setQuery($query)->execute();

			// Un-publish elements
			$query->clear()->select('id, name, label')->from('#__fabrik_elements')
				->where('plugin IN (' . implode(', ', $db->q($plugins['fabrik_element'])) . ')')
				->where('published = 1');
			$db->setQuery($query);
			$unpublishedElements = $db->loadObjectList();
			$unpublishedIds      = ArrayHelper::getColumn($unpublishedElements, 'id');

			if (!empty($unpublishedIds))
			{
				$msg[] = 'The following elements have been unpublished as their plug-ins have been uninstalled. : ' . implode(', ', $unpublishedIds);
				$query->clear()
					->update('#__fabrik_elements')->set('published = 0')->where('id IN (' . implode(',', $db->q($unpublishedIds)) . ')');
				$db->setQuery($query)->execute();
			}
		}

		// Un-publish form plug-ins
		$query->clear()->select('id, params')->from('#__fabrik_forms');
		$forms = $db->setQuery($query)->loadObjectList();
		foreach ($forms as $form)
		{
			$params = json_decode($form->params);
			$found = false;

			if (isset($params->plugins))
			{
				for ($i = 0; $i < count($params->plugins); $i++)
				{
					if (in_array($params->plugins[$i], $plugins['fabrik_form']))
					{
						$msg[]                    = 'Form ' . $form->id . '\'s plugin \'' . $params->plugins[$i] .
							'\' has been unpublished';
						$params->plugin_state[$i] = 0;
						$found = true;
					}
				}

				if ($found)
				{
					$query->clear()->update('#__fabrik_forms')->set('params = ' . $db->q(json_encode($params)))
						->where('id = ' . (int) $form->id);

					$db->setQuery($query)->execute();
				}
			}
		}

		if (!empty($msg))
		{
			$app->enqueueMessage(implode('<br>', $msg), 'warning');
		}

		return true;
	}

	/**
	 * Run before installation or upgrade run
	 *
	 * @param   string $type   discover_install (Install unregistered extensions that have been discovered.)
	 *                         or install (standard install)
	 *                         or update (update)
	 * @param   object $parent installer object
	 *
	 * @return  void
	 */
	public function preflight($type, $parent)
	{
	}

	/**
	 * Run after installation or upgrade run
	 *
	 * @param   string $type   discover_install (Install unregistered extensions that have been discovered.)
	 *                         or install (standard install)
	 *                         or update (update)
	 * @param   object $parent installer object
	 *
	 * @return  bool
	 */
	public function postflight($type, $parent)
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		// Remove update site
		$where = "location LIKE '%update/component/com_fabrik%' OR location = 'http://fabrikar.com/update/fabrik/package_list.xml'";
		$query->delete('#__update_sites')->where($where);
		$db->setQuery($query);

		if (!$db->execute())
		{
			echo "<p>didnt remove old update site</p>";
		}
		else
		{
			echo "<p style=\"color:green\">removed old update site</p>";
		}

		$query->clear();
		$query->update('#__extensions')->set('enabled = 1')
			->where('type = ' . $db->q('plugin') . ' AND (folder LIKE ' . $db->q('fabrik_%'), 'OR')
			->where('(folder=' . $db->q('system') . ' AND element = ' . $db->q('fabrik') . ')', 'OR')
			->where('(folder=' . $db->q('content') . ' AND element = ' . $db->q('fabrik') . '))', 'OR');
		$db->setQuery($query)->execute();
		$this->fixMenuComponentId();

		if ($type !== 'update')
		{
			if (!$this->setConnection())
			{
				echo "<p style=\"color:red\">Didn't set connection. Aborting installation</p>";
				exit;

				return false;
			}
		}

		echo "<p style=\"color:green\">Default connection created</p>";

		if (!$this->moveFiles($parent))
		{
			echo "<p style=\"color:red\">Unable to move library files. Aborting installation</p>";
			exit;

			return false;
		}
		else
		{
			echo "<p style=\"color:green\">Libray files moved</p>";
		}

		if ($type !== 'update')
		{
			if (!$this->setDefaultProperties())
			{
				echo "<p>couldnt set default properties</p>";
				exit;

				return false;
			}
		}

		echo "<p>Installation finished</p>";
		echo "<p>Note that this extension places a small number of additional files in the Joomla core directories,
providing extended functionality such as PDF document types.  These files will be removed if you uninstall Fabrik.</p>";
	}
}
