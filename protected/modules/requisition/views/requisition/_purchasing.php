<style>
	/*#items td{border:1px solid black;}*/
</style>
<fieldset><legend><b>PURCHASE ORDER</b></legend>
	<?php if(($model->sTATUSIdSTATUS->acronym == "A" or $model->sTATUSIdSTATUS->acronym == "AE") && ($this->checkUserAccess($model->sTATUSIdSTATUS->idSTATUS, Yii::app()->user->getState('group_id')))){ ?>
		<?php include "_purchasing_form.php"; ?>
	<? }else{ ?>
		<table id="items"  class="table table-bordered">
			<tr>
				<td><b>Confirmation#:</b></td>
				<td colspan="3"><?=$model->confirmation_number?></td>
			</tr>
			<?php if($model->REQTYPE_idREQTYPE=='1'): ?>
			<tr>
				<td class="note" width="163"><b>Date Ordered:</b></td>
				<td><?=$model->order_date?></td>
				<td class="note" width="163"><b>Estimated Delivery Date:</b></td>
				<td><?=$model->estimated_delivery_date?></td>
			</tr>
			<?php endif; ?>
			<?php if($model->REQTYPE_idREQTYPE=='2'): ?>
			<tr>
				<td class="note" width="163"><b>Completion Date:</b></td>
				<td colspan="3"><?=$model->completion_date?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="note" width="163"><b>Note:</b></td>
				<td width="163" colspan="3" class="note" style="font-size:18px;"><?=$model->note_purch?></td>				
			</tr>
			<tr>				
				<td colspan="4">
				<?php if($model->REQTYPE_idREQTYPE=='1'): ?>
				<?php 
					$cols = array('Item#','Purchased','Substituted','Price','Vendor');
					$this->widget('ext.htmltableui.htmlTableUi',array(
					'collapsed'=>false,
					'enableSort'=>true,
					'title'=>'Purchased Items',
					'columns'=>$cols,
					//'footer'=>$model->getItemsTotal($model->idREQUISITION),
					'rows'=>$model->getPurchasedItems(),	
				)); ?>
				<?php endif; ?>
				
				<?php if($model->REQTYPE_idREQTYPE=='2'): ?>
				<?php 
					$cols = array('Vendor','Qouted Amount','Approved');
					$this->widget('ext.htmltableui.htmlTableUi',array(
					'collapsed'=>false,
					'enableSort'=>true,
					'title'=>'Approved Vendor',
					'columns'=>$cols,
					'rows'=>$model->getApprovedVendors(),	
				)); ?>
				<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td width="163"><b>Attachments:</b></td>
				<td colspan="3"><?=$model->getAttachmentPurchasing()?></td>
			</tr>
		</table>
	<? } ?>
	<?php $name = ($model->uSERIdUSERSignPurch==NULL) ? "[pending]" : $model->uSERIdUSERSignPurch->f_name." ".$model->uSERIdUSERSignPurch->l_name." (".$model->date_sign_purch.")"; ?>
	<div><b>Purchased  By:</b> <span id="auth_facility"><u><?=$name?></u></span></div>
</fieldset>