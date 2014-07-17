<fieldset><legend><b>AP Corporate</b></legend>
	<?php if(($model->sTATUSIdSTATUS->acronym == "WC") && ($this->checkUserAccess($model->sTATUSIdSTATUS->idSTATUS, Yii::app()->user->getState('group_id')))){ ?>
		<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'req-sign-facility',
				'enableAjaxValidation'=>false,
				'action' => Yii::app()->createUrl("requisition/requisition/signapcorp"),
			)); ?>
			
			<?php echo $form->errorSummary($model); ?>
			
			<div class="">
			<?php echo GxHtml::activeLabelEx($model,'note_apcorp'); ?>
			<?php echo GxHtml::activeTextArea($model, 'note_apcorp',array('id'=>'apcorpnote','class'=>'textareas')); ?>
			<?php echo '<br />'.CHtml::button('Save Note',array('class'=>'btn', 'onclick'=>"saveNote($model->idREQUISITION,'apcorp');")); ?>			
			<?php echo GxHtml::error($model,'note_apcorp'); ?>
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
				<td class="note" width="163"><b>Note:</b></td>
				<td class="note" colspan="3" style="font-size:18px;"><?=$model->note_apcorp?></td>			
			</tr>
			<tr>
				<td><b>Attachments:</b></td>
				<td><?=$model->getAttachmentAPCORP()?></td>
			</tr>
		</table>
	<?php } ?>
	<?php $name = ($model->uSERIdUSERSignApcorp==NULL) ? "[pending]" : $model->uSERIdUSERSignApcorp->f_name." ".$model->uSERIdUSERSignApcorp->l_name." (".$model->date_sign_apcorp.")"; ?>
	<div><b>AP Corporate  Auth:</b> <span id="auth_facility"><u><?=$name?></u></span></div>
</fieldset>