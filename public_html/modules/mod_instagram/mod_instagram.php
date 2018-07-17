<?php

/**
 * @version     CVS: 1.0.0
 * @package     com_instagram
 * @subpackage  mod_instagram
 * @author      com_instagram <williamdelrosario@yahoo.com>
 * @copyright   2018 com_instagram
 * @license     Proprietary License; For my customers only
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
JLoader::register('ModInstagramHelper', dirname(__FILE__) . '/helper.php');

$doc = JFactory::getDocument();

/* */
$doc->addStyleSheet(JURI::base() . '/media/mod_instagram/css/style.css');

/* */
$doc->addScript(JURI::base() . '/media/mod_instagram/js/script.js');

require JModuleHelper::getLayoutPath('mod_instagram', $params->get('content_type', 'blank'));
