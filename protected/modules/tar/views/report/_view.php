<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('case_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->case_id),array('view','id'=>$data->case_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('control_num')); ?>:</b>
	<?php echo CHtml::encode($data->control_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resident')); ?>:</b>
	<?php echo CHtml::encode($data->resident); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('medical_num')); ?>:</b>
	<?php echo CHtml::encode($data->medical_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dx_code')); ?>:</b>
	<?php echo CHtml::encode($data->dx_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admit_date')); ?>:</b>
	<?php echo CHtml::encode($data->admit_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_dos_date_from')); ?>:</b>
	<?php echo CHtml::encode($data->requested_dos_date_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requested_dos_date_thru')); ?>:</b>
	<?php echo CHtml::encode($data->requested_dos_date_thru); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('applied_date')); ?>:</b>
	<?php echo CHtml::encode($data->applied_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('denied_deferred_date')); ?>:</b>
	<?php echo CHtml::encode($data->denied_deferred_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->approved_modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backbill_date')); ?>:</b>
	<?php echo CHtml::encode($data->backbill_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aging_amount')); ?>:</b>
	<?php echo CHtml::encode($data->aging_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_closed')); ?>:</b>
	<?php echo CHtml::encode($data->is_closed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason_for_closing')); ?>:</b>
	<?php echo CHtml::encode($data->reason_for_closing); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->created_timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_care_id')); ?>:</b>
	<?php echo CHtml::encode($data->approved_care_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->created_by_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facility_id')); ?>:</b>
	<?php echo CHtml::encode($data->facility_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resident_status')); ?>:</b>
	<?php echo CHtml::encode($data->resident_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('condition')); ?>:</b>
	<?php echo CHtml::encode($data->condition); ?>
	<br />

	*/ ?>

</div>