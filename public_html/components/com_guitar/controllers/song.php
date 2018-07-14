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

/**
 * Song controller class.
 *
 * @since  1.6
 */
class GuitarControllerSong extends JControllerLegacy
{
	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	public function edit()
	{
		$app = JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_guitar.edit.song.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_guitar.edit.song.id', $editId);

		// Get the model.
		$model = $this->getModel('Song', 'GuitarModel');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId && $previousId !== $editId)
		{
			$model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_guitar&view=songform&layout=edit', false));
	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return    void
	 *
	 * @throws Exception
	 * @since    1.6
	 */
	public function publish()
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Checking if the user can remove object
		$user = JFactory::getUser();

		if ($user->authorise('core.edit', 'com_guitar') || $user->authorise('core.edit.state', 'com_guitar'))
		{
			$model = $this->getModel('Song', 'GuitarModel');

			// Get the user data.
			$id    = $app->input->getInt('id');
			$state = $app->input->getInt('state');

			// Attempt to save the data.
			$return = $model->publish($id, $state);

			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(JText::sprintf('Save failed: %s', $model->getError()), 'warning');
			}

			// Clear the profile id from the session.
			$app->setUserState('com_guitar.edit.song.id', null);

			// Flush the data from the session.
			$app->setUserState('com_guitar.edit.song.data', null);

			// Redirect to the list screen.
			$this->setMessage(JText::_('COM_GUITAR_ITEM_SAVED_SUCCESSFULLY'));
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getActive();

			if (!$item)
			{
				// If there isn't any menu item active, redirect to list view
				$this->setRedirect(JRoute::_('index.php?option=com_guitar&view=songs', false));
			}
			else
			{
                $this->setRedirect(JRoute::_('index.php?Itemid='. $item->id, false));
			}
		}
		else
		{
			throw new Exception(500);
		}
	}

	/**
	 * Remove data
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function remove()
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Checking if the user can remove object
		$user = JFactory::getUser();

		if ($user->authorise('core.delete', 'com_guitar'))
		{
			$model = $this->getModel('Song', 'GuitarModel');

			// Get the user data.
			$id = $app->input->getInt('id', 0);

			// Attempt to save the data.
			$return = $model->delete($id);

			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			}
			else
			{
				// Check in the profile.
				if ($return)
				{
					$model->checkin($return);
				}

                $app->setUserState('com_guitar.edit.inventory.id', null);
                $app->setUserState('com_guitar.edit.inventory.data', null);

                $app->enqueueMessage(JText::_('COM_GUITAR_ITEM_DELETED_SUCCESSFULLY'), 'success');
                $app->redirect(JRoute::_('index.php?option=com_guitar&view=songs', false));
			}

			// Redirect to the list screen.
			$menu = JFactory::getApplication()->getMenu();
			$item = $menu->getActive();
			$this->setRedirect(JRoute::_($item->link, false));
		}
		else
		{
			throw new Exception(500);
		}
	}
}
||||||| merged common ancestors
=======
<?php
defined('_JEXEC') or die;

class GuitarControllerSong extends JControllerForm
{
    // Default model to load, will be class name of GuitarView{$view_item}
	protected $view_item = 'form';
    // Defaul view when using this controller, will class name GuitarView{$categories}
	protected $view_list = 'categories';

    // Custom add method to allow redirection to a specific page
	public function add() {
		if (!parent::add()) {
			// Redirect to the return page.
			$this->setRedirect($this->getReturnPage());
		}
	}

	protected function allowEdit($data = array(), $key = 'id') {

        // the default check is for the user to edit any song, if it is set
        // then we can return true

        // Since there is no asset tracking, revert to the component permissions.
        if (parent::allowEdit($data, $key)) {
            return true;
        }

        // If the user is not allowed to edit all songs, they may be allowed
        // to edit their own - so check if they are allowed to edit their own
        // and if this is their document
        $user		= JFactory::getUser();

		if ($user->authorise('core.edit.own',  $this->option)) {
			// If the user can edit his own songs, is this one of his songs?
			$ownerId	= (int) isset($data['created_by']) ? $data['created_by'] : 0;
            $recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
            if (empty($ownerId) && $recordId) {
				// Need to do a lookup from the model.
				$record		= $this->getModel()->getItem($recordId);

				if (empty($record)) {
					return false;
				}

				$ownerId = $record->created_by;
			}

			// If the owner is this user, then they may edit
            $userId		= $user->get('id');
            if ($ownerId == $userId) {
				return true;
			}
		}

        // Tests have failed, no edit allowed
        return false;

	}

    // Custom cancel method to allow redirection to a specific page
	public function cancel($key = 'id') {
		parent::cancel($key);

		// Redirect to the return page.
		$this->setRedirect($this->getReturnPage());
	}

    // Custom edit method to define the url variable containing the record id
    public function edit($key = null, $urlVar = 'id') {
		$result = parent::edit($key, $urlVar);
		return $result;
	}

    // Custom getModel method needed so we can define the model name as form instead of the default which would be song
    public function getModel($name = 'form', $prefix = '', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

    // Custom getRedirectToItemAppend method to redirect finished requests to display the item
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id') {

		$tmpl   = $this->input->get('tmpl');
		$append = '';

		// Setup redirect info.
		if ($tmpl) {
			$append .= '&tmpl='.$tmpl;
		}

        // Add the edit layout to force display of edit screen
		$append .= '&layout=edit';

        // For editing records, this is the record id
		if ($recordId) {
			$append .= '&'.$urlVar.'='.$recordId;
		}

        // If using a menu entry, get the menu id and append it
		$itemId	= $this->input->getInt('Itemid');
		if ($itemId) {
			$append .= '&Itemid='.$itemId;
		}

        // If the category id was specified, add it
        $catId  = $this->input->getInt('catid', null, 'get');
		if ($catId) {
			$append .= '&catid='.$catId;
		}

        // If a return page was specified, pass it on
        $return	= $this->getReturnPage();
        if ($return) {
			$append .= '&return='.base64_encode($return);
		}

		return $append;
	}

    // A return url can be used to bring the user back to whatever page they were on after they
    // save or cancel an edit screen
	protected function getReturnPage() {
		$return = $this->input->get('return', null, 'base64');

		if (empty($return) || !JUri::isInternal(base64_decode($return))) {
			return JURI::base();
		}
		else {
			return base64_decode($return);
		}
	}

	// Function that allows child controller access to model data after the data has been saved.
	protected function postSaveHook(JModelLegacy &$model, $validData) {
		$task = $this->getTask();

		if ($task == 'save') {
			$this->setRedirect(JRoute::_('index.php?option=com_guitar&view=category&id='.$validData['catid'], false));
		}
	}

    // Custom save function in order o set the redirect page upon saving of the record
	public function save($key = null, $urlVar = 'id') {

		$result = parent::save($key, $urlVar);

		// If ok, redirect to the return page.
		if ($result) {
			$this->setRedirect($this->getReturnPage());
		}
		return $result;
	}
}
>>>>>>> 49269d37ee293462d1afd29c6dbe34c925905cdb
