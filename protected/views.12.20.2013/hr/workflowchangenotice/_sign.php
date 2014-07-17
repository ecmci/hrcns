<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workflow-approval-form',
  'type'=>'horizontal',
  'action'=>Yii::app()->createUrl('hr/workflowchangenotice/sign'),
  'method'=>'post',
  'enableClientValidation'=>true,
  'enableAjaxValidation'=>false,
  'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
  'htmlOptions' => array(
    'enctype' => 'multipart/form-data',
    'class'=>'well'
  ),
)); 

Yii::app()->clientScript->registerScript('btn-decline-confirm',"
$('#btn-decline-confirm').click(btnDeclineConfirm);
");
Yii::app()->clientScript->registerScript('btnDeclineConfirm',"
function btnDeclineConfirm(){
  var url = '".Yii::app()->createAbsoluteUrl('hr/workflowchangenotice/decline')."';
  var params = 'routeback=' + $('#decline-action').val() + '&id=' + $('#WorkflowChangeNotice_id').val() + '&comment=' + $('#WorkflowChangeNotice_comment').val();
  $.post(url,params,function(response){
    console.log(response);
    if(response == '1'){
      window.location = '".Yii::app()->user->returnUrl."';
    }else{
      alert(response);
    }
  });
}
",CClientScript::POS_BEGIN);

?>

  
  <?php echo $form->hiddenField($notice,'id',array('class'=>'span5')); ?>
  
  <?php echo $form->textAreaRow($notice,'comment',array('class'=>'span10','rows'=>5,'value'=>$notice->retrieveComment())); ?>
  
  <div class="control-group">
  <?php echo CHtml::label('Attachment','',array('class'=>'control-label')); ?>
  <div class="controls">
  <?php echo $form->fileField($notice,'attachment',array('class'=>'span5')); ?>
  </div>
  </div>

	<div class="form-actions">
		<?php echo $form->errorSummary($notice); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'warning',
			'label'=>'Process',
      'htmlOptions'=>array('name'=>'WorkflowChangeNotice[decision]','value'=>'process'),
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Approve',
      'htmlOptions'=>array('name'=>'WorkflowChangeNotice[decision]','value'=>'approve'),
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'danger',
			'label'=>'Decline',
      'htmlOptions'=>array(
        'id'=>'btn-decline',
        'name'=>'WorkflowChangeNotice[decision]',
        'value'=>'decline',
        'data-toggle'=>'modal',
        'data-target'=>'#modal-decline',
      ),
      'url' => array('#'),
		)); ?>
	</div> 

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal-decline')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Confirm Decline Action</h4>
</div>
 
<div class="modal-body">
    <p>Choose an action below:</p>
    <?php echo CHtml::dropDownList('decline-action','decline-action',array('1'=>'Decline and Have BOM Revise This Request','0'=>'Decline and Totally Reject'),array('id'=>'decline-action','class'=>'span12')); ?>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Confirm',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal','id'=>'btn-decline-confirm'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Cancel',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>