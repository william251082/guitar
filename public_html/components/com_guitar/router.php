<<<<<<< HEAD
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

JLoader::registerPrefix('Guitar', JPATH_SITE . '/components/com_guitar/');

/**
 * Class GuitarRouter
 *
 * @since  3.3
 */
class GuitarRouter extends JComponentRouterBase
{
	/**
	 * Build method for URLs
	 * This method is meant to transform the query parameters into a more human
	 * readable form. It is only executed when SEF mode is switched on.
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   3.3
	 */
	public function build(&$query)
	{
		$segments = array();
		$view     = null;

		if (isset($query['task']))
		{
			$taskParts  = explode('.', $query['task']);
			$segments[] = implode('/', $taskParts);
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
			if ($view !== null)
			{
				$segments[] = $query['id'];
			}
			else
			{
				$segments[] = $query['id'];
			}

			unset($query['id']);
		}

		return $segments;
	}

	/**
	 * Parse method for URLs
	 * This method is meant to transform the human readable URL back into
	 * query parameters. It is only executed when SEF mode is switched on.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments)
	{
		$vars = array();

		// View is always the first element of the array
		$vars['view'] = array_shift($segments);
		$model        = GuitarHelpersGuitar::getModel($vars['view']);

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
				$vars['task'] = $vars['view'] . '.' . $segment;
			}
		}

		return $vars;
	}
}
||||||| merged common ancestors
=======
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
>>>>>>> 49269d37ee293462d1afd29c6dbe34c925905cdb
