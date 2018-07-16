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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_guitar/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'song.cancel') {
			Joomla.submitform(task, document.getElementById('song-form'));
		}
		else {
			
			if (task != 'song.cancel' && document.formvalidator.isValid(document.id('song-form'))) {
				
				Joomla.submitform(task, document.getElementById('song-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
        action="<?php echo JRoute::_(
                'index.php?option=com_guitar&layout=edit&id='.(int) $this->item->id
        ); ?>"
        method="post"
        name="adminForm"
        id="song-form"
        class="form-validate"
>
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#details" data-toggle="tab">
                            <?php echo empty($this->item->id) ? JText::_(
                                    'COM_GUITAR_NEW_SONG') : JText::sprintf('COM_GUITAR_EDIT_SONG', $this->item->id
                            ); ?>
                        </a>
                    </li>
                    <li><a href="#metadata" data-toggle="tab"><?php echo JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS');?></a></li>
                    <li><a href="#publishingoptions" data-toggle="tab"><?php echo JText::_('JGLOBAL_FIELDSET_PUBLISHING');?></a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('song_title'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('song_title'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('song_info'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('song_info'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="metadata">
                        <fieldset>
                            <?php echo $this->loadTemplate('metadata'); ?>
                        </fieldset>
                    </div>
                    <div class="tab-pane" id="publishingoptions">
                        <fieldset>
                            <?php echo $this->loadTemplate('publishingoptions'); ?>
                        </fieldset>
                    </div>
                    <input type="hidden" name="task" value="" />
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </fieldset>

        </div>
    </div>
</form>














