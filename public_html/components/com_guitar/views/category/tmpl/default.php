<?php
defined('_JEXEC') or die;
?>
<div class="item-page guitar-songs">
<?php   if (!empty($this->items)) { ?>

            <table class="table table-striped" id="songsList">
                <thead>
                    <tr>
                        <th class="title">
                            <?php echo JText::_('COM_GUITAR_SONG_TITLE'); ?>
                        </th>
                        <th width="1%" class="nowrap center">
                            <?php echo JText::_('COM_GUITAR_CATEGORY'); ?>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td>
                    </tr>
                </tfoot>
                <tbody>
                <?php foreach ($this->items as $i => $item) { ?>
                    <tr class="row<?php echo $i % 2; ?>" >
                        <td>
                                <a href="<?php echo JRoute::_('index.php?option=com_guitar&view=song&id='.(int) $item->id); ?>">
                                    <?php echo $this->escape($item->song_title); ?>
                                </a>
                        </td>
                        <td class="left">
                            <?php echo $item->category_title; ?>
                        </td>
                    </tr>
                    <?php }; ?>
                </tbody>
            </table>
<?php
		}
?>
</div>