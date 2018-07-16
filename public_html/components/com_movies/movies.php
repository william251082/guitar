<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Movies
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 William del Rosario
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
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
