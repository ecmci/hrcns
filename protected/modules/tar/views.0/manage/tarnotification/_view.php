<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data')); ?>:</b>
	<?php echo CHtml::encode($data->data); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_case_id')); ?>:</b>
	<?php echo CHtml::encode($data->log_case_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alerts_tpl_id')); ?>:</b>
	<?php echo CHtml::encode($data->alerts_tpl_id); ?>
	<br />


</div>