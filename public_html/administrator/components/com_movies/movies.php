<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Movies
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 William del Rosario
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_movies'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Movies', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('MoviesHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'movies.php');

$controller = JControllerLegacy::getInstance('Movies');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
