<?php
defined('_JEXEC') or die;

class GuitarTableSong extends JTable
{
    public function __construct(&$db)
    {
        parent::__construct('#__guitar_songs', 'id', $db);
    }

    public function bind($array, $ignore = '')
    {
        return parent::bind($array, $ignore);
    }

    public function store($updateNulls = false)
    {
        // Attempt to store the user data.
        return parent::store($updateNulls);
    }

    public function check()
    {
        // check for valid name
        if (trim($this->album) == '') {
            $this->setError(JText::_('COM_GUITAR_ERR_TABLES_ALBUM'));
            return false;
        }
        return true;
    }
}
