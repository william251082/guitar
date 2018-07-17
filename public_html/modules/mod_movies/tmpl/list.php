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
$elements = ModMoviesHelper::getList($params);
?>

<?php if (!empty($elements)) : ?>
	<table class="table">
		<?php foreach ($elements as $element) : ?>
			<tr>
				<th><?php echo ModMoviesHelper::renderTranslatableHeader($params, $params->get('field')); ?></th>
				<td><?php echo ModMoviesHelper::renderElement(
						$params->get('table'), $params->get('field'), $element->{$params->get('field')}
					); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif;
