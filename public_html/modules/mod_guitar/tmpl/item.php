<?php
/**
 * @version     CVS: 1.0.0
 * @package     com_guitar
 * @subpackage  mod_guitar
 * @author      William del Rosario <williamdelrosario@yahoo.com>
 * @copyright   2018 com_guitar
 * @license     Proprietary License; For my customers only
 */
defined('_JEXEC') or die;
$element = ModGuitarHelper::getItem($params);
?>

<?php if (!empty($element)) : ?>
	<div>
		<?php $fields = get_object_vars($element); ?>
		<?php foreach ($fields as $field_name => $field_value) : ?>
			<?php if (ModGuitarHelper::shouldAppear($field_name)): ?>
				<div class="row">
					<div class="span4">
						<strong><?php echo ModGuitarHelper::renderTranslatableHeader($params, $field_name); ?></strong>
					</div>
					<div
						class="span8"><?php echo ModGuitarHelper::renderElement($params->get('item_table'), $field_name, $field_value); ?></div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif;
