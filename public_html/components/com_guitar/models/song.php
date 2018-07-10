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
            ->select('songs.id,songs.album,songs.song,genre.title AS genre')
            ->from($db->quoteName('#__guitar_songs').' AS songs')
            ->join('LEFT', '#__categories AS genre ON genre.id = songs.catid')
		    ->where('songs.id = '. $id);

		$db->setQuery($query);
		$data = $db->loadObject();

		// Return database object
		return $data;
	}
}