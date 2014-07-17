<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('workflow_notice_status')); ?>:</b>
	<?php echo CHtml::encode($data->workflow_notice_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipient_email')); ?>:</b>
	<?php echo CHtml::encode($data->recipient_email); ?>
	<br />


</div>