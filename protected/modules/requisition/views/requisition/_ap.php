<fieldset><legend><b>DECISION</b></legend>
	<fieldset><legend><b>AP Manila</b></legend>
		<?php if(($model->sTATUSIdSTATUS->acronym == "W") && ($this->checkUserAccess($model->sTATUSIdSTATUS->idSTATUS, Yii::app()->user->getState('group_id')))){ ?>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'req-sign-facility',
				'enableAjaxValidation'=>false,
				'action' => Yii::app()->createUrl("requisition/requisition/signapmnl"),
			)); ?>
				<?php echo $form->errorSummary($model); ?>
			
				<div class="">
				<?php echo GxHtml::activeLabelEx($model,'price_checked'); ?>
				<?php echo GxHtml::activeCheckBox($model, 'price_checked').""; ?>
				<?php echo GxHtml::error($model,'price_checked'); ?>
				</div><!-- row -->
				<div class="">
				<?php echo GxHtml::activeLabelEx($model,'note_apmnl'); ?>
				<?php echo GxHtml::activeTextArea($model, 'note_apmnl',array('id'=>'apmnlnote','class'=>'textareas')); ?>
				<?php echo '<br />'.CHtml::button('Save Note',array('class'=>'btn', 'onclick'=>"saveNote($model->idREQUISITION,'apmnl');")); ?>
				<?php echo GxHtml::error($model,'note_apmnl'); ?>
				</div><!-- row -->
				<div class="">
				<?php echo GxHtml::activeLabelEx($model,'po_num'); ?>				
				<?php echo GxHtml::activeTextField($model, 'po_num',array('style'=>'border:none;','disabled'=>'disabled','class'=>'autogen','value'=>(!isset($model->po_num)) ? $model->generatePONumber() : $model->po_num)); ?>
				<?php echo $form->hiddenField($model, 'po_num',array('value'=>(!isset($model->po_num)) ? $model->generatePONumber() : $model->po_num)); ?>
				<?php echo GxHtml::error($model,'po_num'); ?>				
				</div><!-- row -->

				<?php include 'uploadifyWidget.php'; ?>
				
				<input name='id' value='<?=Yii::app()->user->id?>' type='hidden' />
				<input name='rid' value='<?=$model->idREQUISITION?>' type='hidden' />		
				<?=$this->getStatusesForm(Yii::app()->user->id)?>
				<input  class="btn btn-large btn-primary"  type="submit" value="Sign" /> | <a href="<?=Yii::app()->getBaseUrl().''?>">Cancel</a>
			<?php $this->endWidget(); ?>
		<? }else{ ?>
			<table class="table table-bordered">
				<tr>
					<td><b>PO#:</b></td>
					<td><?=$model->po_num?></td>
				</tr>
				<tr>
					<td class="note" width="163"><b>Note:</b></td>
					<td class="note" colspan="3" style="font-size:18px;"><?=$model->note_apmnl?></td>			
				</tr>
				<tr>
					<td><b>Attachments:</b></td>
					<td><?=$model->getAttachmentAPMNL()?></td>
				</tr>
			</table>
		<?php } ?>
		<?php $name = ($model->uSERIdUSERSignApmnl==NULL) ? "[pending]" : $model->uSERIdUSERSignApmnl->f_name." ".$model->uSERIdUSERSignApmnl->l_name." (".$model->date_sign_apmnl.")"; ?>
		<div><b>AP MNL  Auth:</b> <span id="auth_facility"><u><?=$name?></u></span></div>
	</fieldset>
	
	<?php if(($model->sTATUSIdSTATUS->acronym == "WC" or $model->uSERIdUSERSignApcorp!=NULL)): ?>	
	<?php include '_apcorp.php'; ?>
	<?php endif; ?>	
</fieldset>