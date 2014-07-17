<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'req-sign-facility',
	'enableAjaxValidation'=>false,
	'action' => Yii::app()->baseURL."/index.php/requisition/requisition/signfacility",
)); ?>

	<div class="">
		<?php $admin = (!isset($model)) ? new Requisition : $model; ?>			
		<?php echo $form->errorSummary($admin); ?>
		<?php echo $form->labelEx($admin,'note_admin'); ?>			
		<?php echo $form->textArea($admin,'note_admin',array('id'=>'facilitynote','class'=>'textareas')); ?>
		<?php echo '<br />'.CHtml::button('Save Note',array('onclick'=>"saveNote($model->idREQUISITION,'facility');",'class'=>'btn btn-small')); ?>			
		<?php echo $form->error($admin,'note_admin'); ?>	
		<p class="hint" style="color:red;">*required</p>	
			
	</div>

	<div class="">
		<?php include 'uploadifyWidget.php' ?>
	</div>

	<input name='id' value='<?=Yii::app()->user->id?>' type='hidden' />
	<input name='rid' value='<?=$model->idREQUISITION?>' type='hidden' />
	<?=$this->getStatusesForm(Yii::app()->user->id)?>
	<input class="btn btn-primary btn-large" type="submit" value="Sign" /> | <a href="<?=Yii::app()->getBaseUrl().''?>">Cancel</a>


<?php $this->endWidget(); ?>