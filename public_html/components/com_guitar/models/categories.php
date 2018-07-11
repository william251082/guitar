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

        //format the slug
        $case_when = ' CASE WHEN ';
        $case_when .= $query->charLength('songs.alias', '!=', '0');
        $case_when .= ' THEN ';
        $songs_id = $query->castAsChar('songs.id');
        $case_when .= $query->concatenate(array($songs_id, 'songs.alias'), ':');
        $case_when .= ' ELSE ';
        $case_when .= $songs_id.' END as slug';
        $query->select($case_when);

//        //Ordering for the list of categories
//        $params        = JComponentHelper::getParams('com_guitar');
//        $categoryOrderby    = $params->def('orderby_pri', '');
//        switch($categoryOrderby){
//            case 'alpha':
//                $categoryOrderby = 'title ASC';
//                break;
//            case 'ralpha':
//                $categoryOrderby = 'title DESC';
//                break;
//            case 'order':
//                $categoryOrderby = 'order';
//                break;
//            default:
//                $categoryOrderby = '';
//        }
//        if (!empty($categoryOrderby)){
//            $query->order($categoryOrderby);
//        }

        return $query;
    }
}