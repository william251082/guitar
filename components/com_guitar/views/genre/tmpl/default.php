<?php
defined('_JEXEC') or die;
?>
<div class="item-page guitar-genre">
	<?php   if (empty($this->item)) { ?>
		<p>
            <?php echo JText::_('COM_GUITAR_NO_GENRE'); ?>
        </p>
	<?php   }
	else { ?>
            <h3>
                <?php  echo $this->item->title; ?>
            </h3>
			<p>
                <?php echo $this->item->genre; ?>
            </p>
		<?php   	}
	?>
</div>