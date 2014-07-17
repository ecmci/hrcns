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
  
<h1 id="#top" class="page-header">New Hire Form</h1>

<div class="row-fluid">      
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
        <li id="tab-li-1" class="active"><a href="#tab1" data-toggle="tab">1. Basic Information</a></li>
        <li id="tab-li-2"><a href="#tab2" data-toggle="tab">2. Personal Data</a></li>
        <li id="tab-li-3"><a href="#tab3" data-toggle="tab">3. Employment Details</a></li>
        <li id="tab-li-4"><a href="#tab4" data-toggle="tab">4. Payroll Specifications</a></li>
        <li id="tab-li-5"><a href="#tab5" data-toggle="tab">5. Attachments</a></li>
      </ul>
      <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <div class="scroll-view">
            <?php require_once '_form_basic.php';  ?>
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Next','size'=>'large','htmlOptions'=>array('onclick'=>'nextTab("2")'))); ?>   
            </div>
            </div>
          </div>
          <div class="tab-pane" id="tab2">
            <div class="scroll-view">
            <?php require_once '_form_personal.php';  ?>
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Back','size'=>'large','htmlOptions'=>array('onclick'=>'backTab("1")'))); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Next','size'=>'large','htmlOptions'=>array('onclick'=>'nextTab("3")'))); ?>  
            </div>
            </div>
          </div>
          <div class="tab-pane" id="tab3">
            <div class="scroll-view">
            <?php require_once '_form_employment.php';  ?>
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Back','size'=>'large','htmlOptions'=>array('onclick'=>'backTab("2")'))); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Next','size'=>'large','htmlOptions'=>array('onclick'=>'nextTab("4")'))); ?>             </div>
            </div>
          </div>
          <div class="tab-pane" id="tab4">
            <div class="scroll-view">
            <?php require_once '_form_payroll.php';  ?>
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Back','size'=>'large','htmlOptions'=>array('onclick'=>'backTab("3")'))); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Next','size'=>'large','htmlOptions'=>array('onclick'=>'nextTab("5")'))); ?>             </div>
            </div>
          </div>          
          <div class="tab-pane" id="tab5">
            <div class="scroll-view">
            <?php $this->renderPartial('/hr/workflowchangenotice/_attachments',array(
              'notice'=>$notice,
              'form'=>$form,
              'type'=>empty($type) ? 'NEW_HIRE' : $type,
              'subtype'=>empty($subtype) ? '' : $subtype,
              ));  ?>
              <?php echo ($notice->processing_group == 'CORP') ? $form->textAreaRow($notice,'comment',array('class'=>'span5')) : '';  ?>
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit','size'=>'large','htmlOptions'=>array('id'=>'btn-submit'))); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'', 'label'=>'Back','size'=>'large','htmlOptions'=>array('onclick'=>'backTab("4")'))); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
            </div>
            </div>
          </div>
          <div class="form-actions">
          <?php echo $form->errorSummary(array(
              $model,
              $model_employment,
              $model_personal,
              $model_payroll,
              $notice
          )); ?>
          </div>
        </div>
      </div>
  </div>

<?php $this->endWidget(); ?> 