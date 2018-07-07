<?php
defined('_JEXEC') or die;
?>
<div class="item-page guitar-songs">
	<?php   if (empty($this->items)) { ?>
		<p> <?php echo JText::_('COM_GUITAR_NO_SONGS'); ?></p>
	<?php   }
	else {
		foreach ( $this->items as $i => $item ) { ?>
            <p>
                <a href="<?php echo JRoute::_(
					'index.php?option=com_guitar&view=song&id=' . $item->id
				); ?>">
					<?php echo $item->title; ?>
                </a>
            </p>
		<?php }
	}
	?>
</div>