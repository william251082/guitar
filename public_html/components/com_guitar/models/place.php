<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Guitar
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 com_guitar
 * @license    Proprietary License; For my customers only
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

/**
 * Guitar model.
 *
 * @since  1.6
 */
class GuitarModelPlace extends JModelItem
{
    public $_item;

        
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
                $db   = JFactory::getDbo();

                $query = $db->getQuery(true);
                $query->select("id")
                      ->from($db->quoteName('#__guitar_groups'))
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
	 * @return void
	 *
	 * @since    1.6
	 *
	 */
	protected function populateState()
	{
		$app  = Factory::getApplication('com_guitar');
		$user = Factory::getUser();

		// Check published state
		if ((!$user->authorise('core.edit.state', 'com_guitar')) && (!$user->authorise('core.edit', 'com_guitar')))
		{
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}

		// Load state from the request userState on edit or from the passed variable on default
		if (Factory::getApplication()->input->get('layout') == 'edit')
		{
			$id = Factory::getApplication()->getUserState('com_guitar.edit.place.id');
		}
		else
		{
			$id = Factory::getApplication()->input->get('id');
			Factory::getApplication()->setUserState('com_guitar.edit.place.id', $id);
		}

		$this->setState('place.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();

		if (isset($params_array['item_id']))
		{
			$this->setState('place.id', $params_array['item_id']);
		}

		$this->setState('params', $params);
	}

	/**
	 * Method to get an object.
	 *
	 * @param   integer $id The id of the object to get.
	 *
	 * @return  mixed    Object on success, false on failure.
     *
     * @throws Exception
	 */
	public function getItem($id = null)
	{
            if ($this->_item === null)
            {
                $this->_item = false;

                $db    = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query
                    ->select(
                    'c.title as category, p.lat as latitude, p.lng as longitude')
                    ->from('#__guitar_place as p')
                    ->leftJoin('#__categories as c ON p.catid=c.id')
                    ->where('p.id=' . (int)$id);
                $db->setQuery((string)$query);

                if (empty($id))
                {
                    $id = $this->getState('place.id');
                }

                // Get a level row instance.
                $table = $this->getTable();

                // Attempt to load the row.
                if ($table->load($id))
                {
                    if(!$id || $this->isAdminOrSuperUser() || $table->created_by == JFactory::getUser()->id){

                    // Check published state.
                    if ($published = $this->getState('filter.published'))
                    {
                        if (isset($table->state) && $table->state != $published)
                        {
                            throw new Exception(JText::_('COM_GUITAR_ITEM_NOT_LOADED'), 403);
                        }
                    }

                    // Convert the JTable to a clean JObject.
                    $properties  = $table->getProperties(1);
                    $this->_item = ArrayHelper::toObject($properties, 'JObject');

                    } else {
                        throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                        }
                } 
            }
        
            

		if (isset($this->_item->created_by))
		{
			$this->_item->created_by_name = Factory::getUser($this->_item->created_by)->name;
		}

		if (isset($this->_item->modified_by))
		{
			$this->_item->modified_by_name = Factory::getUser($this->_item->modified_by)->name;
		}

		if (isset($this->_item->transaction) && $this->_item->transaction != '')
		{
			if (is_object($this->_item->transaction))
			{
				$this->_item->transaction = ArrayHelper::fromObject($this->_item->transaction);
			}

			$values = (is_array($this->_item->transaction)) ? $this->_item->transaction : explode(',',$this->_item->transaction);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__guitar_transactions_3044861`.`title`')
					->from($db->quoteName('#__guitar_transactions', '#__guitar_transactions_3044861'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->title;
				}
			}

			$this->_item->transaction = !empty($textValue) ? implode(', ', $textValue) : $this->_item->transaction;

		}

		if (isset($this->_item->group) && $this->_item->group != '')
		{
			if (is_object($this->_item->group))
			{
				$this->_item->group = ArrayHelper::fromObject($this->_item->group);
			}

			$values = (is_array($this->_item->group)) ? $this->_item->group : explode(',',$this->_item->group);

			$textValue = array();

			foreach ($values as $value)
			{
				$db    = Factory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select('`#__guitar_groups_3044862`.`name`')
					->from($db->quoteName('#__guitar_groups', '#__guitar_groups_3044862'))
					->where($db->quoteName('id') . ' = ' . $db->quote($value));

				$db->setQuery($query);
				$results = $db->loadObject();

				if ($results)
				{
					$textValue[] = $results->name;
				}
			}

			$this->_item->group = !empty($textValue) ? implode(', ', $textValue) : $this->_item->group;

		}

            return $this->_item;
        }

    public function getMapParams()
    {
        if ($this->_item)
        {
            $this->mapParams = array(
                'latitude' => $this->_item->lat,
                'longitude' => $this->_item->lng,
                'zoom' => 10,
//                'greeting' => $this->_item->greeting
            );
            return $this->mapParams;
        }
        else
        {
            throw new Exception('No place details available for map', 500);
        }
    }

	/**
	 * Get an instance of JTable class
	 *
	 * @param   string $type   Name of the JTable class to get an instance of.
	 * @param   string $prefix Prefix for the table class name. Optional.
	 * @param   array  $config Array of configuration values for the JTable object. Optional.
	 *
	 * @return  JTable|bool JTable if success, false on failure.
	 */
	public function getTable($type = 'Place', $prefix = 'GuitarTable', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_guitar/tables');

		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get the id of an item by alias
	 *
	 * @param   string $alias Item alias
	 *
	 * @return  mixed
	 */
	public function getItemIdByAlias($alias)
	{
            $table      = $this->getTable();
            $properties = $table->getProperties();
            $result     = null;
            $id = null;

            if (key_exists('alias', $properties))
            {
                $table->load(array('alias' => $alias));
                $result = $table->id;
            }
            if(!$id || $this->isAdminOrSuperUser() || $table->created_by == JFactory::getUser()->id){
                return $result;
            } else {
                throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
            }
	}

	/**
	 * Method to check in an item.
	 *
	 * @param   integer $id The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int) $this->getState('place.id');
                if(!$id || $this->userIDItem($id) || $this->isAdminOrSuperUser()){
		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
			if (method_exists($table, 'checkin'))
			{
				if (!$table->checkin($id))
				{
					return false;
				}
			}
		}

		return true;
                }else{
                               throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                           }
	}

	/**
	 * Method to check out an item for editing.
	 *
	 * @param   integer $id The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int) $this->getState('place.id');

                if(!$id || $this->userIDItem($id) || $this->isAdminOrSuperUser()){
		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = Factory::getUser();

			// Attempt to check the row out.
			if (method_exists($table, 'checkout'))
			{
				if (!$table->checkout($user->get('id'), $id))
				{
					return false;
				}
			}
		}

		return true;
                }else{
                               throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                           }
	}

	/**
	 * Publish the element
	 *
	 * @param   int $id    Item id
	 * @param   int $state Publish state
	 *
	 * @return  boolean
	 */
	public function publish($id, $state)
	{
		$table = $this->getTable();
                if(!$id || $this->userIDItem($id) || $this->isAdminOrSuperUser()){
		$table->load($id);
		$table->state = $state;

		return $table->store();
                }else{
                               throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                           }
	}

	/**
	 * Method to delete an item
	 *
	 * @param   int $id Element id
	 *
	 * @return  bool
	 */
	public function delete($id)
	{
		$table = $this->getTable();

                if(!$id || $this->isAdminOrSuperUser() || $table->created_by == JFactory::getUser()->id){
                    return $table->delete($id);
                } else {
                    throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                    }
	}

	
}
