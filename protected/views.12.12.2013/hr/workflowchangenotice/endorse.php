<?php
$this->layout = 'column1';
$this->breadcrumbs=array(
	'Employee'=>array('index'),
	'New Hire Form',
);

$this->menu=array(
	array('label'=>'List Employee','url'=>array('index')),
	array('label'=>'Manage Employee','url'=>array('admin')),
);

Helper::includeJui();
Helper::renderDatePickers();

Yii::app()->clientScript->registerScript('niceOne',"
$(document).ready(function(){
  /* $('#btn-submit').attr('disabled','disabled');   
  var windowHeight = $(window).height()-400;
  $('.scroll-view').height(windowHeight); */ 
});
$('#EmployeePayroll_state_add').focus(function(){
  /* $('#btn-submit').removeAttr('disabled'); */   
});
$('#btn-decline-confirm').click(function(){
  var url = '".Yii::app()->createAbsoluteUrl('hr/workflowchangenotice/decline')."';
  var params = 'routeback=' + $('#decline-action').val() + '&id=' + $('#WorkflowChangeNotice_id').val() + '&comment=' + $('#WorkflowChangeNotice_comment').val();
  var successUrl = '".Yii::app()->user->returnUrl."';
  $.post(url,params,function(response){
  console.log(response);
  if(response == '1'){
    window.location = successUrl;
  }else{
    alert(response);
  }
});
});
");
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  	  'id'=>'workflow-endorse-new-employee-form',
      'type'=>'horizontal',
  	  'enableClientValidation'=>true,
      'enableAjaxValidation'=>true,
      'focus'=>array($model,'last_name'),
    	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
      'clientOptions'=>array(
    		'validateOnSubmit'=>true,
    	),
  )); ?>
  
<h2 class="page-header"><?php echo $notice->notice_type; ?> Notice - <?php echo Employee::model()->find("emp_id = '".$notice->personalProfile->emp_id."'")->getFullName(); ?> <small>(Effective <?php echo $notice->effective_date; ?>)</small></h2>
<?php echo $form->hiddenField($notice,'id'); ?>

<div class="row-fluid">      
     <p>Fields with <span class="required">*</span> are required.</p>
     <div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
      <ul class="nav nav-tabs">
        <li><a href="#tab1" data-toggle="tab">1. Basic Information</a></li>
        <li><a href="#tab2" data-toggle="tab">2. Personal Data</a></li>
        <li class="active"><a href="#tab3" data-toggle="tab">3. Employment Details</a></li>
        <li><a href="#tab4" data-toggle="tab">4. Payroll Specifications</a></li>
        <li><a href="#tab5" data-toggle="tab">5. Attachments</a></li>
        <li><a href="#tab6" data-toggle="tab">6. Workflow</a></li>
      </ul>
      <div class="tab-content">
          <div class="tab-pane" id="tab1">
            <div class="scroll-view">
            <?php $this->renderPartial('/hr/employee/_form_basic',array('model'=>$model,'form'=>$form));  ?>
            </div>
          </div>
          <div class="tab-pane" id="tab2">
            <div class="scroll-view">
            <?php $this->renderPartial('/hr/employee/_form_personal',array('model_personal'=>$model_personal,'form'=>$form));  ?>
            </div>
          </div>
          <div class="tab-pane active" id="tab3">
            <div class="scroll-view">
            <?php $this->renderPartial('/hr/employee/_form_employment',array('model_employment'=>$model_employment,'form'=>$form));  ?>
            </div>
          </div>
          <div class="tab-pane" id="tab4">
            <div class="scroll-view">
            <?php $this->renderPartial('/hr/employee/_form_payroll',array('model_payroll'=>$model_payroll,'form'=>$form));  ?>
            </div>
          </div>
          <div class="tab-pane" id="tab5">
            <div class="scroll-view">
            <ol>
            <?php
              if(!empty($notice->attachments)){
                $attachments = WorkflowChangeNotice::parseAttachments($notice->attachments);
                foreach($attachments as $i=>$attachment){
                  echo '<li><i class="icon-envelope"></i> '.CHtml::link($attachment['pretty'],Yii::app()->baseUrl.'/uploads/'.$attachment['raw'],array('target'=>'_blank') ).'</li>';  
                }                                                           
              }
            ?>
            </ol>  
            </div>
          </div>
          <div class="tab-pane" id="tab6">
            <fieldset><legend>Workflow</legend> 
            <div><?php $this->renderPartial('_comment_feed',array('notice'=>$notice)); ?></div>
            <?php echo $form->textAreaRow($notice,'comment',array('class'=>'span5'));  ?>
            
            <div class="control-group">
            <?php echo CHtml::label('Attachment','',array('class'=>'control-label')); ?>
            <div class="controls">
            <?php echo CHtml::activeFileField($notice,'attachment');  ?>            
            </div>
            </div>
            
            </fieldset>
          </div>
        </div>
      </div>
  </div>
  <div class="form-actions">
    <?php echo $form->errorSummary(array($model,$model_personal,$model_employment,$model_payroll,$notice));?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>Yii::app()->user->getState('hr_group') == 'CORP' ? 'Approve' : 'Submit','size'=>'large','htmlOptions'=>array('id'=>'btn-submit'))); ?>
    <?php if(Yii::app()->user->getState('hr_group') == 'CORP' and $notice->status == WorkflowChangeNotice::$WAITING) {
      $this->widget('bootstrap.widgets.TbButton', array(
  			'buttonType'=>'link',
  			'type'=>'danger',
        'size'=>'large',
  			'label'=>'Decline',
        'htmlOptions'=>array(
          'id'=>'btn-decline',
          'value'=>'decline',
          'data-toggle'=>'modal',
          'data-target'=>'#modal-decline',
        ),
        'url' => array('#'),
  		));
    } ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
  </div>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal-decline')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Confirm Decline Action</h4>
</div>
 
<div class="modal-body">
    <p>Choose an action below:</p>
    <?php echo CHtml::dropDownList('decline-action','decline-action',array('1'=>'Decline and Have BOM Revise This Request','0'=>'Decline and Totally Reject'),array('id'=>'decline-action','class'=>'span5')); ?>
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