<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
	<div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?>">
		<h1 class="componentheading">
		<?php
			JText::_('OS_PAYMENT_FAILURE');
		?>
		</h1>
	</div>
</div>
<div class="<?php echo $bootstrapHelper->getClassMapping('row-fluid'); ?>">
    <div class="<?php echo $bootstrapHelper->getClassMapping('span12'); ?> paddingtop10">
        <?php
        echo $reason;
        ?>
    </div>
</div>