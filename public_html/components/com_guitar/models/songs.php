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
        $query->select('genres.title AS category_title');
        $query->join('LEFT', '#__categories AS genres ON genres.id = songs.catid');

        // By start and finish publish dates.
        $nullDate = $db->Quote($db->getNullDate());
        $nowDate = $db->Quote(JFactory::getDate()->toSql());
        $query->where('(songs.publish_up = ' . $nullDate . ' OR songs.publish_up <= ' . $nowDate . ')');
        $query->where('(songs.publish_down = ' . $nullDate . ' OR songs.publish_down >= ' . $nowDate . ')');
        return $query;
    }
}