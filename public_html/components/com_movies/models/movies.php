<?php

/**
 * @version    CVS: 1.0.1
 * @package    Com_Movies
 * @author     com_movies <williamdelrosario@yahoo.com>
 * @copyright  2018 com_movies
 * @license    Proprietary License; For my customers only
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Movies records.
 *
 * @since  1.6
 */
class MoviesModelMovies extends JModelList
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
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'modified_by', 'a.modified_by',
				'title', 'a.title',
				'description', 'a.description',
				'release_date', 'a.release_date',
				'rating', 'a.rating',
				'review', 'a.review',
				'awards', 'a.awards',
				'starring', 'a.starring',
				'director', 'a.director',
				'catid', 'a.catid',
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
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
            $app  = Factory::getApplication();
		$list = $app->getUserState($this->context . '.list');

		$ordering  = isset($list['filter_order'])     ? $list['filter_order']     : null;
		$direction = isset($list['filter_order_Dir']) ? $list['filter_order_Dir'] : null;

		$list['limit']     = (int) Factory::getConfig()->get('list_limit', 20);
		$list['start']     = $app->input->getInt('start', 0);
		$list['ordering']  = $ordering;
		$list['direction'] = $direction;

		$app->setUserState($this->context . '.list', $list);
		$app->input->set('list', null);

            // List state information.
            parent::populateState($ordering, $direction);

            $app = Factory::getApplication();

            $ordering  = $app->getUserStateFromRequest($this->context . '.ordercol', 'filter_order', $ordering);
            $direction = $app->getUserStateFromRequest($this->context . '.orderdirn', 'filter_order_Dir', $ordering);

            $this->setState('list.ordering', $ordering);
            $this->setState('list.direction', $direction);

            $start = $app->getUserStateFromRequest($this->context . '.limitstart', 'limitstart', 0, 'int');
            $limit = $app->getUserStateFromRequest($this->context . '.limit', 'limit', 0, 'int');

            if ($limit == 0)
            {
                $limit = $app->get('list_limit', 0);
            }

            $this->setState('list.limit', $limit);
            $this->setState('list.start', $start);
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

            $query->from('`#__movies_movies` AS a');
            
		// Join over the users for the checked out user.
		$query->select('uc.name AS uEditor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the created by field 'modified_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
		// Join over the foreign key 'director'
		$query->select('`#__movies_directors_3044319`.`name` AS directors_fk_value_3044319');
		$query->join('LEFT', '#__movies_directors AS #__movies_directors_3044319 ON #__movies_directors_3044319.`id` = a.`director`');
		if(!$this->isAdminOrSuperUser()){
			$query->where("a.created_by = " . JFactory::getUser()->get("id"));
		}
            
		if (!Factory::getUser()->authorise('core.edit', 'com_movies'))
		{
			$query->where('a.state = 1');
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
		// Checking "_dateformat"
		$filter_release_date_from = $this->state->get("filter.release_date_from_dateformat");
		$filter_Qrelease_date_from = (!empty($filter_release_date_from)) ? $this->isValidDate($filter_release_date_from) : null;

		if ($filter_Qrelease_date_from != null)
		{
			$query->where("a.release_date >= '" . $db->escape($filter_Qrelease_date_from) . "'");
		}

		$filter_release_date_to = $this->state->get("filter.release_date_to_dateformat");
		$filter_Qrelease_date_to = (!empty($filter_release_date_to)) ? $this->isValidDate($filter_release_date_to) : null ;

		if ($filter_Qrelease_date_to != null)
		{
			$query->where("a.release_date <= '" . $db->escape($filter_Qrelease_date_to) . "'");
		}

		// Filtering rating
		$filter_rating = $this->state->get("filter.rating");
		if ($filter_rating != '') {
			$query->where("a.`rating` = '".$db->escape($filter_rating)."'");
		}

		// Filtering director
		$filter_director = $this->state->get("filter.director");

		if ($filter_director)
		{
			$query->where("a.`director` = '".$db->escape($filter_director)."'");
		}

		// Filtering catid
		$filter_catid = $this->state->get("filter.catid");

		if ($filter_catid)
		{
			$query->where("a.`catid` = '".$db->escape($filter_catid)."'");
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
	 * Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
		
		foreach ($items as $item)
		{

			$item->rating = JText::_('COM_MOVIES_MOVIES_RATING_OPTION_' . strtoupper($item->rating));

			if (isset($item->director))
			{

				$values    = explode(',', $item->director);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = Factory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__movies_directors_3044319`.`name`')
						->from($db->quoteName('#__movies_directors', '#__movies_directors_3044319'))
						->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->name;
					}
				}

				$item->director = !empty($textValue) ? implode(', ', $textValue) : $item->director;
			}


		if (isset($item->catid) && $item->catid != '')
		{

			$db    = Factory::getDbo();
			$query = $db->getQuery(true);

			$query
				->select($db->quoteName('title'))
				->from($db->quoteName('#__categories'))
				->where('FIND_IN_SET(' . $db->quoteName('id') . ', ' . $db->quote($item->catid) . ')');

			$db->setQuery($query);

			$result = $db->loadColumn();

			$item->catid = !empty($result) ? implode(', ', $result) : '';
		}
		}

		return $items;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 *
	 * @return void
	 */
	protected function loadFormData()
	{
		$app              = Factory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;

		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && $this->isValidDate($value) == null)
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}

		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_MOVIES_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in a specified format (YYYY-MM-DD)
	 *
	 * @param   string  $date  Date to be checked
	 *
	 * @return bool
	 */
	private function isValidDate($date)
	{
		$date = str_replace('/', '-', $date);
		return (date_create($date)) ? Factory::getDate($date)->format("Y-m-d") : null;
	}
}
