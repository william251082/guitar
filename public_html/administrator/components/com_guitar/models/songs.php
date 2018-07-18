<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Guitar
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 com_guitar
 * @license    Proprietary License; For my customers only
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Guitar records.
 *
 * @since  1.6
 */
class GuitarModelSongs extends JModelList
{
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.`id`',
				'ordering', 'a.`ordering`',
				'state', 'a.`state`',
				'created_by', 'a.`created_by`',
				'modified_by', 'a.`modified_by`',
				'title', 'a.`title`',
				'description', 'a.`description`',
				'release_date', 'a.`release_date`',
				'review', 'a.`review`',
				'rating', 'a.`rating`',
				'credits', 'a.`credits`',
				'guitarist', 'a.`guitarist`',
				'catid', 'a.`catid`',
				'genre', 'a.`genre`',
			);
		}

		parent::__construct($config);
	}

    
        
       /**
        * Checks whether or not a user is manager or super user
        *
        * @return bool
        */
        public function isAdminOrSuperUser()
        {
            try{
                $user = JFactory::getUser();
                return in_array("8", $user->groups) || in_array("7", $user->groups);
            }catch(Exception $exc){
                return false;
            }
        }
    
        
        /**
         * This method revises if the $id of the item belongs to the current user
         * @param   integer     $id     The id of the item
         * @return  boolean             true if the user is the owner of the row, false if not.
         *
         */
        public function userIDItem($id){
            try{
                $user = JFactory::getUser();
                $db    = JFactory::getDbo();

                $query = $db->getQuery(true);
                $query->select("id")
                      ->from($db->quoteName('#__guitar_genre'))
                      ->where("id = " . $db->escape($id))
                      ->where("created_by = " . $user->id);

                $db->setQuery($query);

                $results = $db->loadObject();
                if ($results){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $exc){
                return false;
            }
        }
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);
		// Filtering release_date
		$this->setState('filter.release_date.from', $app->getUserStateFromRequest($this->context.'.filter.release_date.from', 'filter_from_release_date', '', 'string'));
		$this->setState('filter.release_date.to', $app->getUserStateFromRequest($this->context.'.filter.release_date.to', 'filter_to_release_date', '', 'string'));

		// Filtering rating
		$this->setState('filter.rating', $app->getUserStateFromRequest($this->context.'.filter.rating', 'filter_rating', '', 'string'));

		// Filtering guitarist
		$this->setState('filter.guitarist', $app->getUserStateFromRequest($this->context.'.filter.guitarist', 'filter_guitarist', '', 'string'));

		// Filtering catid
		$this->setState('filter.catid', $app->getUserStateFromRequest($this->context.'.filter.catid', 'filter_catid', '', 'string'));

		// Filtering genre
		$this->setState('filter.genre', $app->getUserStateFromRequest($this->context.'.filter.genre', 'filter_genre', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_guitar');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

                if(!$id || $this->userIDItem($id) || $this->isAdminOrSuperUser()){
                    return parent::getStoreId($id);
                }else{
                               throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                           }
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('`#__guitar_songs` AS a');
                
		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		if(!$this->isAdminOrSuperUser()){
			$query->where("a.created_by = " . JFactory::getUser()->get("id"));
		}

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');
		// Join over the foreign key 'guitarist'
		$query->select('`#__guitar_guitarists_3044531`.`name` AS guitarists_fk_value_3044531');
		$query->join('LEFT', '#__guitar_guitarists AS #__guitar_guitarists_3044531 ON #__guitar_guitarists_3044531.`id` = a.`guitarist`');
		// Join over the foreign key 'genre'
		$query->select('`#__guitar_genre_3044758`.`name` AS genres_fk_value_3044758');
		$query->join('LEFT', '#__guitar_genre AS #__guitar_genre_3044758 ON #__guitar_genre_3044758.`id` = a.`genre`');
                

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.title LIKE ' . $search . ' )');
			}
		}
                

		// Filtering release_date
		$filter_release_date_from = $this->state->get("filter.release_date.from");

		if ($filter_release_date_from !== null && !empty($filter_release_date_from))
		{
			$query->where("a.`release_date` >= '".$db->escape($filter_release_date_from)."'");
		}
		$filter_release_date_to = $this->state->get("filter.release_date.to");

		if ($filter_release_date_to !== null  && !empty($filter_release_date_to))
		{
			$query->where("a.`release_date` <= '".$db->escape($filter_release_date_to)."'");
		}

		// Filtering rating
		$filter_rating = $this->state->get("filter.rating");

		if ($filter_rating !== null && (is_numeric($filter_rating) || !empty($filter_rating)))
		{
			$query->where("a.`rating` = '".$db->escape($filter_rating)."'");
		}

		// Filtering guitarist
		$filter_guitarist = $this->state->get("filter.guitarist");

		if ($filter_guitarist !== null && !empty($filter_guitarist))
		{
			$query->where("a.`guitarist` = '".$db->escape($filter_guitarist)."'");
		}

		// Filtering catid
		$filter_catid = $this->state->get("filter.catid");

		if ($filter_catid !== null && !empty($filter_catid))
		{
			$query->where("a.`catid` = '".$db->escape($filter_catid)."'");
		}

		// Filtering genre
		$filter_genre = $this->state->get("filter.genre");

		if ($filter_genre !== null && !empty($filter_genre))
		{
			$query->where("a.`genre` = '".$db->escape($filter_genre)."'");
		}
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
                
		foreach ($items as $oneItem)
		{
					$oneItem->rating = JText::_('COM_GUITAR_SONGS_RATING_OPTION_' . strtoupper($oneItem->rating));

			if (isset($oneItem->guitarist))
			{
				$values    = explode(',', $oneItem->guitarist);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__guitar_guitarists_3044531`.`name`')
						->from($db->quoteName('#__guitar_guitarists', '#__guitar_guitarists_3044531'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$oneItem->guitarist = !empty($textValue) ? implode(', ', $textValue) : $oneItem->guitarist;
			}

			if (isset($oneItem->catid))
			{
				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select($db->quoteName('title'))
					->from($db->quoteName('#__categories'))
					->where('FIND_IN_SET(' . $db->quoteName('id') . ', ' . $db->quote($oneItem->catid) . ')');

				$db->setQuery($query);
				$result = $db->loadColumn();

				$oneItem->catid = !empty($result) ? implode(', ', $result) : '';
			}

			if (isset($oneItem->genre))
			{
				$values    = explode(',', $oneItem->genre);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__guitar_genre_3044758`.`name`')
						->from($db->quoteName('#__guitar_genre', '#__guitar_genre_3044758'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$oneItem->genre = !empty($textValue) ? implode(', ', $textValue) : $oneItem->genre;
			}
		}

		return $items;
	}
}
