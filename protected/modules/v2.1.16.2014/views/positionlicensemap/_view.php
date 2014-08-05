<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position_code')); ?>:</b>
	<?php echo CHtml::encode($data->position_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('license_name')); ?>:</b>
	<?php echo CHtml::encode($data->license_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_expiration')); ?>:</b>
	<?php echo CHtml::encode($data->default_expiration); ?>
	<br />


</div>