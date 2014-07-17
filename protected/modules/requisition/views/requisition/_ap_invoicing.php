<fieldset><legend><b>BILLING</b></legend>
	<?php if(($model->sTATUSIdSTATUS->acronym == "R") && ($this->checkUserAccess($model->sTATUSIdSTATUS->idSTATUS, Yii::app()->user->getState('group_id')))){ ?>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'req-sign-facility',
			'enableAjaxValidation'=>false,
			'action' => Yii::app()->createUrl("requisition/requisition/signinv"),
		)); ?>
		
		<?php echo $form->errorSummary($model); ?>
		
		<div class="">
		<?php echo $form->labelEx($model,'is_billed'); ?>
		<?php echo $form->checkBox($model, 'is_billed')." "; ?>
		<?php echo $form->error($model,'is_billed'); ?>
		</div><!-- row -->

		<?php if($model->REQTYPE_idREQTYPE=='1'): ?>
		<div class="">		
		<?php echo $form->labelEx($model,'invoice_number'); ?>
		<?php echo $form->textField($model, 'invoice_number'); ?>
		<?php echo $form->error($model,'invoice_number'); ?>
		</div><!-- row -->
		<?php endif; ?>
		
		<div class="">		
		<?php echo $form->labelEx($model,'note_apinv'); ?>
		<?php echo $form->textArea($model, 'note_apinv',array('class'=>'textareas')); ?>
		<?php echo $form->error($model,'note_apinv'); ?>
		</div><!-- row -->

		<?php include 'uploadifyWidget.php'; ?>

		<input name='id' value='<?=Yii::app()->user->id?>' type='hidden' />
		<input name='rid' value='<?=$model->idREQUISITION?>' type='hidden' />		
		<?=$this->getStatusesForm(Yii::app()->user->id)?>
		<input  class="btn btn-primary btn-large"  type="submit" value="Sign" /> | <a href="<?=Yii::app()->getBaseUrl().''?>">Cancel</a>

		<?php $this->endWidget(); ?>
	<?php }else{ ?>
		<table  class="table table-bordered">
		  <tr>
				<td class="note" width="163"><b>Billed:</b></td>
				<td><?=($model->is_billed=='1')?'Yes':'No'?></td>		
				<td class="note" width="163"><b>Invoice #:</b></td>
				<td><?=$model->invoice_number?></td>
			</tr>
      <tr>
				<td class="note" width="163"><b>Note:</b></td>
				<td class="note" colspan="3" style="font-size:18px;"><?=$model->note_apinv?></td>			
			</tr>
      <tr>
				<td class="note" width="163"><b>Attachments:</b></td>
				<td colspan="3"><?=$model->getAttachmentInv()?></td>
			</tr>	
		</table>	
	<?php } ?>
	<?php $name = ($model->uSERIdUSERSignApinv==NULL) ? "[pending]" : $model->uSERIdUSERSignApinv->f_name." ".$model->uSERIdUSERSignApinv->l_name." (".$model->date_sign_apinv.")"; ?>
	<div><b>Billed By:</b> <span id="auth_facility"><u><?=$name?></u></span></div>
</fieldset>