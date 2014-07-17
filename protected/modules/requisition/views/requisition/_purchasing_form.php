<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'req-order-order-form',
	'enableAjaxValidation'=>false,
	'action' => Yii::app()->createUrl("requisition/requisition/signpurch"),
)); ?>

	
	<input value="<?=$model->idREQUISITION?>" name="rid" type="hidden" />
	<input name='id' value='<?=Yii::app()->user->id?>' type='hidden' />

	<?php echo $form->errorSummary($model); ?>

	<div class="">		
		<?php 
			if($model->REQTYPE_idREQTYPE=='1'){
				include '_items_purchasing_form.php'; 				
			}elseif($model->REQTYPE_idREQTYPE=='2'){
				include '_vendors_purchasing_form.php'; 
			}
		?>
	</div>
	
	<div class="">
		<?php
			$po_num = ($model->po_num != NULL) ? $model->po_num : $model->generatePONumber();			
		?>
		<?php echo $form->labelEx($model,'confirmation_number'); ?>
		<?php //echo $form->hiddenField($model,'confirmation_number',array('value'=>$po_num)); ?>
		<?php echo $form->textField($model,'confirmation_number',array('required'=>'required')); ?>
		<?php echo $form->error($model,'confirmation_number'); ?>
	</div>
	
	<?php if($model->REQTYPE_idREQTYPE == '1')://hardcoded id from table reqtype ?>
	<div class="">
		<?php echo $form->labelEx($model,'order_date'); ?>
		<?php echo $form->error($model,'date_order'); ?>
		<?php  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Requisition[order_date]',
			'value'=>$model->order_date,
			// additional javascript options for the date picker plugin
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;',
				'required'=>'required',
			),
		));
		?>
		<?php echo $form->error($model,'order_date'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'estimated_delivery_date'); ?>
		<?php //echo $form->textField($model,'date_ship'); ?>
		<?php  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Requisition[estimated_delivery_date]',		
			'value'=>$model->estimated_delivery_date,			
			// additional javascript options for the date picker plugin
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;',
				'required'=>'required',
			),
		));  ?>
		<?php echo $form->error($model,'estimated_delivery_date'); ?>
	</div>
	<?php endif;?>
	
	<?php if($model->REQTYPE_idREQTYPE == '2')://hardcoded id from table reqtype ?>
	<div class="">
		<?php echo $form->labelEx($model,'completion_date'); ?>
		<?php  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Requisition[completion_date]',
			'value'=>$model->completion_date,
			// additional javascript options for the date picker plugin
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;',
				//'required'=>'required',
			),
		));
		?>
		<?php echo $form->error($model,'completion_date'); ?>
	</div>
	<?php endif;?>
	
	<div class="">
		<?php echo $form->labelEx($model,'note_purch'); ?>
		<?php echo $form->textArea($model,'note_purch',array('class'=>'textareas')); ?>
		<?php echo $form->error($model,'note_purch'); ?>
	</div>

	<div class="">
		<?php include 'uploadifyWidget.php'; ?>
	</div>

	<div class="">
		<?php echo "Status:".$this->getStatusesForm(Yii::app()->user->getState('id'))?>
		<?php echo CHtml::submitButton('Sign',array('class'=>'btn btn-primary btn-large')); ?>
	</div>

<?php $this->endWidget(); ?>
