<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
global $params;
?>

<div class="item-page guitar-song">
    <?php if (empty($this->item)) { ?>
        <p><?php echo JText::_('COM_GUITAR_NO_SONG'); ?></p>
    <?php } else { ?>
        <?php if (!$this->print) { ?>
            <div class="btn-group pull-right">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-cog"></i>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu actions">
                    <li class="print-icon">
                        <?php echo JHtml::_('icon.print_popup', $this->item, $params); ?>
                    </li>
                    <li class="email-icon">
                        <?php echo JHtml::_('icon.email', $this->item, $params); ?>
                    </li>
                </ul>
            </div>
            <?php
        } else { ?>
            <div class="pull-right">
                <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
            </div>
            <?php
        } ?>
        <h3><?php echo $this->item->album; ?></h3>

        <?php if ($this->item->canEdit) : ?>
            <?php echo 'Edit song: '.$this->item->editLink; ?>
        <?php endif; ?>

        <p><?php echo $this->item->song; ?></p>

        <div class="song-submission-info">
            <?php if (!empty($this->params['show_author'])) { ?>
                <div class="song-author">
                	<span class="gc-label">
                    	<?php echo JText::_('COM_GUITAR_SONG_ARTIST'); ?>
                    </span>
                    <span class="gc-data">
                    	<?php echo $this->item->author; ?>
                    </span>
                </div>
            <?php } ?>
            <?php if (!empty($this->params['show_publish_date'])) { ?>
                <div class="song-created-date">
                	<span class="gc-label">
                    	<?php echo JText::_('COM_GUITAR_SONG_CREATED_DATE'); ?>
                    </span>
                    <span class="gc-data">
                    	<?php echo date('M j, Y', strtotime($this->item->created)); ?>
                    </span>
                </div>
            <?php } ?>
            <div style="clear:both;"></div>
        </div>
    <?php } ?>
</div>