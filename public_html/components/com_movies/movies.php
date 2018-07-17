<?php
/**
 * @version    CVS: 1.0.1
 * @package    Com_Movies
 * @author     com_movies <williamdelrosario@yahoo.com>
 * @copyright  2018 com_movies
 * @license    Proprietary License; For my customers only
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Movies', JPATH_COMPONENT);
JLoader::register('MoviesController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Movies');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
