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
            ->select('songs.id,songs.album,songs.publish_up,songs.created,songs.metadesc')
            ->from($db->quoteName('#__guitar_songs') . ' AS songs');

        // Join over the categories.
        $query
            ->select('genres.title AS category_title')
            ->join('LEFT', '#__categories AS genres ON genres.id = songs.catid')
            ->where('songs.catid = ' . (int)$id);

        // By start and finish publish dates.
        $nullDate = $db->Quote($db->getNullDate());
        $nowDate = $db->Quote(JFactory::getDate()->toSql());
        $query->where('(songs.publish_up = ' . $nullDate . ' OR songs.publish_up <= ' . $nowDate . ')');
        $query->where('(songs.publish_down = ' . $nullDate . ' OR songs.publish_down >= ' . $nowDate . ')');
        $query->where('songs.published = 1');

        // Get author's name
        $query
            ->select(
                "CASE WHEN songs.created_by_alias > ' ' 
                          THEN songs.created_by_alias 
                          ELSE users.name 
                          END AS author")
            ->join('LEFT', '#__users AS users ON users.id = songs.created_by');

        // format the slug
        $case_when = ' CASE WHEN ';
        $case_when .= $query->charLength('songs.alias', '!=', '0');
        $case_when .= ' THEN ';
        $songs_id = $query->castAsChar('songs.id');
        $case_when .= $query->concatenate(array($songs_id, 'songs.alias'), ':');
        $case_when .= ' ELSE ';
        $case_when .= $songs_id.' END as slug';
        $query->select($case_when);

        // get the category slug
        $case_when1 = ' CASE WHEN ';
        $case_when1 .= $query->charLength('genres.alias', '!=', '0');
        $case_when1 .= ' THEN ';
        $genres_id = $query->castAsChar('genres.id');
        $case_when1 .= $query->concatenate(array($genres_id, 'genres.alias'), ':');
        $case_when1 .= ' ELSE ';
        $case_when1 .= $genres_id.' END as catslug';
        $query->select($case_when1);

//        $componentParams        = JComponentHelper::getParams('com_guitar');
//        $menuParams = new JRegistry;
//
//        $app = JFactory::getApplication();
//        $active = $app->getMenu()->getActive();
//        $currentLink = $active->link;
//        $menuParams->loadString($active->params);
//
//        if ($active && strpos($currentLink, 'view=songs')) {
//            $componentParams->merge($menuParams);
//            $params  = $componentParams;
//        }
//        else {
//            $menuParams->merge($componentParams);
//            $params  = $menuParams;
//        }
//
//        // Ordering Options for Songs and Category Views
////        // get the component's parameters
////        $params        = JComponentHelper::getParams('com_guitar');
////
//        //retrieve individual parameter settings
//        $songOrderby        = $params->get('orderby_sec', 'rdate');
//        $songOrderDate    = $params->get('order_date', 'publish_up');
//
//        //set order by in the query
//        switch($songOrderby){
//            case 'rdate':
//                $query->order('songs.' . $songOrderDate . ' DESC');
//                break;
//            case 'date':
//                $query->order('songs.' . $songOrderDate . ' ASC');
//                break;
//            case 'alpha':
//                $query->order('songs.title ASC');
//                break;
//            case 'ralpha':
//                $query->order('songs.title DESC');
//                break;
//            case 'author':
//                $query->order('songs.author ASC');
//                break;
//            case 'rauthor':
//                $query->order('songs.author DESC');
//                break;
//        }
        return $query;
    }
}
