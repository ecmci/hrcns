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

Yii::app()->clientScript->registerScript('blur',"
$('#".CHtml::activeId($model_employment,'date_of_hire')."').change(function(){
  $('#".CHtml::activeId($model_employment,'start_date')."').val($(this).val());
  $('#".CHtml::activeId($notice,'effective_date')."').val($(this).val());
  $('#".CHtml::activeId($model_payroll,'rate_effective_date')."').val($(this).val());
  $('#".CHtml::activeId($model_payroll,'pto_effective_date')."').val($(this).val());
});
$('#".CHtml::activeId($model_payroll,'rate_proposed')."').change(function(){  
  $('#".CHtml::activeId($model_payroll,'rate_approved')."').val($(this).val());
});
");

Yii::app()->clientScript->registerScript('show-submit-btn',"
/*$('#btn-submit').attr('disabled','disabled'); 
var wHeight = $(window).height() - 400;
$('.scroll-view').height(wHeight); */ 
",CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('wizard-style',"
function nextTab(tab){
  var tabIdx = parseInt(tab);
  $('#tab-li-' + (tabIdx-1)).removeAttr('class');
  $('#tab-li-' + tabIdx).attr('class','active');
  
  $('#tab'+ (tabIdx - 1) ).attr('class','tab-pane');
  $('#tab'+ tabIdx ).attr('class','tab-pane active');
  
  location.href='#top';
}
function backTab(tab){
  var tabIdx = parseInt(tab);
  $('#tab-li-' + (tabIdx+1)).removeAttr('class');
  $('#tab-li-' + tabIdx).attr('class','active');
  
  $('#tab'+ (tabIdx+1) ).attr('class','tab-pane');
  $('#tab'+ tabIdx ).attr('class','tab-pane active');
  
  location.href='#top';
  
}

",CClientScript::POS_BEGIN);

Helper::uploadifyFileFields();
?>
<h1 id="#top" class="page-header">New Hire Form</h1>

<div class="row-fluid">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  	  'id'=>'new-employee-form',
      'type'=>'horizontal',
  	  'enableClientValidation'=>true,
      'enableAjaxValidation'=>true,
      'focus'=>array($model,'last_name'),
    	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
      'clientOptions'=>array(
    		'validateOnSubmit'=>true,
    	),
  )); ?>
  <p>Fields with <span class="required">*</span> are required.</p>
  
  <?php echo $form->errorSummary(array(
              $model,
              $model_employment,
              $model_personal,
              $model_payroll,
              $notice
          )); ?>
  
  <div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs" id="myTabs">
      <li id="tab-li-1" class="active"><a href="#tab1" data-toggle="tab">1. Employee Information</a></li>
      <li id="tab-li-2"><a href="#tab2" data-toggle="tab">2. Attachments</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab1">
        <div class="scroll-view">
        <?php require_once '_form_basic.php';  ?>
        <?php require_once '_form_personal.php';  ?>
        <?php require_once '_form_employment.php';  ?>
        <?php require_once '_form_payroll.php';  ?>
        <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Next','size'=>'large','htmlOptions'=>array('onclick'=>'nextTab("2")'))); ?>   
        </div>
        </div>
      </div>
      <div class="tab-pane" id="tab2">
        <div class="scroll-view">
        <?php $this->renderPartial('/hr/workflowchangenotice/_attachments',array(
          'notice'=>$notice,
          'form'=>$form,
          'type'=>empty($type) ? 'NEW_HIRE' : $type,
          'subtype'=>empty($subtype) ? '' : $subtype,
          ));  ?>
          <?php echo ($notice->processing_group == 'CORP') ? $form->textAreaRow($notice,'comment',array('class'=>'span5')) : '';  ?>
        
        <?php echo $form->textFieldRow($notice,'effective_date',array('class'=>'span5 datepicker')); ?>
        
        <div class="form-actions">
          <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit','size'=>'large','htmlOptions'=>array('id'=>'btn-submit'))); ?>
          <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Back','size'=>'large','htmlOptions'=>array('onclick'=>'backTab("1")'))); ?>
          <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
        </div>
        </div>
      </div>
    </div>
  </div>
<?php $this->endWidget(); ?> 

</div>