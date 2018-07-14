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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_guitar') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'songform.xml');
$canEdit    = $user->authorise('core.edit', 'com_guitar') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'songform.xml');
$canCheckin = $user->authorise('core.manage', 'com_guitar');
$canChange  = $user->authorise('core.edit.state', 'com_guitar');
$canDelete  = $user->authorise('core.delete', 'com_guitar');
?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post"
      name="adminForm" id="adminForm">

	
	<table class="table table-striped" id="songList">
		<thead>
		    <tr>
		    	<?php if (isset($this->items[0]->state)): ?>

		    	<?php endif; ?>

                <th class="id">
		    		<?php echo JHtml::_('grid.sort',  'COM_GUITAR_SONGS_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>

                <th class="title">
                    <?php echo JText::_('COM_GUITAR_SONG_TITLE'); ?>
                </th>
                <th width="1%" class="left">
                    <?php echo JText::_('COM_GUITAR_GENRE'); ?>
                </th>

                <?php if ($canEdit || $canDelete): ?>
                    <th class="right">
		    		    <?php echo JText::_('COM_GUITAR_SONGS_ACTIONS'); ?>
                    </th>
		    		<?php endif; ?>
		    </tr>
		</thead>

		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_guitar'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_guitar')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
					
				<?php endif; ?>

                <td>
					<?php echo $item->id;?>
				</td>
                <td>
                    <a href="<?php echo JRoute::_(
                        'index.php?option=com_guitar&view=song&id=' . $item->song_title
                    ); ?>">
                        <?php echo $item->song_title;?>
                    </a>
                </td>
                <td width="25%"  class="left">
                    <?php echo $item->category_title; ?>
                </td>
								<?php if ($canEdit || $canDelete): ?>
					<td width="25%" class="right">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_guitar&task=songform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_guitar&task=songform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></a>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>

        <tfoot>
        <tr>
            <td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>

	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_guitar&task=songform.edit&id=0', false, 0); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_GUITAR_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php if($canDelete) : ?>
<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {

		if (!confirm("<?php echo JText::_('COM_GUITAR_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>
