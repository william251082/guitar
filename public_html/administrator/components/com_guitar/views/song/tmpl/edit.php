<?php
defined('_JEXEC') or die;
// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task === 'song.cancel' || document.formvalidator.isValid(document.id('guitar-song-form'))) {
            <?php echo $this->form->getField('song')->save(); ?>
            Joomla.submitform(task, document.getElementById('guitar-song-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_guitar&layout=edit&id=' . (int)$this->item->id); ?>"
      method="post" name="adminForm" id="guitar-song-form" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">

            <fieldset>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#details" data-toggle="tab"><?php echo empty(
                                $this->item->id
                            ) ? JText::_('COM_GUITAR_NEW_SONG') : JText::sprintf(
                                    'COM_GUITAR_EDIT_SONG', $this->item->id
                            ); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#metadata" data-toggle="tab"><?php echo JText::_(
                                'JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#publishingoptions" data-toggle="tab"><?php echo JText::_(
                                'JGLOBAL_FIELDSET_PUBLISHING_OPTIONS');?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('album'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('album'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
                        </div>
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('song'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('song'); ?></div>
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

                    <input type="hidden" name="task" value=""/>
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </fieldset>

        </div>

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