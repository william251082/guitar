<?php
defined('_JEXEC') or die;

class GuitarController extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = false)
	{
		// Get the document object.
		$document = JFactory::getDocument();

		// Set the view based on the Request parameters,
		// if no view is set default to the "songs" view
		$vName = $this->input->get('view', 'songs');
		$this->input->set('view', $vName);

		parent::display($cachable, $urlparams);

		return $this;
	}
}