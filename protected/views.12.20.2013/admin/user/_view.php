<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idUSER')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idUSER),array('view','id'=>$data->idUSER)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('f_name')); ?>:</b>
	<?php echo CHtml::encode($data->f_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('l_name')); ?>:</b>
	<?php echo CHtml::encode($data->l_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_name')); ?>:</b>
	<?php echo CHtml::encode($data->m_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GROUP_idGROUP')); ?>:</b>
	<?php echo CHtml::encode($data->GROUP_idGROUP); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('FACILITY_idFACILITY')); ?>:</b>
	<?php echo CHtml::encode($data->FACILITY_idFACILITY); ?>
	<br />

	*/ ?>

</div>