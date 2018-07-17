<?php

/**
 * @version     CVS: 1.0.1
 * @package     com_movies
 * @subpackage  mod_movies
 * @author      com_movies <williamdelrosario@yahoo.com>
 * @copyright   2018 com_movies
 * @license     Proprietary License; For my customers only
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
JLoader::register('ModMoviesHelper', dirname(__FILE__) . '/helper.php');

$doc = JFactory::getDocument();

/* */
$doc->addStyleSheet(JURI::base() . '/media/mod_movies/css/style.css');

/* */
$doc->addScript(JURI::base() . '/media/mod_movies/js/script.js');

require JModuleHelper::getLayoutPath('mod_movies', $params->get('content_type', 'blank'));
