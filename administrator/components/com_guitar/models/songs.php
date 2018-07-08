<?php
defined('_JEXEC') or die;
class GuitarModelSongs extends JModelList
{
    public function getListQuery()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('a.id,a.album');
        $query->from($db->quoteName('#__guitar_songs').' AS a');
        // Join over the categories.
        $query->select('c.title AS category_title');
        $query->join('LEFT', '#__categories AS c ON c.id = a.catid');

        return $query;
    }
}