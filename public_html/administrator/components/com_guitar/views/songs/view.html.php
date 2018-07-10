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
        JToolBarHelper::title(JText::_('COM_GUITAR_MANAGER_SONGS'));
        JToolBarHelper::addNew('song.add');
        JToolBarHelper::editList('song.edit');
        JToolBarHelper::deleteList('', 'songs.delete');
        JToolbarHelper::publish('songs.publish', 'JTOOLBAR_PUBLISH', true);
        JToolbarHelper::unpublish('songs.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        JToolBarHelper::preferences('com_guitar');
    }

}