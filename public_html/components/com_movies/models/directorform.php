<?php
/**
 * @version    CVS: 1.0.1
 * @package    Com_Movies
 * @author     com_movies <williamdelrosario@yahoo.com>
 * @copyright  2018 com_movies
 * @license    Proprietary License; For my customers only
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

/**
 * Movies model.
 *
 * @since  1.6
 */
class MoviesModelDirectorForm extends JModelForm
{
    private $item = null;

    
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
                      ->from($db->quoteName('#__movies_directors'))
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
     * @since  1.6
     */
    protected function populateState()
    {
        $app = Factory::getApplication('com_movies');

        // Load state from the request userState on edit or from the passed variable on default
        if (Factory::getApplication()->input->get('layout') == 'edit')
        {
                $id = Factory::getApplication()->getUserState('com_movies.edit.director.id');
        }
        else
        {
                $id = Factory::getApplication()->input->get('id');
                Factory::getApplication()->setUserState('com_movies.edit.director.id', $id);
        }

        $this->setState('director.id', $id);

        // Load the parameters.
        $params       = $app->getParams();
        $params_array = $params->toArray();

        if (isset($params_array['item_id']))
        {
                $this->setState('director.id', $params_array['item_id']);
        }

        $this->setState('params', $params);
    }

    /**
     * Method to get an ojbect.
     *
     * @param   integer $id The id of the object to get.
     *
     * @return Object|boolean Object on success, false on failure.
     *
     * @throws Exception
     */
    public function getItem($id = null)
    {
        if ($this->item === null)
        {
            $this->item = false;

            if (empty($id))
            {
                    $id = $this->getState('director.id');
            }

            // Get a level row instance.
            $table = $this->getTable();

            if ($table !== false && $table->load($id))
            {
                $user = Factory::getUser();
                $id   = $table->id;
                if(!$id || $this->isAdminOrSuperUser() || $table->created_by == JFactory::getUser()->id){

                
				if ($id)
				{
					$canEdit = $user->authorise('core.edit', 'com_movies.director.' . $id) || $user->authorise('core.create', 'com_movies.director.' . $id);
				}
				else
				{
					$canEdit = $user->authorise('core.edit', 'com_movies') || $user->authorise('core.create', 'com_movies');
				}

                if (!$canEdit && $user->authorise('core.edit.own', 'com_movies.director.' . $id))
                {
                        $canEdit = $user->id == $table->created_by;
                }

                if (!$canEdit)
                {
                        throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
                }

                // Check published state.
                if ($published = $this->getState('filter.published'))
                {
                        if (isset($table->state) && $table->state != $published)
                        {
                                return $this->item;
                        }
                }

                // Convert the JTable to a clean JObject.
                $properties = $table->getProperties(1);
                $this->item = ArrayHelper::toObject($properties, 'JObject');
                
		if (is_object($this->item->catid))
		{
			$this->item->catid = ArrayHelper::fromObject($this->item->catid);
		}

                } else {
                                                throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                                          }
            }
        }

        return $this->item;
    }

    /**
     * Method to get the table
     *
     * @param   string $type   Name of the JTable class
     * @param   string $prefix Optional prefix for the table class name
     * @param   array  $config Optional configuration array for JTable object
     *
     * @return  JTable|boolean JTable if found, boolean false on failure
     */
    public function getTable($type = 'Director', $prefix = 'MoviesTable', $config = array())
    {
        $this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_movies/tables');

        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Get an item by alias
     *
     * @param   string $alias Alias string
     *
     * @return int Element id
     */
    public function getItemIdByAlias($alias)
    {
        $table      = $this->getTable();
        $properties = $table->getProperties();

        if (!in_array('alias', $properties))
        {
                return null;
        }

        $table->load(array('alias' => $alias));


        if(!$id || $this->isAdminOrSuperUser() || $table->created_by == JFactory::getUser()->id){
            return $table->id;
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
        $id = (!empty($id)) ? $id : (int) $this->getState('director.id');
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
        $id = (!empty($id)) ? $id : (int) $this->getState('director.id');
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
     * Method to get the profile form.
     *
     * The base form is loaded from XML
     *
     * @param   array   $data     An optional array of data for the form to interogate.
     * @param   boolean $loadData True if the form is to load its own data (default case), false if not.
     *
     * @return    JForm    A JForm object on success, false on failure
     *
     * @since    1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_movies.director', 'directorform', array(
                        'control'   => 'jform',
                        'load_data' => $loadData
                )
        );

        if (empty($form))
        {
                return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return    mixed    The data for the form.
     *
     * @since    1.6
     */
    protected function loadFormData()
    {
        $data = Factory::getApplication()->getUserState('com_movies.edit.director.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
        }
        

        return $data;
    }

    /**
     * Method to save the form data.
     *
     * @param   array $data The form data
     *
     * @return bool
     *
     * @throws Exception
     * @since 1.6
     */
    public function save($data)
    {
        $id    = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('director.id');
        $state = (!empty($data['state'])) ? 1 : 0;
        $user  = Factory::getUser();

        if(!$id || $this->userIDItem($id) || $this->isAdminOrSuperUser()){
        if ($id)
        {
            // Check the user can edit this item
            $authorised = $user->authorise('core.edit', 'com_movies.director.' . $id) || $authorised = $user->authorise('core.edit.own', 'com_movies.director.' . $id);
        }
        else
        {
            // Check the user can create new items in this section
            $authorised = $user->authorise('core.create', 'com_movies');
        }

        if ($authorised !== true)
        {
            throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
        }

        $table = $this->getTable();

        if ($table->save($data) === true)
        {
            return $table->id;
        }
        else
        {
            return false;
        }
        }else{
                               throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                           }
    }

    /**
     * Method to delete data
     *
     * @param   int $pk Item primary key
     *
     * @return  int  The id of the deleted item
     *
     * @throws Exception
     *
     * @since 1.6
     */
    public function delete($pk)
    {
        $user = Factory::getUser();

        if(!$pk || $this->userIDItem($pk) || $this->isAdminOrSuperUser()){
            if (empty($pk))
            {
                    $pk = (int) $this->getState('director.id');
            }

            if ($pk == 0 || $this->getItem($pk) == null)
            {
                    throw new Exception(JText::_('COM_MOVIES_ITEM_DOESNT_EXIST'), 404);
            }

            if ($user->authorise('core.delete', 'com_movies.director.' . $id) !== true)
            {
                    throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
            }

            $table = $this->getTable();

            if ($table->delete($pk) !== true)
            {
                    throw new Exception(JText::_('JERROR_FAILED'), 501);
            }

            return $pk;
        }else{
                               throw new Exception(JText::_("JERROR_ALERTNOAUTHOR"), 401);
                           }
    }

    /**
     * Check if data can be saved
     *
     * @return bool
     */
    public function getCanSave()
    {
        $table = $this->getTable();

        return $table !== false;
    }
    
}
