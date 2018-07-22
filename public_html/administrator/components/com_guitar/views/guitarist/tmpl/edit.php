<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Guitar
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 com_guitar
 * @license    Proprietary License; For my customers only
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
		
	js('input:hidden.songs').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('songshidden')){
			js('#jform_songs option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_songs").trigger("liszt:updated");
	js('input:hidden.genre').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('genrehidden')){
			js('#jform_genre option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_genre").trigger("liszt:updated");
	js('input:hidden.transaction').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('transactionhidden')){
			js('#jform_transaction option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_transaction").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'guitarist.cancel') {
			Joomla.submitform(task, document.getElementById('guitarist-form'));
		}
		else {
			
			if (task != 'guitarist.cancel' && document.formvalidator.isValid(document.id('guitarist-form'))) {
				
				Joomla.submitform(task, document.getElementById('guitarist-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_guitar&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="guitarist-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_GUITAR_TITLE_GUITARIST', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<?php echo $this->form->renderField('name'); ?>
				<?php echo $this->form->renderField('description'); ?>
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('songs'); ?>

			<?php
				foreach((array)$this->item->songs as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="songs" name="jform[songshidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('genre'); ?>

			<?php
				foreach((array)$this->item->genre as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="genre" name="jform[genrehidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('transaction'); ?>

			<?php
				foreach((array)$this->item->transaction as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="transaction" name="jform[transactionhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>

					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
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

	</div>
</form>
