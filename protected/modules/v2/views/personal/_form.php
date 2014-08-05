	<?php echo $form->textFieldRow($model,'birthdate',array('class'=>'span5 datepicker')); ?>

	<?php echo $form->radioButtonListRow($model, 'gender', array(
        'Male'=>'Male',
        'Female'=>'Female',
    )); ?>

	<?php echo $form->hiddenField($model,'marital_status',array('class'=>'span5','maxlength'=>16)); ?>

	<?php echo $form->textFieldRow($model,'SSN',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'street',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'city',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'state',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'zip_code',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'telephone',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'cellphone',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>
