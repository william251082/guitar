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
		$query->select('id, album, song');
		$query->from('#__guitar_songs');
		$query->where('id = '.$id);

		$db->setQuery($query);
		$data = $db->loadObject();

		// Return database object
		return $data;
	}
}