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

        // Set a message for reviewers or authors trying to edit a document they do not own
        $user  = JFactory::getUser();
        if ($this->item->id == 0)
        {
            if ($user->authorise('core.create', 'com_guitar'))
            {
                JFactory::getApplication()->enqueueMessage("You may not create a song, save is disabled", 'error');
            }
        } else {
            $canEdit= false;
            if ($user->authorise('core.edit', 'com_guitar'))
            {
                $canEdit = true;
            } elseif ($user->authorise('core.edit.own', 'com_guitar')
                && ($this->item->created_by == $user->id))
            {
                $canEdit = true;
            }
            if (!$canEdit)
            {
                if ($user->authorise('core.edit.own', 'com_guitar')) {
                    JFactory::getApplication()->enqueueMessage("Review mode, you may only edit your OWN songs, not other artists.", 'info');
                } else{
                    JFactory::getApplication()->enqueueMessage("Review mode, you may not edit this song.", 'info');
                }
            }

        }
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