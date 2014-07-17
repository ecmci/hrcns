<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emp_id')); ?>:</b>
	<?php echo CHtml::encode($data->emp_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_pto_eligible')); ?>:</b>
	<?php echo CHtml::encode($data->is_pto_eligible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pto_effective_date')); ?>:</b>
	<?php echo CHtml::encode($data->pto_effective_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fed_expt')); ?>:</b>
	<?php echo CHtml::encode($data->fed_expt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fed_add')); ?>:</b>
	<?php echo CHtml::encode($data->fed_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state_expt')); ?>:</b>
	<?php echo CHtml::encode($data->state_expt); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rate_type')); ?>:</b>
	<?php echo CHtml::encode($data->rate_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate_proposed')); ?>:</b>
	<?php echo CHtml::encode($data->rate_proposed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate_recommended')); ?>:</b>
	<?php echo CHtml::encode($data->rate_recommended); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate_approved')); ?>:</b>
	<?php echo CHtml::encode($data->rate_approved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate_effective_date')); ?>:</b>
	<?php echo CHtml::encode($data->rate_effective_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deduc_health_code')); ?>:</b>
	<?php echo CHtml::encode($data->deduc_health_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deduc_health_amt')); ?>:</b>
	<?php echo CHtml::encode($data->deduc_health_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deduc_dental_code')); ?>:</b>
	<?php echo CHtml::encode($data->deduc_dental_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deduc_dental_amt')); ?>:</b>
	<?php echo CHtml::encode($data->deduc_dental_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deduc_other_code')); ?>:</b>
	<?php echo CHtml::encode($data->deduc_other_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deduc_other_amt')); ?>:</b>
	<?php echo CHtml::encode($data->deduc_other_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_approved')); ?>:</b>
	<?php echo CHtml::encode($data->is_approved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	*/ ?>

</div>