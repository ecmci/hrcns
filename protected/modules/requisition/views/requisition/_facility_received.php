<fieldset><legend><b>RECEIVED</b></legend>
	<?php if(($model->sTATUSIdSTATUS->acronym == "P") && ($this->checkUserAccess($model->sTATUSIdSTATUS->idSTATUS, Yii::app()->user->getState('group_id')))){ ?>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'req-sign-facility',
			'enableAjaxValidation'=>false,
			'action' => Yii::app()->createUrl("requisition/requisition/signrcvr"),
		)); ?>
		
		<?php echo $form->errorSummary($model); ?>
		
		<?php if($model->REQTYPE_idREQTYPE == '2')://hardcoded id from table reqtype ?>
		<div class="">				
		<?php echo $form->checkBox($model, 'has_agreed_tos')."<b> I am satisfied with the service.</b>"; ?>
		<?php echo $form->error($model,'has_agreed_tos'); ?>	
		</div><!-- row -->
		<?php endif; ?>
		
		<div class="">
		<?php echo $form->labelEx($model,'note_rcvr'); ?>
		<?php echo $form->textArea($model, 'note_rcvr',array('class'=>'textareas')); ?>
		<?php echo $form->error($model,'note_rcvr'); ?>
		</div><!-- row -->

		<input name='id' value='<?=Yii::app()->user->id?>' type='hidden' />
		<input name='rid' value='<?=$model->idREQUISITION?>' type='hidden' />		
		<?=$this->getStatusesForm(Yii::app()->user->id)?>
		<input  class="btn btn-primary btn-large"  type="submit" value="Sign" /> | <a href="<?=Yii::app()->getBaseUrl().''?>">Cancel</a>

		<?php $this->endWidget(); ?>
	<?php }else{ ?>
		<table  class="table table-bordered">
			<?php if($model->REQTYPE_idREQTYPE=='2'){//hardcoded id from table reqtype ?>
			<tr>
				<td><b>Satisfied:</b></td>
				<td><?=($model->has_agreed_tos=='1')?'Yes':'No'?></td>
			</tr>
			<?php } ?>
			<tr>
				<td class="note" width="163"><b>Note:</b></td>
				<td class="note" colspan="3" style="font-size:18px;"><?=$model->note_rcvr?></td>			
			</tr>
		</table>	
	<?php } ?>
	<?php $name = ($model->uSERIdUSERSignRcvr==NULL) ? "[pending]" : $model->uSERIdUSERSignRcvr->f_name." ".$model->uSERIdUSERSignRcvr->l_name." (".$model->date_sign_rcvr.")"; ?>
	<div><b>Received By:</b> <span id="auth_facility"><u><?=$name?></u></span></div>
</fieldset>