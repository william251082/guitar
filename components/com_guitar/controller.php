<?php
defined('_JEXEC') or die;

class GuitarController extends JControllerLegacy
{
	public function display($cachable = false, $safeurlparams = false)
	{
		// Get the document object.
		$document = JFactory::getDocument();

		$id = $this->input->getInt('id');

		// Set the view based on the Request parameters,
		// if no view is set default to the "recipes" view
		$vName = $this->input->get('view', 'genres');
		$this->input->set('view', $vName);

		parent::display($cachable, $safeurlparams);

		return $this;
	}
}