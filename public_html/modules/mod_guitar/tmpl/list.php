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
$elements = ModGuitarHelper::getList($params);
?>

<?php if (!empty($elements)) : ?>
	<table class="table">
		<?php foreach ($elements as $element) : ?>
			<tr>
				<th><?php echo ModGuitarHelper::renderTranslatableHeader($params, $params->get('field')); ?></th>
				<td><?php echo ModGuitarHelper::renderElement(
						$params->get('table'), $params->get('field'), $element->{$params->get('field')}
					); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif;
