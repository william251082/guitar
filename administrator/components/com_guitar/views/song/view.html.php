<?php
defined('_JEXEC') or die;

class GuitarViewSong extends JViewLegacy
{
    public function display($tpl = null)
    {
        $this->item		= $this->get('Item');
        $this->form		= $this->get('Form');
//        var_dump($this->item); die;
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        // Set the Toolbar
        $this->addToolbar();

        parent::display($tpl);
    }
    protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);

//        var_dump($this->item); die;

        $isNew		= ($this->item->id == 0);

        JToolbarHelper::title(JText::_('COM_GUITAR_MANAGER_SONG'), 'song.png');

        // Build the actions for new and existing records.
        JToolbarHelper::apply('song.apply');
        JToolbarHelper::save('song.save');
        JToolbarHelper::cancel('song.cancel');
        JToolbarHelper::divider();
        JToolbarHelper::help('JHELP_COMPONENTS_GUITAR_SONGS_EDIT');
    }

}