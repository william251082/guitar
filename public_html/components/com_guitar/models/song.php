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

		$db->setQuery($query);
		$data = $db->loadObject();

		// Return database object
		return $data;
	}
}