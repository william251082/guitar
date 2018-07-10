<?php
defined('_JEXEC') or die;

class GuitarViewSong extends JViewLegacy
{
    public function display($tpl = null)
    {
        $this->item		= $this->get('Item');
//        var_dump($this->item); die;
        $this->form		= $this->get('Form');
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $user  = JFactory::getUser();

        JFactory::getApplication()->input->set('hidemainmenu', true);
//        var_dump($this->item); die;
        $isNew		= ($this->item->id == 0);
        JToolbarHelper::title(JText::_('COM_GUITAR_MANAGER_SONG'), 'song.png');

        if ($isNew) {
            // If the user is allowed to create songs and this is a new document, give them save buttons
            if ($user->authorise('core.create', 'com_guitar'))  {
                JToolbarHelper::apply('song.apply');
                JToolbarHelper::save('song.save');
            }
        } else {
            // If the user is allowed to edit songs, give them save buttons
            if ($user->authorise('core.edit', 'com_guitar'))  {
                JToolbarHelper::apply('song.apply');
                JToolbarHelper::save('song.save');
                // If the user is allowed to edit their own songs and this is one of their songs, give them a save button
            } elseif ($user->authorise('core.edit.own', 'com_guitar')
                && ($this->item->created_by == $user->id))  {

                JToolbarHelper::apply('song.apply');
                JToolbarHelper::save('song.save');
            }
        }

        // These options don't change data so anyone can use them
        JToolbarHelper::cancel('song.cancel');
        JToolbarHelper::divider();
        JToolbarHelper::help('JHELP_COMPONENTS_GUITAR_SONGS_EDIT');
    }

}