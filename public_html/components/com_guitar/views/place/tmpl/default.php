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
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_PLACE_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_PLACE_DESCRIPTION'); ?></th>
			<td><?php echo nl2br($this->item->description); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_PLACE_LAT'); ?></th>
			<td><?php echo $this->item->lat; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_PLACE_LNG'); ?></th>
			<td><?php echo $this->item->lng; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_PLACE_COUNTRY_CODE'); ?></th>
			<td><?php echo $this->item->country_code; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_PLACE_TRANSACTION'); ?></th>
			<td><?php echo $this->item->transaction; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_GUITAR_FORM_LBL_PLACE_GROUP'); ?></th>
			<td><?php echo $this->item->group; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_guitar&task=place.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_GUITAR_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_guitar.place.'.$this->item->id)) : ?>

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
			<a href="<?php echo JRoute::_('index.php?option=com_guitar&task=place.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_GUITAR_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>