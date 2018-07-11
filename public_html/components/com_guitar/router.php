<?php
defined('_JEXEC') or die;

function GuitarBuildRoute(&$query)
{
    $segments = array();
    if (isset($query['catid'])) {
        $segments[] = $query['catid'];
        unset($query['catid']);
    }
    if (isset($query['id'])) {
        $segments[] = $query['id'];
        unset($query['id']);
    }
    unset($query['view']);

    return $segments;
}

function GuitarParseRoute($segments)
{
    $vars = array();
    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    $mItem = $menu->getActive();

    if (empty($mItem)) {
        $view = "category";
    }
    else {
        $view = $mItem->query['view'];
    }

//    var_dump($mItem->query['view']);die;

    $count = count($segments);
    $id = explode(':', $segments[1]);
//    $vars['id'] = isset($id[0]) ? $id[0] : null;
    $vars['id'] = (int) $id[0];

    // get the view setup in menu item and segment count
    switch ($view){
        case 'categories':
        case 'category':
            if($count == 1) {
                $vars['view'] = 'category';
            }
            if($count == 2) {
                $vars['view'] = 'song';
            }
            break;
        case 'songs':
            $vars['view'] = 'song';
            break;
    }

    return $vars;
}