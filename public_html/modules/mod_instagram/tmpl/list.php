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
$elements = ModInstagramHelper::getList($params);
?>

<?php if (!empty($elements)) : ?>
	<table class="table">
		<?php foreach ($elements as $element) : ?>
			<tr>
				<th><?php echo ModInstagramHelper::renderTranslatableHeader($params, $params->get('field')); ?></th>
				<td><?php echo ModInstagramHelper::renderElement(
						$params->get('table'), $params->get('field'), $element->{$params->get('field')}
					); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif;
