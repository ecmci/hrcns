<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idFACILITY')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idFACILITY),array('view','id'=>$data->idFACILITY)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acronym')); ?>:</b>
	<?php echo CHtml::encode($data->acronym); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />


</div>