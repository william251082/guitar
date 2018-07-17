<?php
/**
 * @version     CVS: 1.0.1
 * @package     com_movies
 * @subpackage  mod_movies
 * @author      com_movies <williamdelrosario@yahoo.com>
 * @copyright   2018 com_movies
 * @license     Proprietary License; For my customers only
 */
defined('_JEXEC') or die;
$element = ModMoviesHelper::getItem($params);
?>

<?php if (!empty($element)) : ?>
	<div>
		<?php $fields = get_object_vars($element); ?>
		<?php foreach ($fields as $field_name => $field_value) : ?>
			<?php if (ModMoviesHelper::shouldAppear($field_name)): ?>
				<div class="row">
					<div class="span4">
						<strong><?php echo ModMoviesHelper::renderTranslatableHeader($params, $field_name); ?></strong>
					</div>
					<div
						class="span8"><?php echo ModMoviesHelper::renderElement($params->get('item_table'), $field_name, $field_value); ?></div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif;
