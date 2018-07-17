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

/**
 * Helper for mod_guitar
 *
 * @package     com_guitar
 * @subpackage  mod_guitar
 * @since       1.6
 */
class ModGuitarHelper
{
	/**
	 * Retrieve component items
	 *
	 * @param   Joomla\Registry\Registry &$params module parameters
	 *
	 * @return array Array with all the elements
	 */
	public static function getList(&$params)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		/* @var $params Joomla\Registry\Registry */
		$query
			->select('*')
			->from($params->get('table'))
			->where('state = 1');

		$db->setQuery($query, $params->get('offset'), $params->get('limit'));
		$rows = $db->loadObjectList();

		return $rows;
	}

	/**
	 * Retrieve component items
	 *
	 * @param   Joomla\Registry\Registry &$params module parameters
	 *
	 * @return mixed stdClass object if the item was found, null otherwise
	 */
	public static function getItem(&$params)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		/* @var $params Joomla\Registry\Registry */
		$query
			->select('*')
			->from($params->get('item_table'))
			->where('id = ' . intval($params->get('item_id')));

		$db->setQuery($query);
		$element = $db->loadObject();

		return $element;
	}

	/**
	 * Render element
	 *
	 * @param   Joomla\Registry\Registry $table_name  Table name
	 * @param   string                   $field_name  Field name
	 * @param   string                   $field_value Field value
	 *
	 * @return string
	 */
	public static function renderElement($table_name, $field_name, $field_value)
	{
		$result = '';
		
		switch ($table_name)
		{
			
		case '#__guitar_songs':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'title':
		$result = $field_value;
		break;
		case 'description':
		$result = $field_value;
		break;
		case 'release_date':
		$result = $field_value;
		break;
		case 'review':
		$result = $field_value;
		break;
		case 'rating':
		$result = $field_value;
		break;
		case 'credits':
		$result = $field_value;
		break;
		case 'guitarist':
		$result = self::loadValueFromExternalTable('#__guitar_guitarists', 'id', 'name', $field_value);
		break;
		case 'catid':
		$result = self::loadValueFromExternalTable('#__categories', 'id', 'title', $field_value);
		break;
		case 'genre':
		$result = self::loadValueFromExternalTable('#__guitar_genre', 'id', 'name', $field_value);
		break;
		}
		break;
		case '#__guitar_guitarists':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'name':
		$result = $field_value;
		break;
		case 'songs':
		$result = self::loadValueFromExternalTable('#__guitar_songs', 'id', 'title', $field_value);
		break;
		case 'genre':
		$result = self::loadValueFromExternalTable('#__guitar_genre', 'id', 'name', $field_value);
		break;
		}
		break;
		case '#__guitar_transactions':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'title':
		$result = $field_value;
		break;
		case 'description':
		$result = $field_value;
		break;
		case 'guitarist':
		$result = self::loadValueFromExternalTable('#__guitar_guitarists', 'id', 'name', $field_value);
		break;
		case 'place':
		$result = self::loadValueFromExternalTable('#__guitar_place', 'id', 'name', $field_value);
		break;
		case 'group':
		$result = self::loadValueFromExternalTable('#__guitar_groups', 'id', 'name', $field_value);
		break;
		}
		break;
		case '#__guitar_groups':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'name':
		$result = $field_value;
		break;
		case 'description':
		$result = $field_value;
		break;
		case 'transaction':
		$result = self::loadValueFromExternalTable('#__guitar_transactions', 'id', 'title', $field_value);
		break;
		case 'place':
		$result = self::loadValueFromExternalTable('#__guitar_place', 'id', 'name', $field_value);
		break;
		}
		break;
		case '#__guitar_place':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'name':
		$result = $field_value;
		break;
		case 'description':
		$result = $field_value;
		break;
		case 'lat':
		$result = $field_value;
		break;
		case 'lng':
		$result = $field_value;
		break;
		case 'country_code':
		$result = $field_value;
		break;
		case 'transaction':
		$result = self::loadValueFromExternalTable('#__guitar_transactions', 'id', 'title', $field_value);
		break;
		case 'group':
		$result = self::loadValueFromExternalTable('#__guitar_groups', 'id', 'name', $field_value);
		break;
		}
		break;
		case '#__guitar_genre':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'name':
		$result = $field_value;
		break;
		case 'description':
		$result = $field_value;
		break;
		case 'songs':
		$result = self::loadValueFromExternalTable('#__guitar_songs', 'id', 'title', $field_value);
		break;
		case 'guitarists':
		$result = self::loadValueFromExternalTable('#__guitar_guitarists', 'id', 'name', $field_value);
		break;
		}
		break;
		}

		return $result;
	}

	/**
	 * Returns the translatable name of the element
	 *
	 * @param   Joomla\Registry\Registry &$params Module parameters
	 * @param   string                   $field   Field name
	 *
	 * @return string Translatable name.
	 */
	public static function renderTranslatableHeader(&$params, $field)
	{
		return JText::_(
			'MOD_GUITAR_HEADER_FIELD_' . str_replace('#__', '', strtoupper($params->get('table'))) . '_' . strtoupper($field)
		);
	}

	/**
	 * Checks if an element should appear in the table/item view
	 *
	 * @param   string $field name of the field
	 *
	 * @return boolean True if it should appear, false otherwise
	 */
	public static function shouldAppear($field)
	{
		$noHeaderFields = array('checked_out_time', 'checked_out', 'ordering', 'state');

		return !in_array($field, $noHeaderFields);
	}

	

    /**
     * Method to get a value from a external table
     * @param string $source_table Source table name
     * @param string $key_field Source key field 
     * @param string $value_field Source value field
     * @param mixed  $key_value Value for the key field
     * @return mixed The value in the external table or null if it wasn't found
     */
    private static function loadValueFromExternalTable($source_table, $key_field, $value_field, $key_value) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select($db->quoteName($value_field))
                ->from($source_table)
                ->where($db->quoteName($key_field) . ' = ' . $db->quote($key_value));


        $db->setQuery($query);
        return $db->loadResult();
    }
}
