<fieldset><legend>Personal</legend>

<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model,'middle_name',array('class'=>'span5','maxlength'=>128)); ?>
                                                                                            
<?php echo $form->fileFieldRow($model,'photo',array('class'=>'span5','readonly'=>'readonly')); ?>

</fieldset>  