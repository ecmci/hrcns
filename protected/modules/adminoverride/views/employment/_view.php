<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emp_id')); ?>:</b>
	<?php echo CHtml::encode($data->emp_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facility_id')); ?>:</b>
	<?php echo CHtml::encode($data->facility_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_hire')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_hire); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_termination')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_termination); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_code')); ?>:</b>
	<?php echo CHtml::encode($data->department_code); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('position_code')); ?>:</b>
	<?php echo CHtml::encode($data->position_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contract_file')); ?>:</b>
	<?php echo CHtml::encode($data->contract_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('has_union')); ?>:</b>
	<?php echo CHtml::encode($data->has_union); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reports_to')); ?>:</b>
	<?php echo CHtml::encode($data->reports_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_approved')); ?>:</b>
	<?php echo CHtml::encode($data->is_approved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	*/ ?>

</div>