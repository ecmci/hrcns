<div class="form wide">
<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'requisition-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="">
		<?php echo $form->labelEx($model,'FACILITY_idFACILITY'); ?>
		<?php //echo $form->dropDownList($model, 'FACILITY_idFACILITY', GxHtml::listDataEx(Facility::model()->findAllAttributes(null, true)),array('empty'=>'-','required'=>'required')); ?>
		<?php $user = $user = User::model()->findByPk(Yii::app()->user->getState('id')); ?>
		<?php echo $form->dropDownList($model,'FACILITY_idFACILITY', CHtml::listData($user->myFacilities, 'idFACILITY', 'title'), array('empty'=>'-','required'=>'required')); ?>		
		<?php echo $form->error($model,'FACILITY_idFACILITY'); ?>
		
		</div><!-- row -->
		<div class="">
		<?php echo $form->labelEx($model,'PRIORITY_idPRIORITY'); ?>
		<?php //echo $form->dropDownList($model, 'PRIORITY_idPRIORITY', GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true)),array('empty'=>'-','required'=>'required')); ?>
		<?php echo $form->dropDownList($model, 'PRIORITY_idPRIORITY', CHtml::listData(Priority::model()->findAll(), 'idPRIORITY', 'concatpriority'),array('empty'=>'-','required'=>'required')); ?>
		<?php echo $form->error($model,'PRIORITY_idPRIORITY'); ?>
		</div><!-- row -->
		<div class="">
		<?php echo $form->labelEx($model,'priority_reason'); ?>
		<?php echo $form->textField($model, 'priority_reason', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'priority_reason'); ?>
		<p class="hint">If the request is high-priority, please provide a concise reason.</p>
		</div><!-- row -->
		<div class="">
		<?php //echo $form->labelEx($model,'title'); ?>
		<?php echo $form->hiddenField($model, 'title'); ?>
		<?php //echo $form->error($model,'title'); ?>
		</div><!-- row -->
		<div class="">
		<?php echo $form->labelEx($model,'preferred_vendor'); ?>
		<?php echo $form->textField($model, 'preferred_vendor', array('maxlength' => 100,'required'=>'required')); ?>
		<?php echo $form->error($model,'preferred_vendor'); ?>

		</div><!-- row -->
		<?php if(Yii::app()->user->getState('role')=='A'):  ?>
		<div class="">
		<?php echo $form->labelEx($model,'note_admin'); ?>
		<?php echo $form->textArea($model, 'note_admin', array('class'=>'textareas')); ?>
		<?php echo $form->error($model,'note_admin'); ?>
		</div><!-- row -->
		<?php endif; ?>
		
		<b>Items:</b>
		
		<?php include '_items.php';  ?>
		
		<?php include 'uploadifyWidget.php';  ?>
				
<div class="form-actions">
<?php echo GxHtml::submitButton(Yii::t('app', 'Save'),array('class'=>'btn btn-large btn-primary')); ?>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->