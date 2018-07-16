<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Movies
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 William del Rosario
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_movies', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_movies/js/form.js');

$user    = JFactory::getUser();
$canEdit = MoviesHelpersMovies::canUserEdit($this->item, $user);


if($this->item->state == 1){
	$state_string = 'Publish';
	$state_value = 1;
} else {
	$state_string = 'Unpublish';
	$state_value = 0;
}
if($this->item->id) {
	$canState = JFactory::getUser()->authorise('core.edit.state','com_movies.movie');
} else {
	$canState = JFactory::getUser()->authorise('core.edit.state','com_movies.movie.'.$this->item->id);
}
?>

<div class="test-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_MOVIES_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_MOVIES_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_MOVIES_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-test"
			  action="<?php echo JRoute::_('index.php?option=com_movies&task=test.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_movies&task=testform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_movies"/>
			<input type="hidden" name="task"
				   value="testform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>
