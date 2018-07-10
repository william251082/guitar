<?php
defined('_JEXEC') or die;

class GuitarModelSong extends JModelItem
{
	public function &getItem($pk = null)
	{
		$app = JFactory::getApplication('site');
		$id = $app->input->getInt('id');

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
        $query
            ->select('songs.*')
            ->from($db->quoteName('#__guitar_songs').' AS songs')
            ->join('LEFT', '#__categories AS genres ON genres.id = songs.catid')
		    ->where('songs.id = '. $id);

        // By start and finish publish dates.
        $nullDate = $db->Quote($db->getNullDate());
        $nowDate = $db->Quote(JFactory::getDate()->toSql());
        $query
            ->where('(songs.publish_up = ' . $nullDate . ' OR songs.publish_up <= ' . $nowDate . ')')
            ->where('(songs.publish_down = ' . $nullDate . ' OR songs.publish_down >= ' . $nowDate . ')');

        // Get author's name
        $query
            ->select(
            "CASE WHEN songs.created_by_alias > ' ' 
                          THEN songs.created_by_alias 
                          ELSE users.name 
                          END AS author")
            ->join('LEFT', '#__users AS users ON users.id = songs.created_by');

        $query->where('songs.published = 1');

        //format the slug
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

		$db->setQuery($query);
		$data = $db->loadObject();

		// Return database object
		return $data;
	}
}