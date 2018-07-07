<?php
defined('_JEXEC') or die;

class GuitarModelSongs extends JModelList
{
	public function getListQuery()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,title');
		$query->from('#__guitar_songs');

		return $query;
	}
}