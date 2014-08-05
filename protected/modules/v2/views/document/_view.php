<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emp_id')); ?>:</b>
	<?php echo CHtml::encode($data->emp_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('submitted_by')); ?>:</b>
	<?php echo CHtml::encode($data->submitted_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serial_number')); ?>:</b>
	<?php echo CHtml::encode($data->serial_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_issued')); ?>:</b>
	<?php echo CHtml::encode($data->date_issued); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_expiration')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_expiration); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('attachment')); ?>:</b>
	<?php echo CHtml::encode($data->attachment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	*/ ?>

</div>