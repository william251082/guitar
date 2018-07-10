<?php
defined('_JEXEC') or die;

class GuitarViewSongs extends JViewLegacy
{
    public function display($tpl = null)
    {
        require_once JPATH_COMPONENT.'/helpers/guitar.php';
        // Get some data from the models
        $items		= $this->get('Items');
        $this->items      = &$items;
//        var_dump($this->items); die;
        $pagination = $this->get('Pagination');
        $this->pagination = $pagination;

        GuitarHelper::addSubmenu('songs');
        $this->sidebar = JHtmlSidebar::render();

        //Set the toolbar
        $this->addToolBar();

        parent::display($tpl);
    }

    protected function addToolBar()
    {
        $user = JFactory::getUser();
        JToolBarHelper::title(JText::_('COM_GUITAR_MANAGER_SONGS'));
        if ($user->authorise('core.create', 'com_guitar')) {
            JToolBarHelper::addNew('song.add');
        }
        if ($user->authorise('core.edit', 'com_guitar')
            || $user->authorise('core.edit.own', 'com_guitar')) {
            JToolBarHelper::editList('song.edit');
        }
        if ($user->authorise('core.delete', 'com_guitar')
            || $user->authorise('core.delete.own', 'com_guitar')) {
            JToolBarHelper::deleteList('', 'songs.delete');
        }
        if ($user->authorise('core.admin', 'com_guitar')) {
            JToolBarHelper::preferences('com_guitar');
        }
    }
}