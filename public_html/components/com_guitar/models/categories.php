<?php
defined('_JEXEC') or die;

class GuitarModelCategories extends JModelList
{
    public function getListQuery()
    {
        $db = JFactory::getDBO();
        // get a list of category used by guitar
        $query = $db->getQuery(true);
        $query
            ->select('id,album')
            ->from($db->quoteName('#__categories'))
            ->where('extension = "com_guitar"')
            ->where('published = 1')
            ->where('access = 1');

        return $query;
    }
}