<?php

defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/helper.php';

$data = array();
$data['text'] = htmlspecialchars($params->get('guitar_text'));
$data['textarea'] = htmlspecialchars($params->get('guitar_textarea'));
$data['texteditor'] = $params->get('guitar_editor');
//$data['items'] = modGuitarHelper::getList($params->get('catid'));
$data['items'] = modGuitarHelper::getItem($params->get('song'));

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_guitar', $params->get('layout', 'default'));