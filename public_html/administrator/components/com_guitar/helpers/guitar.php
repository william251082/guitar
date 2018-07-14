<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Guitar
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 William del Rosario
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Guitar helper.
 *
 * @since  1.6
 */
class GuitarHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_GUITAR_TITLE_SONGS'),
			'index.php?option=com_guitar&view=songs',
			$vName == 'songs'
		);
        JHtmlSidebar::addEntry(
            JText::_('COM_GUITAR_TITLE_GUITARISTS'),
            'index.php?option=com_guitar&view=guitarists',
            $vName == 'guitarists'
        );
        JHtmlSidebar::addEntry(
            JText::_('COM_GUITAR_TITLE_ALBUMS'),
            'index.php?option=com_guitar&view=albums',
            $vName == 'albums'
        );
        JHtmlSidebar::addEntry(
            JText::_('COM_GUITAR_BANDS'),
            'index.php?option=com_guitar&view=bands',
            $vName == 'bands'
        );
        JHtmlSidebar::addEntry(
            JText::_('COM_GUITAR_SUBMENU_CATEGORIES'),
            'index.php?option=com_categories&extension=com_guitar',
            $vName == 'categories'
        );
        if ($vName == 'categories') {
            JToolbarHelper::title(
                JText::sprintf('COM_CATEGORIES_CATEGORIES_ALBUM', JText::_('com_guitar')),
                'guitar-categories');
        }

	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_guitar';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}

