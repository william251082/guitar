<?php
/**
 * @version    CVS: 1.0.1
 * @package    Com_Movies
 * @author     com_movies <williamdelrosario@yahoo.com>
 * @copyright  2018 com_movies
 * @license    Proprietary License; For my customers only
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_movies.' . $this->item->id);

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_movies' . $this->item->id))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by_name; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_DESCRIPTION'); ?></th>
			<td><?php echo nl2br($this->item->description); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_RELEASE_DATE'); ?></th>
			<td><?php echo $this->item->release_date; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_RATING'); ?></th>
			<td><?php echo $this->item->rating; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_REVIEW'); ?></th>
			<td><?php echo nl2br($this->item->review); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_AWARDS'); ?></th>
			<td><?php echo $this->item->awards; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_STARRING'); ?></th>
			<td><?php echo nl2br($this->item->starring); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_DIRECTOR'); ?></th>
			<td><?php echo $this->item->director; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_MOVIES_FORM_LBL_MOVIE_CATID'); ?></th>
			<td><?php echo $this->item->catid; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_movies&task=movie.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_MOVIES_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_movies.movie.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_MOVIES_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_MOVIES_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_MOVIES_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_movies&task=movie.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_MOVIES_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>