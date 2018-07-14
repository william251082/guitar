<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Guitar
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 William del Rosario
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Class GuitarController
 *
 * @since  1.6
 */
class GuitarController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean $cachable  If true, the view output will be cached
	 * @param   mixed   $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController   This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
	    // Get the document object
        $app  = JFactory::getApplication();

        $id = $this->input->getInt('id');

        // Set the view based on the request paarameters
        // if no view is set default to the "songs" view
        $view = $app->input->getCmd('view', 'songs');
		$app->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
