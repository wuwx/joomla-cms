<?php
/**
 * @version		$Id$
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License <http://www.gnu.org/copyleft/gpl.html>
 */

// no direct access
defined('_JEXEC') or die;

// TODO: Optimise some of the fixed params in the loops
?>
<script language="javascript" type="text/javascript">
	function tableOrdering(order, dir, task) {
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit(task);
}
</script>

<form action="<?php echo JFilterOutput::ampReplace(JFactory::getURI()->toString()); ?>" method="post" name="adminForm">

	<table class="jlist">
		<thead>
			<tr>
				<td align="right" colspan="4">
					<?php echo JText::_('Display Num'); ?>
					<?php echo $this->pagination->getLimitBox(); ?>
				</td>
			</tr>
			<?php if ($this->params->def('show_headings', 1)) : ?>
			<tr>
				<th width="10">
					<?php echo JText::_('Num'); ?>
				</th>
				<th width="90%">
					<?php echo JHtml::_('grid.sort',  'Web Link', 'title', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
				<?php if ($this->params->get('show_link_hits')) : ?>
				<th width="30">
					<?php echo JHtml::_('grid.sort',  'Hits', 'hits', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
				</th>
				<?php endif; ?>
			</tr>
			<?php endif; ?>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="4" class="sectiontablefooter<?php echo $this->params->get('pageclass_sfx'); ?>">
				<?php echo $this->pagination->getPagesLinks(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($this->items as $i => $item) : ?>
			<tr class="<?php echo $i % 2 ? 'odd' : 'even';?>">
				<td>
					<?php echo $this->pagination->getRowOffset($i); ?>
				</td>
				<td>
					<?php if ($this->params->get('link_icons') <> -1) : ?>
						<?php echo JHtml::_('image.site',  $this->params->get('link_icons', 'weblink.png'), '/images/M_images/', $this->params->get('weblink_icons'), '/images/M_images/', 'Link');?>
					<?php endif; ?>

					<?php
						// Compute the correct link

						$menuclass = 'category'.$this->params->get('pageclass_sfx');
						$link	= JRoute::_('index.php?view=weblink&catid='.$this->category->slug.'&id='. $item->slug);
						switch ($item->params->get('target', $this->params->get('target')))
						{
							// cases are slightly different
							case 1:
								// open in a new window
								echo '<a href="'. $link .'" target="_blank" class="'. $menuclass .'">'. $this->escape($item->title) .'</a>';
								break;

							case 2:
								// open in a popup window
								echo "<a href=\"#\" onclick=\"javascript: window.open('". $link ."', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"$menuclass\">". $this->escape($item->title) ."</a>\n";
								break;

							default:
								// open in parent window
								echo '<a href="'. $link .'" class="'. $menuclass .'">'. $this->escape($item->title) .'</a>';
								break;
						}
					?>
					<?php if ($this->params->get('show_link_description')) : ?>
					<p>
						<?php echo nl2br($item->description); ?>
					</p>
					<?php endif; ?>
				</td>
				<?php if ($this->params->get('show_link_hits')) : ?>
				<td>
					<?php echo $item->hits; ?>
				</td>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		<tbody>
	</table>

	<input type="hidden" name="filter_order" value="<?php echo $this->state->get('list.ordering'); ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->state->get('list.direction'); ?>" />
</form>
