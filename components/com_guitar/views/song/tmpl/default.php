<?php
defined('_JEXEC') or die;
?>
<div class="item-page guitar-song">
    <?php if (empty($this->item)) { ?>
        <p>
            <?php echo JText::_('COM_GUITAR_NO_SONG'); ?>
        </p>
    <?php } else { ?>
        <h3>
            <?php echo $this->item->album; ?>
        </h3>
        <p>
            <?php echo $this->item->song; ?>
        </p>
    <?php }
    ?>
</div>