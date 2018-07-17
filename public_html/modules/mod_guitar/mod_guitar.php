<?php

/**
 * @version     CVS: 1.0.0
 * @package     com_guitar
 * @subpackage  mod_guitar
 * @author      William del Rosario <williamdelrosario@yahoo.com>
 * @copyright   2018 com_guitar
 * @license     Proprietary License; For my customers only
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
JLoader::register('ModGuitarHelper', dirname(__FILE__) . '/helper.php');

$doc = JFactory::getDocument();

/* */
$doc->addStyleSheet(JURI::base() . '/media/mod_guitar/css/style.css');

/* */
$doc->addScript(JURI::base() . '/media/mod_guitar/js/script.js');

require JModuleHelper::getLayoutPath('mod_guitar', $params->get('content_type', 'blank'));
