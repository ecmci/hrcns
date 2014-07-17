<?php
 $this->layout = 'column1';
 $this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	'New',
);

Helper::includeJui();
Helper::renderDatePickers();

Yii::app()->clientScript->registerScript('dona',"
function showTab(idx){
$('#dona'+idx).tab('show');
}
",CClientScript::POS_BEGIN);
Helper::uploadifyFileFields();
?>
<h1 id="form" class="page-header">New Change Notice Form</h1>

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
<?php 
$tab0Buttons = '<div class="form-actions"><a onclick="showTab(1)" href="#form" class="btn btn-large">Next</a></div>';
$tab1Buttons = '<div class="form-actions"><a onclick="showTab(0)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(2)" href="#form" class="btn btn-large">Next</a></div>';
$tab2Buttons = '<div class="form-actions"><a onclick="showTab(1)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(3)" href="#form" class="btn btn-large">Next</a></div>';
$tab3Buttons = '<div class="form-actions"><a onclick="showTab(2)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(4)" href="#form" class="btn btn-large">Next</a></div>';
$tab4Buttons = '<div class="form-actions"><a onclick="showTab(3)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(5)" href="#form" class="btn btn-large">Next</a></div>';
$tab5Buttons = '<div class="form-actions"><a onclick="showTab(4)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(6)" href="#form" class="btn btn-large">Next</a></div>';
$tab6Buttons = '<div class="form-actions"><input class="btn btn-large btn-primary" value="Submit" type="submit"/> <a onclick="showTab(5)" href="#form" class="btn btn-large">Back</a></div>';
?>
<div style="min-height:300px;">
 
<?php $this->widget('bootstrap.widgets.TbTabs', array(
  'id'=>'',
  'type'=>'tabs',
  'placement'=>'left', // 'above', 'right', 'below' or 'left'
  'tabs'=>array(
      array(
        'label'=>'Define Change Type', 
        'content'=>$this->renderPartial('_new',array('form'=>$form,'model'=>$model),true).$tab0Buttons, 
        'active'=>true, 
        'linkOptions'=>array('id'=>'dona0')
      ),
      array(
        'label'=>'Review Basic Info', 
        'content'=>$this->renderPartial('/hr/employee/_form_basic',array('model'=>$emp_basic,'form'=>$form),true).$tab1Buttons, 
        'linkOptions'=>array('id'=>'dona1')
      ),
      array(
        'label'=>'Review Personal Info', 
        'content'=>$this->renderPartial('/hr/employee/_form_personal',array('model_personal'=>$emp_personal,'form'=>$form),true).$tab2Buttons, 
        'linkOptions'=>array('id'=>'dona2')
      ),
      array(
        'label'=>'Review Employment Info', 
        'content'=>$this->renderPartial('/hr/employee/_form_employment',array('model_employment'=>$emp_employment,'form'=>$form),true).$tab3Buttons, 
        'linkOptions'=>array('id'=>'dona3')
      ),
      array(
        'label'=>'Review Payroll Info', 
        'content'=>$this->renderPartial('_form_payroll',array('model_payroll'=>$emp_payroll,'form'=>$form,'notice'=>$model),true).$tab4Buttons, 
        'linkOptions'=>array('id'=>'dona4')
      ),
      array(
        'label'=>'Attachments', 
        'content'=>'<div id="attachment-section">'.$this->renderPartial('_attachments',array('form'=>$form,'notice'=>$model,'type'=>$model->notice_type, 'subtype'=>$model->notice_sub_type),true).'</div>'.$tab5Buttons, 
        'linkOptions'=>array('id'=>'dona5')
      ),
      array(
        'label'=>'Workflow Comments', 
        'content'=>$form->textAreaRow($model,'comment',array('class'=>'span5')).$tab6Buttons, 
        'linkOptions'=>array('id'=>'dona6')
      ),      
  ),
)); ?>
</div>
<div class="">
 <?php echo $form->errorSummary(array($model,$emp_basic,$emp_personal,$emp_employment,$emp_payroll)); ?>
</div>
<?php $this->endWidget(); ?>    
