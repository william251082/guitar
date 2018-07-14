<?php
defined('_JEXEC') or die;

class GuitarModelCategory extends JModelList
{
	public function getListQuery()
	{
	
		$app = JFactory::getApplication();
		$id = $app->input->get('id', 0, 'int');

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('a.id,a.title');
		$query->from($db->quoteName('#__guitar_songs').' AS a');
		// Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
        $query->where('a.catid = ' . (int) $id);
	
		return $query;
	}
}