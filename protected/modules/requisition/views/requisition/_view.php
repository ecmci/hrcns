<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('idREQUISITION')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->idREQUISITION), array('view', 'id' => $data->idREQUISITION)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('REQTYPE_idREQTYPE')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->rEQTYPEIdREQTYPE)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('FACILITY_idFACILITY')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->fACILITYIdFACILITY)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('PRIORITY_idPRIORITY')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->pRIORITYIdPRIORITY)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('priority_reason')); ?>:
	<?php echo GxHtml::encode($data->priority_reason); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('STATUS_idSTATUS')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->sTATUSIdSTATUS)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('title')); ?>:
	<?php echo GxHtml::encode($data->title); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('preferred_vendor')); ?>:
	<?php echo GxHtml::encode($data->preferred_vendor); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('project_name')); ?>:
	<?php echo GxHtml::encode($data->project_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('service_description')); ?>:
	<?php echo GxHtml::encode($data->service_description); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_req')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignReq)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_posted')); ?>:
	<?php echo GxHtml::encode($data->date_posted); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_fceo')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignFceo)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_fceo')); ?>:
	<?php echo GxHtml::encode($data->date_sign_fceo); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_fceo')); ?>:
	<?php echo GxHtml::encode($data->note_fceo); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_admin')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignAdmin)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_admin')); ?>:
	<?php echo GxHtml::encode($data->date_sign_admin); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_admin')); ?>:
	<?php echo GxHtml::encode($data->note_admin); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_apmnl')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignApmnl)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_apmnl')); ?>:
	<?php echo GxHtml::encode($data->date_sign_apmnl); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_apmnl')); ?>:
	<?php echo GxHtml::encode($data->note_apmnl); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_apcorp')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignApcorp)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_apcorp')); ?>:
	<?php echo GxHtml::encode($data->date_sign_apcorp); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_apcorp')); ?>:
	<?php echo GxHtml::encode($data->note_apcorp); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_apceo')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignApceo)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_apceo')); ?>:
	<?php echo GxHtml::encode($data->date_sign_apceo); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_apceo')); ?>:
	<?php echo GxHtml::encode($data->note_apceo); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_purch')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignPurch)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_purch')); ?>:
	<?php echo GxHtml::encode($data->date_sign_purch); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_purch')); ?>:
	<?php echo GxHtml::encode($data->note_purch); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_rcvr')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignRcvr)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_rcvr')); ?>:
	<?php echo GxHtml::encode($data->date_sign_rcvr); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_rcvr')); ?>:
	<?php echo GxHtml::encode($data->note_rcvr); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('USER_idUSER_sign_apinv')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->uSERIdUSERSignApinv)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('date_sign_apinv')); ?>:
	<?php echo GxHtml::encode($data->date_sign_apinv); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('note_apinv')); ?>:
	<?php echo GxHtml::encode($data->note_apinv); ?>
	<br />
	*/ ?>

</div>