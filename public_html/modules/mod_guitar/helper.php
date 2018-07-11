<?php
defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_guitar/models', 'GuitarModel');

abstract class modGuitarHelper
{
	public static function getList($catid)
	{
		$app = JFactory::getApplication();
		$app->input->set('id', $catid);
		$id = $app->input->get('id', $catid);

		// Get an instance of the recipes model
		$model = JModelLegacy::getInstance('Category', 'GuitarModel', array('ignore_request' => true));
		$query = $model->getListQuery();
		$items = $model->getItems();

		foreach ($items as &$item) {
			$item->linkitem = '<a href="'. 
				JRoute::_('index.php?option=com_guitar&view=song&catid='.
							$item->catslug.'&id='.$item->slug).
							'">'.$item->title.'</a>';
		}

		return $items;
	}
}