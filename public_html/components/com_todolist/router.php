<?php
// No direct access
defined('_JEXEC') or die;

JLoader::registerPrefix('Todolist', JPATH_SITE . '/components/com_todolist/');

class TodolistRouter extends JComponentRouterBase
{
    // Build SEF url route
    public function build(&$query)
    {
        // index.php?option=com_todolist&view=item&id=1
        $segments = array();
        $view     = null;

        if (isset($query['task'])) // item.complete itemform.save
        {
            $taskParts  = explode('.', $query['task']);
            $segments[] = implode('/', $taskParts); // item/complete
            $view       = $taskParts[0];
            unset($query['task']);
        }

        if (isset($query['view']))
        {
            $segments[] = $query['view'];
            $view = $query['view'];
            
            unset($query['view']);
        }

        if (isset($query['id']))
        {
            $segments[] = $query['id'];

            unset($query['id']);
        }

        return $segments;
    }

    // Parse SEF url route
    public function parse(&$segments) // /todos/item/1
    {
        $vars = array();

        // View is always the first element of the array
        $vars['view'] = array_shift($segments);

        while (!empty($segments))
        {
            $segment = array_pop($segments);

            // If it's the ID, let's put on the request
            if (is_numeric($segment))
            {
                $vars['id'] = $segment;
            }
            else
            {
                //item.complete
                $vars['task'] = $vars['view'] . '.' . $segment;
            }
        }

        return $vars;
    }

    // /blog/123-articles-alias
    // Joomla 3.8 /blog/articles-alias
}
