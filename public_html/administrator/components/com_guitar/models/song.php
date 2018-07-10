<?php
defined('_JEXEC') or die;

class GuitarModelSong extends JModelAdmin
{
//    public function &getItem($pk = null)
//    {
//        $app = JFactory::getApplication('site');
//        $id = $app->input->getInt('id');
//
//        if (empty($id)) {
//            return $data;
//        }
//
//        $db = JFactory::getDBO();
//        $query = $db->getQuery(true);
//        $query->select('songs.*');
//        $query->from($db->quoteName('#__guitar_songs').' AS songs');
//        $query->where('songs.published = 1');
//        // Join over the categories.
//        $query->select('genres.title AS category_title');
//        $query->join('LEFT', '#__categories AS genres ON genres.id = songs.catid');
//
//        // Get author's name
//        $query
//            ->select(
//                "CASE WHEN songs.created_by_alias > ' '
//                          THEN songs.created_by_alias
//                          ELSE users.name
//                          END AS author")
//            ->join('LEFT', '#__users AS users ON users.id = songs.created_by');
//
//        return $data;
//    }


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