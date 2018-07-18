<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Guitar
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 com_guitar
 * @license    Proprietary License; For my customers only
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
			JText::_('JCATEGORIES') . ' (' . JText::_('COM_GUITAR_TITLE_SONGS') . ')',
			"index.php?option=com_categories&extension=com_guitar.songs",
			$vName == 'categories.songs'
		);
		if ($vName=='categories') {
			JToolBarHelper::title('Guitar Sessions: JCATEGORIES (COM_GUITAR_TITLE_SONGS)');
		}

        JHtmlSidebar::addEntry(
			JText::_('COM_GUITAR_TITLE_DIRECTORS'),
			'index.php?option=com_guitar&view=directors',
			$vName == 'directors'
		);

        JHtmlSidebar::addEntry(
			JText::_('COM_GUITAR_TITLE_TRANSACTIONS'),
			'index.php?option=com_guitar&view=transactions',
			$vName == 'transactions'
		);

        JHtmlSidebar::addEntry(
			JText::_('COM_GUITAR_TITLE_GROUPS'),
			'index.php?option=com_guitar&view=groups',
			$vName == 'groups'
		);

        JHtmlSidebar::addEntry(
			JText::_('COM_GUITAR_TITLE_PLACES'),
			'index.php?option=com_guitar&view=places',
			$vName == 'places'
		);

        JHtmlSidebar::addEntry(
			JText::_('COM_GUITAR_TITLE_GENRES'),
			'index.php?option=com_guitar&view=genres',
			$vName == 'genres'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_GUITAR_TITLE_TESTS'),
			'index.php?option=com_guitar&view=tests',
			$vName == 'tests'
		);
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

