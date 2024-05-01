<?php
/*------------------------------------------------------------------------
# reportfailure.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2023 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// No direct access.
defined('_JEXEC') or die;
?>
<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
	<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
		<h2>
			<?php echo JText::_('OS_REPORT_FAILURE');?>
		</h2>
	</div>
	<div class="clearfix"></div>
	<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>" style="margin-left:0px;">
		<?php
			echo JText::_('OS_REPORT_FAILURE_MOREDETAILS');
		?>
	</div>
</div>