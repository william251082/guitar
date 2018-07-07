<?php
defined('_JEXEC') or die;
?>
<div class="item-page guitar-songs">
	<?php   if (empty($this->items)) { ?>
		<p> <?php echo JText::_('COM_GUITAR_NO_SONGS'); ?></p>
	<?php   }
	else {
		foreach ($this->items as $i => $item) { ?>
			<p><?php echo $item->title; ?></p>
		<?php   	}
	}
	?>
</div>