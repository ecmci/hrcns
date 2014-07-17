<?php
 $this->layout = 'column1';
 $this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	'New',
);
Helper::includeJui();
Helper::renderDatePickers();
Helper::uploadifyFileFields();
?>
<h1 id="form" class="page-header"><?php echo Helper::printEnumValue($model->notice_type); ?> Notice</h1>
<?php 
$tab0Buttons = '<div class="form-actions"><a onclick="showTab(1)" href="#form" class="btn btn-large">Next</a></div>';
$tab1Buttons = '<div class="form-actions"><a onclick="showTab(0)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(2)" href="#form" class="btn btn-large">Next</a></div>';
$tab2Buttons = '<div class="form-actions"><a onclick="showTab(1)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(3)" href="#form" class="btn btn-large">Next</a></div>';
//$tab3Buttons = '<div class="form-actions"><input class="btn btn-large btn-primary" value="Submit" type="submit"/> <a id="route-to-bom" class="btn btn-danger btn-large" href="#">Decline and Route Back to BOM</a> <a onclick="showTab(2)" href="#form" class="btn">Back</a></div>';

$tab3Buttons  = '
<div class="form-actions"> 
    <div class="btn-group">
		<a class="btn btn-large btn-success dropdown-toggle" data-toggle="dropdown" href="#">
		Decide
		<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><a id="approve" href="#"><i class="icon icon-thumbs-up"></i> Approve</a></li>
			<li><a id="routeback" href="#"><i class="icon icon-user"></i><i class="icon icon-backward"></i> Decline BUT Route Back to BOM</a></li>
			<li><a id="decline" href="#"><i class="icon icon-thumbs-down"></i> Decline Completely</a></li>
		</ul>
    </div>    
    <a onclick="showTab(2)" href="#form" class="btn">Back</a>
    <a id="btn-cancel" class="btn btn-warning">Cancel</a>
</div>
';

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workflow-change-notice-form',
  'type'=>'horizontal',
  'enableClientValidation'=>true,
  'enableAjaxValidation'=>true,
  'focus'=>array($model,'notice_type'),
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>
<div class=""> 
	<?php echo $form->hiddenField($model,'decision'); ?>
  <?php echo $form->errorSummary(array($model,$emp_basic,$emp_personal,$emp_employment,$emp_payroll)); ?>
  <?php //echo $form->errorSummary(array($model)); ?>
  <?php //echo $form->errorSummary(array($emp_basic)); ?>
  <?php //echo $form->errorSummary(array($model,$emp_basic,$emp_personal,$emp_employment,$emp_payroll)); ?>
  <?php //echo $form->errorSummary(array($model,$emp_basic,$emp_personal,$emp_employment,$emp_payroll)); ?>
</div>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
  'id'=>'',
  'type'=>'tabs',
  'placement'=>'left', // 'above', 'right', 'below' or 'left'
  'tabs'=>array(
      array(
        'label'=>'Notice', 
        'content'=>$this->renderPartial('_new2',array('form'=>$form,'model'=>$model,'employment'=>$emp_employment),true).$tab0Buttons, 
        'active'=>true, 
        'linkOptions'=>array('id'=>'dona0')
      ),
      array(
        'label'=>'Employee Information', 
        'content'=>
          $this->renderPartial('/hr/employee/_form_basic',array('model'=>$emp_basic,'form'=>$form),true).
          $this->renderPartial('/hr/employee/_form_personal',array('model_personal'=>$emp_personal,'form'=>$form),true).
          $this->renderPartial('/hr/employee/_form_employment',array('model_employment'=>$emp_employment,'form'=>$form,'notice'=>$model),true).
          $this->renderPartial('_form_payroll',array('model_payroll'=>$emp_payroll,'form'=>$form,'notice'=>$model),true).$tab1Buttons.
          '<br/><br/><br/>', 
        'linkOptions'=>array('id'=>'dona1')
      ),
      array(
        'label'=>'Attachments', 
        'content'=>'<div id="attachment-section">'.$this->renderPartial('_finalize_attachments',array('form'=>$form,'notice'=>$model,'type'=>$model->notice_type, 'subtype'=>$model->notice_sub_type),true).'</div>'.$tab2Buttons, 
        'linkOptions'=>array('id'=>'dona2'),        
        //'active'=>true,
      ),
      array(
        'label'=>'Workflow Review and Sign', 
        'content'=>'<fieldset><legend>Workflow</legend>'.
				   $this->renderPartial('_workflow_feed',array('notice'=>$model),true).
				   '</fieldset>'.
				   '<div class="well"><fieldset><legend>HR Signs Here</legend>'.	
				   $form->textAreaRow($model,'comment',array('class'=>'span5')).				   				   	
                   $form->textFieldRow($model,'effective_date',array('class'=>'span5 datepicker')).
                   '</fieldset>'.
                   $tab3Buttons.'</div><br><br><br><br><br><br><br>', 
        'linkOptions'=>array('id'=>'dona3'),
        //'active'=>true,
      ),      
  ),
)); ?>



<?php $this->endWidget(); ?>   

<?php 
Yii::app()->clientScript->registerCss('finalize-css',"
.tab-content{
	min-height: 600px;
}
");
Yii::app()->clientScript->registerScript('finalize-js',"
function showTab(idx){
	$('#dona'+idx).tab('show');
}
",CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScript('finalize-js',"
var comment = $('#".CHtml::activeId($model,'comment')."');
var form = $('#workflow-change-notice-form');
var decision = $('#".CHtml::activeId($model,'decision')."');
$('#approve').on('click',function(){
	if(confirm('You are about to approve this notice. Approving means you have reviewed and found the information here to be correct. ARE YOU SURE?')){
		decision.val('1');
		form.submit();
	}
});
$('#routeback').on('click',function(){
	if(confirm('You are about to decline and have BOM correct the errors in this notice. This will be routed back to BOM, where he/she can make the necessary corrections. ARE YOU SURE?')){
    if($.trim(comment.val()).length == 0){
			alert('Comment is required.');
		}else{
			decision.val('2');
			form.submit();
		}
	}
});
$('#decline').on('click',function(){
	if(confirm('You are about to decline this notice completely. Declining completely means this notice is totally denied. ARE YOU SURE?')){
		if($.trim(comment.val()).length == 0){
			alert('Comment is required.');
		}else{
			decision.val('0');
			form.submit();
		}
	}
});
",CClientScript::POS_READY);
?>
