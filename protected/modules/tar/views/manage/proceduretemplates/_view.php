<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_struct')); ?>:</b>
	<?php echo CHtml::encode($data->data_struct); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_steps')); ?>:</b>
	<?php echo CHtml::encode($data->total_steps); ?>
	<br />


</div>