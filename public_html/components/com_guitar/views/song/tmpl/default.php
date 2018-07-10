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
            <?php echo $this->item->author; ?>
        </p>

        <div class="song-submission-info">
            <?php if (!empty($this->params['show_author'])) {  ?>
                <div class="song-author">
                	<span class="gc-label">
                    	<?php echo JText::_('COM_GUITAR_SONG_AUTHOR'); ?>
                    </span>
                    <span class="gc-data">
							<?php echo $this->item->author; ?>
						</span>
                </div>
            <?php } ?>
            <?php if (!empty($this->params['show_publish_date'])) {  ?>
                <div class="song-created-date">
                	<span class="gc-label">
                    	<?php echo JText::_('COM_GUITAR_SONG_CREATED_DATE'); ?>
                    </span>
                    <span class="gc-data">
							<?php echo date('M j, Y', strtotime($this->item->created));  ?>
						</span>
                </div>
                <div style="clear:both;"></div>
            <?php } ?>
        </div>

    <?php }
    ?>
</div>