<?php
defined('_JEXEC') or die;
class GuitarModelSongs extends JModelList
{
    public function getListQuery()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->select('songs.id,songs.album,songs.published,songs.publish_up,songs.publish_down')
            ->from($db->quoteName('#__guitar_songs').' AS songs');
        // Join over the categories.
        $query
            ->select('genres.title AS category_title')
            ->join('LEFT', '#__categories AS genres ON genres.id = songs.catid');

        return $query;
    }
}