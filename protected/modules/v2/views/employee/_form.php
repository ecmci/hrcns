	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'middle_name',array('class'=>'span5','maxlength'=>128)); ?>

	<div class="control-group">
		<?php echo CHtml::activeLabelEx($model,'photo',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeFileField($model,'photo',array('class'=>'span5','maxlength'=>128)); ?>
		</div>
	</div>



