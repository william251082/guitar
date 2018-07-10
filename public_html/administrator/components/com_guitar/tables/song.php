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
        $date = JFactory::getDate();
        $user = JFactory::getUser();
        if (!$this->id) {
            if(!(int)$this->created) {
                $this->created = $date->toSql();
            }
            if (empty($this->created_by)) {
                $this->created_by = $user->get('id');
            }
        }
        // Set publish up to null date if not set
        if(!$this->publish_up) {
            $this->publish_up = $this->_db->getNullDate();
        }
        // Set publish down to null date if not set
        if(!$this->publish_down) {
            $this->publish_down = $this->_db->getNullDate();
        }

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
        $this->alias = JApplication::stringURLSafe($this->alias);
        if (empty($this->alias)) {
            $this->alias = JApplication::stringURLSafe($this->album);
        }
        // Check if the category is set
        if (trim($this->catid) == '') {
            $this->setError(JText::_('COM_CONTACT_WARNING_CATEGORY'));

            return false;
        }
        // Cleanup the metakeywords
        // remove the extra space and cr (\r) and if (\n) characters from the string
        if (!empty($this->metakey)) {
            // only process if not empty
            $bad_characters = array("\n", "\r", "\"", "<", ">",); // array of characters to remove
            $after_clean = JString::str_ireplace($bad_characters, "", $this->metakey); // remove bad characters
            $keys = explode(',', $after_clean); // create array using commas as delimiter
            $clean_keys = array();
            foreach ($keys as $key) {
                if (trim($key)) //ignore blank keywords
                    $clean_keys[] = trim($key);
            }
        }
        $this->metakey = implode(", ", $clean_keys); // put array back together delimited by ", "

        // remove quotes and <> brackets
        if (!empty($this->metadesc)) {
        // only process if not empty
        $bad_characters = array("\"", "<", ">");
        $this->metadesc = JString::str_ireplace($bad_characters, "", $this->metadesc);
    }
        // check if the publish down data is not earlier than the publish up
        if ((int)$this->publish_down > 0 && $this->publish_down < $this->publish_up) {
            $this->setError(JText::_('JGLOBAL_START_PUBLISH_AFTER_FINISH'));

        return false;
    }

        return true;
    }
}


