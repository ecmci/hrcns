<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
  array('label'=>Yii::t('app', 'Cancel') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('href'=>'#','id'=>'cancel-request')),
	array('label'=>Yii::t('app', 'Print'), 'url'=>array('requisition/getpdf/id/'.$model->idREQUISITION),'linkOptions'=>array('target'=>'_blank','href'=>'#')),
	array('label'=>Yii::t('app', 'Back'), 'url'=>array('admin')),
);
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScript('rview',"
$(document).ready(function(){
  $.curCSS = function (element, attrib, val) {
      $(element).css(attrib, val);
  };
  var url = $('#urlcancel').val();
  var hash=$('#hash').val();
	if(hash.length > 0)location.hash = '#'+hash;
  $('#cancel-request').click(function(){		
		$( '#dialog-form-cancel' ).dialog( 'open' );
	});
  $( '#dialog-form-cancel' ).dialog({
		autoOpen: false,
		height: 210,
		width: 450,
		modal: false,
		hide: 'explode',
	});
  $( '#dialog-info' ).dialog({
		autoOpen: false,
		height: 150,
		width: 300,
		modal: true,
		hide: 'explode',
	});
});
",CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScript('dialog-actions',"
$('#btn-cancel-confirm').click(function(){
  var url = $('#urlcancel').val();
  var params = 'reason=' + $('#reason').val() + '&uid=' +  $('#userid').val();
  $.post(url,params,function(data){
  if(data=='1'){		
  	$( this ).dialog( 'close' );
  	location.reload();
  }else{			
  	$('#dialog-info').html('<p>'+data+'</p>');	
  	$('#dialog-info').dialog('open');									
  }
  });	
});
$('#btn-cancel-cancel').click(function(){
  $( '#dialog-form-cancel' ).dialog( 'close' );
});
$('#btn-info-ok').click(function(){
  $( '#dialog-info' ).dialog( 'close' );  
});
");

Yii::app()->clientScript->registerCss('style',"
textarea {
width:99%;
min-height: 150px;
}
textarea#reason{
min-height: 75px;
}
");

?>

<input id="urlcancel" value="<?=Yii::app()->createUrl('requisition/requisition/cancelrequest/id/'.$model->idREQUISITION); ?>" type="hidden"/>
<input id="userid" value="<?=Yii::app()->user->id?>" type="hidden"/>
<?php $hash = (isset($hash)) ? $hash : ''; ?>
<input value="<?php echo $hash?>" id="hash" type="hidden" />

<?php include '_save_note_script.php'; ?>
<div id="dialog-info" title="Information">
	<p></p>
  <button class="btn" id="btn-info-ok">Cancel</button>
</div>
<div id="dialog-form-cancel" title="State Your Reason">			
	<label for="password">Reason:</label>
	<textarea name="reason" id="reason" cols="55" rows="3" class="text ui-widget-content ui-corner-all"></textarea>
  <button class="btn btn-danger" id="btn-cancel-confirm">Confirm</button>
  <button class="btn" id="btn-cancel-cancel">Cancel</button>
</div>
<span id="top"></span>
<?php
$request = ($model->REQTYPE_idREQTYPE == '1') ? 'Purchase' :  'Service';
$urgency = ($model->PRIORITY_idPRIORITY== '1') ? "<span style='color:red;'> - Urgent</span>" : " - Not Urgent";//hardcoded from priority
?>
<h1 class="page-header"><?php echo Yii::t('app', '') . ' ' . $request.' Request - '.$model->idREQUISITION.$urgency; ?></h1>

<div class="row-fluid">
  <div class="span12">
  <?php $this->widget('bootstrap.widgets.TbDetailView', array(
  	'data' => $model,
  	'attributes' => array(
      'title',
      'date_posted',
      array(
      			'name' => 'fACILITYIdFACILITY',
      			'value' => $model->fACILITYIdFACILITY->title,
      			),
      array(
      			'name' => 'uSERIdUSERSignReq',
      			'type' => 'raw',
      			'value' => $model->uSERIdUSERSignReq->getFullName(),
      			),
      'preferred_vendor',
      array(
      			'name' => 'pRIORITYIdPRIORITY',
      			'value' => $model->pRIORITYIdPRIORITY->title,
      			),
      'priority_reason',
      array(
      			'name' => 'sTATUSIdSTATUS',
      			'type' => 'raw',
      			'value' => $model->sTATUSIdSTATUS->title,
      			),
      array(
      	'name' => 'cancel_reason',
      	'value' => $model->cancel_reason,
      	'visible'=>$model->STATUS_idSTATUS=='8',//hardcoded id from table status
      ),
      array(
      	'name' => 'USER_idUSER_cancel',
      	'value' => ($model->uSERIdUSERCancel!=NULL)?$model->uSERIdUSERCancel->getFullName():"",
      	'visible'=>$model->STATUS_idSTATUS=='8',//hardcoded id from table status
      ),
      array(
      	'name' => 'datetime_cancel',
      	'value' => $model->datetime_cancel,
      	'visible'=>$model->STATUS_idSTATUS=='8',//hardcoded id from table status
      ),
      //'project_name',
      //'service_description',
      array(
      	'name' => 'project_name',
      	'value' => $model->project_name,
      	'visible'=>$model->REQTYPE_idREQTYPE=='2',//hardcoded id from table status
      ),
      array(
      	'name' => 'service_description',
      	'value' => $model->service_description,
      	'visible'=>$model->REQTYPE_idREQTYPE=='2',//hardcoded id from table status
      ),
      array(
      	'label'=>'Attachments',
      	'type'=>'raw',
      	'value'=>$model->getMyAttachmentlinks(),
      ),
  	),
  )); ?>
  </div>
</div>

<?php if($model->REQTYPE_idREQTYPE=='1'){ ?>
<div class="row-fluid">
  <div class="span12">
  <?php  $cols = array('Item#','Qty.','Unit','Item Name','Specification','Unit Cost','Reason','Total');
       $this->widget('requisition.extensions.htmltableui.htmlTableUi',array(
      'collapsed'=>false,
      'enableSort'=>true,
      'title'=>'Requested Items',
      'columns'=>$cols,
      'rows'=>$model->getMyPurchaseItems($model->idREQUISITION),	
      ));  
  ?>
  </div>
</div>
<div class="row-fluid">
      <div class="span12">
        <h4 style="text-align:center;">Total Amount: <b><?=number_format($model->getItemsTotal($model->idREQUISITION), 2, '.', ',')?></b></h4>
      </div>
</div>
<?php } ?>

<?php if($model->REQTYPE_idREQTYPE=='2'){ //hardcoded request type from reqtype table ?>
<div class="row-fluid">
  <div class="span12">
    <?php 
    $cols = array('Vendor','Qouted Amount');
    $this->widget('requisition.extensions.htmltableui.htmlTableUi',array(
    'collapsed'=>false,
    'enableSort'=>true,
    'title'=>'Proposed Vendors',
    'columns'=>$cols,
    'rows'=>$model->getMyVendors(),	
    )); 
  ?>
  </div>
</div>
<?php } ?>

<div class="row-fluid"><div class="span12 pull-right"><p class="text-right" id="anchor"><small>Jump to: <a href="#facility">Facility</a> | <a href="#ap">Decision</a> | <a href="#purchasing">Purchasing</a> | <a href="#received">Receiving</a> | <a href="#billing">Billing</a> | <a href="#top">Top</a></small></p></div></div>

<div class="row-fluid">
  <div class="span12">
  <span id="facility"></span>
  <?php include '_facility.php'; ?>
  </div>
</div>

<div class="row-fluid"><div class="span12 pull-right"><p class="text-right" id="anchor"><small>Jump to: <a href="#facility">Facility</a> | <a href="#ap">Decision</a> | <a href="#purchasing">Purchasing</a> | <a href="#received">Receiving</a> | <a href="#billing">Billing</a> | <a href="#top">Top</a></small></p></div></div>

<div class="row-fluid">
  <div class="span12">
  <span id="ap"></span>
  <?php include '_ap.php'; ?>
  </div>
</div>

<div class="row-fluid"><div class="span12 pull-right"><p class="text-right" id="anchor"><small>Jump to: <a href="#facility">Facility</a> | <a href="#ap">Decision</a> | <a href="#purchasing">Purchasing</a> | <a href="#received">Receiving</a> | <a href="#billing">Billing</a> | <a href="#top">Top</a></small></p></div></div>

<div class="row-fluid">
  <div class="span12">
  <span id="purchasing"></span>
  <?php include '_purchasing.php'; ?>
  </div>
</div>

<div class="row-fluid"><div class="span12 pull-right"><p class="text-right" id="anchor"><small>Jump to: <a href="#facility">Facility</a> | <a href="#ap">Decision</a> | <a href="#purchasing">Purchasing</a> | <a href="#received">Receiving</a> | <a href="#billing">Billing</a> | <a href="#top">Top</a></small></p></div></div>

<div class="row-fluid">
  <div class="span12">
  <span id="received"></span>
  <?php include '_facility_received.php'; ?>
  </div>
</div>

<div class="row-fluid"><div class="span12 pull-right"><p class="text-right" id="anchor"><small>Jump to: <a href="#facility">Facility</a> | <a href="#ap">Decision</a> | <a href="#purchasing">Purchasing</a> | <a href="#received">Receiving</a> | <a href="#billing">Billing</a> | <a href="#top">Top</a></small></p></div></div>

<div class="row-fluid">
  <div class="span12">
  <span id="billing"></span>
  <?php if(Yii::app()->user->getState('role')=='S' or Yii::app()->user->getState('role')=='CL' or Yii::app()->user->getState('role')=='AP-QA' or Yii::app()->user->getState('role')=='SA')://hardcoded acronyms from table group ?>
  <?php include '_ap_invoicing.php'; ?>
  <?php endif; ?>
  </div>
</div>

<div class="row-fluid"><div class="span12 pull-right"><p class="text-right" id="anchor"><small>Jump to: <a href="#facility">Facility</a> | <a href="#ap">Decision</a> | <a href="#purchasing">Purchasing</a> | <a href="#received">Receiving</a> | <a href="#billing">Billing</a> | <a href="#top">Top</a></small></p></div></div>
