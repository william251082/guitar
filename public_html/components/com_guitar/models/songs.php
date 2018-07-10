<?php
defined('_JEXEC') or die;

class GuitarModelSongs extends JModelList
{
    public function getListQuery()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('songs.id,songs.album');
        $query->from($db->quoteName('#__guitar_songs') . ' AS songs');
        // Join over the categories.
        $query->select('genre.title AS category_title');
        $query->join('LEFT', '#__categories AS genre ON genre.id = songs.catid');
        return $query;
    }
}