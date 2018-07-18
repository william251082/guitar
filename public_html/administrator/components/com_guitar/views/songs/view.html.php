<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Guitar
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 com_guitar
 * @license    Proprietary License; For my customers only
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Guitar.
 *
 * @since  1.6
 */
class GuitarViewSongs extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		GuitarHelper::addSubmenu('songs');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = GuitarHelper::getActions();

		JToolBarHelper::title(JText::_('COM_GUITAR_TITLE_SONGS'), 'songs.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/song';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('song.add', 'JTOOLBAR_NEW');

				if (isset($this->items[0]))
				{
					JToolbarHelper::custom('songs.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
				}
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('song.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('songs.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('songs.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'songs.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('songs.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('songs.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'songs.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('songs.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_guitar');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_guitar&view=songs');

        JHtmlSidebar::addFilter(

            JText::_('JOPTION_SELECT_PUBLISHED'),

            'filter_published',

            JHtml::_('select.options', JHtml::_(
                'jgrid.publishedOptions'
            ), "value", "text", $this->state->get('filter.state'), true)

        );
        $select_label = JText::_('COM_GUITAR_STATE_FILTER');
        $options = array();
        $options[0] = new stdClass();
        $options[0]->value = "0";
        $options[0]->text = 'COM_GUITAR_STATE_INCOMPLETE';
        $options[1] = new stdClass();
        $options[1]->value = "1";
        $options[1]->text = 'COM_GUITAR_STATE_COMPLETE';

        JHtmlSidebar::addFilter(
            $select_label,
            'filter_state',
            JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.status'), true)
        );

        JHtmlSidebar::addFilter(
            JText::_("JOPTION_SELECT_CATEGORY"),
            'filter_catid',
            JHtml::_('select.options', JHtml::_(
                'category.options', 'com_guitar'
            ), "value", "text", $this->state->get('filter.catid'))

        );
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.`id`' => JText::_('JGRID_HEADING_ID'),
			'a.`ordering`' => JText::_('JGRID_HEADING_ORDERING'),
			'a.`state`' => JText::_('JSTATUS'),
			'a.`title`' => JText::_('COM_GUITAR_SONGS_TITLE'),
			'a.`release_date`' => JText::_('COM_GUITAR_SONGS_RELEASE_DATE'),
			'a.`rating`' => JText::_('COM_GUITAR_SONGS_RATING'),
			'a.`guitarist`' => JText::_('COM_GUITAR_SONGS_GUITARIST'),
			'a.`catid`' => JText::_('COM_GUITAR_SONGS_CATID'),
			'a.`genre`' => JText::_('COM_GUITAR_SONGS_GENRE'),
		);
	}

    /**
     * Check if state is set
     *
     * @param   mixed  $state  State
     *
     * @return bool
     */
    public function getState($state)
    {
        return isset($this->state->{$state}) ? $this->state->{$state} : false;
    }
}
