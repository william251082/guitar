<?php
defined('_JEXEC') or die;

/**
 * Guitar helper
 */
abstract class GuitarHelper
{
    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = 'songs')
    {
        JHtmlSidebar::addEntry(
            JText::_('COM_GUITAR_SUBMENU_GUITAR'),
            'index.php?option=com_guitar&view=songs',
            $vName == 'songs'
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
}