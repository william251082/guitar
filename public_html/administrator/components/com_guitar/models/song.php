<?php
defined('_JEXEC') or die;

class GuitarModelSong extends JModelAdmin
{
    public function getItem($pk = null)
    {
        if ($item = parent::getItem($pk)) {
            // Get author's name
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query
                ->select(
                "CASE WHEN songs.created_by_alias > ' '
                          THEN songs.created_by_alias
                          ELSE users.name
                          END AS author")
                ->join('LEFT', '#__users AS users ON users.id = songs.created_by');

            return $item;
        }
    }

    public function getForm($data = array(), $loadData = true)
    {
        $app = JFactory::getApplication();
        // Get the form.
        $form = $this->loadForm('com_guitar.song', 'song', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_guitar.edit.song.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }
//            var_dump($data);die;
        return $data;
    }

    public function getTable($type = 'Song', $prefix = 'GuitarTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }
}