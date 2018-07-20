<?php
/**
 * View file for responding to Ajax request for performing Search Here on the map
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class PlaceViewPlace extends JViewLegacy
{
    /**
     * This display function returns in json format the Places
     *   found within the latitude and longitude boundaries of the map.
     * These bounds are provided in the parameters
     *   minlat, minlng, maxlat, maxlng
     */

    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;
        $mapbounds = $input->get('mapBounds', array(), 'ARRAY');
        $model = $this->getModel();
        if ($mapbounds)
        {
            $records = $model->getMapSearchResults($mapbounds);
            if ($records)
            {
                echo new JResponseJson($records);
            }
            else
            {
                echo new JResponseJson(null, JText::_('COM_GUITAR_ERROR_NO_RECORDS'), true);
            }
        }
        else
        {
            $records = array();
            echo new JResponseJson(null, JText::_('COM_GUITAR_ERROR_NO_MAP_BOUNDS'), true);
        }
    }
}