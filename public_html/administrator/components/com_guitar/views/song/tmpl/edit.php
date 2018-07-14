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
	action="<?php echo JRoute::_('index.php?option=com_guitar&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="song-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_GUITAR_TITLE_SONG', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">

				<fieldset class="adminform">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#details" data-toggle="tab"><?php echo empty($this->item->id) ? JText::_(
                                    'COM_GUITAR_NEW_SONG') : JText::sprintf('COM_GUITAR_EDIT_SONG', $this->item->id
                                ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="#metadata" data-toggle="tab"><?php echo JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS');?>
                            </a>
                        </li>
                        <li>
                            <a href="#publishingoptions" data-toggle="tab"><?php echo JText::_(
                                    'JGLOBAL_FIELDSET_PUBLISHING'
                                );?>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="details">
                            <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
<!--					--><?php //if ($this->state->params->get('save_history', 1)) : ?>
<!--					    <div class="control-group">-->
<!--					    	<div class="control-label">--><?php //echo $this->form->getLabel('version_note'); ?><!--</div>-->
<!--					    	<div class="controls">--><?php //echo $this->form->getInput('version_note'); ?><!--</div>-->
<!--					    </div>-->
<!--                        <div class="control-group">-->
<!--                            <div class="control-label">--><?php //echo $this->form->getLabel('id'); ?><!--</div>-->
<!--                            <div class="controls">--><?php //echo $this->form->getInput('id'); ?><!--</div>-->
<!--                        </div>-->

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

<!--					--><?php //endif; ?>

                        </div>
                    </div>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php if (JFactory::getUser()->authorise('core.admin','guitar')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php endif; ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

        <!-- Begin Sidebar -->
        <div class="span2">
            <h4><?php echo JText::_('JDETAILS');?></h4>
            <hr />
            <fieldset class="form-vertical">
                <div class="control-group">
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $this->form->getValue('name'); ?>
                        </div>
                    </div>
                    <div class="control-label">
                        <?php echo $this->form->getLabel('published'); ?>
                    </div>
                    <div class="controls">
                        <?php echo $this->form->getInput('published'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <!-- End Sidebar -->
	</div>
</form>
