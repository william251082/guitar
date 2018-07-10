<?php
defined('_JEXEC') or die;

class GuitarModelCategory extends JModelList
{
    public function getListQuery()
    {
        $app = JFactory::getApplication();
        // get category id
        $id = $app->input->get('id', 0, 'int');

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('songs.id,songs.album')
            ->from($db->quoteName('#__guitar_songs') . ' AS songs');
        // Join over the categories.
        $query
            ->select('genre.title AS category_title')
            ->join('LEFT', '#__categories AS genre ON genre.id = songs.catid')
            ->where('songs.catid = ' . (int)$id);

        return $query;
    }
}