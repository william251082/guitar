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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_guitar.' . $this->item->id);

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_guitar' . $this->item->id))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_DESCRIPTION'); ?></th>
			<td><?php echo nl2br($this->item->description); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_RELEASE_DATE'); ?></th>
			<td><?php echo $this->item->release_date; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_REVIEW'); ?></th>
			<td><?php echo nl2br($this->item->review); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_RATING'); ?></th>
			<td><?php echo $this->item->rating; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_CREDITS'); ?></th>
			<td><?php echo $this->item->credits; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_CATID'); ?></th>
			<td><?php echo $this->item->catid; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_GENRE'); ?></th>
			<td><?php echo $this->item->genre; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_SONG_GUITARIST'); ?></th>
			<td><?php echo $this->item->guitarist; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_guitar&task=song.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_GUITAR_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_guitar.song.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_GUITAR_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_GUITAR_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_GUITAR_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_guitar&task=song.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_GUITAR_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>