<fieldset>
	<legend><b>FACILITY AUTHORIZATION</b></legend>	
	<?php if($model->sTATUSIdSTATUS->acronym == "N" && $this->checkUserAccess($model->sTATUSIdSTATUS->idSTATUS, Yii::app()->user->getState('group_id'))){ ?>
		<?php include '_facility_form.php'; ?>
	<?php }else{ ?>
		<table class="table table-bordered">
			<tr>
				<td class="note" width="163"><b>Note:</b></td>
				<td class="note" colspan="3" style="font-size:18px;"><?=$model->note_admin?></td>			
			</tr>
			<tr>
				<td>Attachments:</td>
				<td><?=$model->getAttachmentFacAdmin()?></td>
			</tr>
		</table>
	<?php } ?>
	<?php
		$name = ($model->uSERIdUSERSignAdmin==NULL) ? "[pending]" : $model->uSERIdUSERSignAdmin->f_name." ".$model->uSERIdUSERSignAdmin->l_name." (".$model->date_sign_admin.")";
	?>
	<div><b>Facility Auth:</b> <span id="auth_facility"><u><?=$name?></u></span></div>
</fieldset>
