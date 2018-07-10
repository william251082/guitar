<?php
defined('_JEXEC') or die;

class GuitarViewSongs extends JViewLegacy
{
	public function display($tpl = null)
	{
		// Get some data from the models
		$items		= $this->get('Items');
		$this->items      = &$items;

		// create a pagination object that will display to the footer
        $pagination = $this->get('Pagination');
        $this->pagination = $pagination;

		parent::display($tpl);
	}
}