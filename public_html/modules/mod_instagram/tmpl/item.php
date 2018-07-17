<?php
/**
 * @version     CVS: 1.0.0
 * @package     com_instagram
 * @subpackage  mod_instagram
 * @author      com_instagram <williamdelrosario@yahoo.com>
 * @copyright   2018 com_instagram
 * @license     Proprietary License; For my customers only
 */
defined('_JEXEC') or die;
$element = ModInstagramHelper::getItem($params);
?>

<?php if (!empty($element)) : ?>
	<div>
		<?php $fields = get_object_vars($element); ?>
		<?php foreach ($fields as $field_name => $field_value) : ?>
			<?php if (ModInstagramHelper::shouldAppear($field_name)): ?>
				<div class="row">
					<div class="span4">
						<strong><?php echo ModInstagramHelper::renderTranslatableHeader($params, $field_name); ?></strong>
					</div>
					<div
						class="span8"><?php echo ModInstagramHelper::renderElement($params->get('item_table'), $field_name, $field_value); ?></div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif;
