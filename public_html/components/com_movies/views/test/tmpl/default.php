<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Movies
 * @author     William del Rosario <williamdelrosario@yahoo.com>
 * @copyright  2018 William del Rosario
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_movies.' . $this->item->id);

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_movies' . $this->item->id))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

	</table>

</div>

