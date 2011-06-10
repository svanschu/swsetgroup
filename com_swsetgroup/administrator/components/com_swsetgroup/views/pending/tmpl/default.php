<?php
/**
 * @version $Id: $
 * SW SetGroup Component
 *
 * @package	SW SetGroup
 * @Copyright (C) 2011 Benjamin Berg & Sven Schultschik All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.schultschik.de
 */

defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<table class="adminlist">
	<thead>
		<tr>
            <th width="1%">
			    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
			</th>
            <th>
                <?php echo JText::_('COM_SWSETGROUP_USERNAME'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_SWSETGROUP_PENDING_SINCE'); ?>
            </th>
		</tr>
	</thead>
	<tbody>
    <?php foreach ($this->items as $i => $item) : ?>
		<tr class="row<?php echo $i % 2; ?>">
            <td class="center">
			    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
			</td>
            <td>
                <?php echo JHtml::_('link', 'index.php?option=com_users&task=user.edit&id='.$item->uid, $item->username); ?>
            </td>
            <td>
                <?php echo $item->time; ?>
            </td>
		</tr>
    <?php endforeach; ?>
	</tbody>
</table>

<input type="hidden" name="option" value="com_swsetgroup" />
<input type="hidden" name="id" value="" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
