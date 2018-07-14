<?php
defined('_JEXEC') or die;
?>
<div class="item-page guitar-categories">
<?php   if (!empty($this->items)) { ?>

            <table class="table table-striped" id="categoriesList">
                <thead>
                    <tr>
                        <th width="1%" class="left">
                            <?php echo JText::_('COM_GUITAR_CATEGORIES'); ?>
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
                                <a href="<?php echo JRoute::_('index.php?option=com_guitar&view=category&id='.(int) $item->id); ?>">
                                    <?php echo $this->escape($item->title); ?>
                                </a>
                        </td>
                    </tr>
                    <?php }; ?>
                </tbody>
            </table>
<?php
		}
?>
</div>