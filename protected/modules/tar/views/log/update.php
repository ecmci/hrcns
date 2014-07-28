<?php
$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	$model->case_id=>array('view','id'=>$model->case_id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'<span class="icon-plus"></span> Create New','url'=>array('create')),
  array('label'=>'<span class="icon-pencil"></span> Edit','url'=>'#','linkOptions'=>array('onclick'=>'enableForm();')),
  array('label'=>'<span class="icon-arrow-left"></span> Undo Changes','url'=>'#','linkOptions'=>array('submit'=>array('update','id'=>$model->case_id),'confirm'=>'Are you sure you want to undo all changes?')),
	array('label'=>'<span class="icon-ban-circle"></span> Close This Case','url'=>array('close','id'=>$model->case_id)),
	array('label'=>'<span class="icon-bullhorn"></span> Follow Up','url'=>array('followup','id'=>$model->case_id)),
  array('label'=>'<span class="icon-step-backward"></span> Back to List','url'=>array('index')),
);
?>

<h1 class="page-header"><span id="operation">View</span> TAR Case # <?php echo $model->case_id; ?> - <small><?php echo ($model->is_closed=='0') ? 'Open' : 'Closed'; ?></small></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
	'id'=>'tar-log-form',
	//'enableAjaxValidation'=>true,
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    //'validateOnChange'=>true,  
  )
)); ?>

<div class="row-fluid">
  <div class="span12">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab1" data-toggle="tab"><strong>TAR Form</strong></a></li>
      <li><a href="#tab2" data-toggle="tab"><strong>Procedures and Checklists</strong></a></li>
      <li><a href="#tab3" data-toggle="tab"><strong>Configured Alerts</strong></a></li>
      <li><a href="#tab4" data-toggle="tab"><strong>Activity Log</strong></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab1"><?php $this->renderPartial('_form',array('model'=>$model,'form'=>$form)); ?></div>
      <div class="tab-pane" id="tab2"><?php $this->renderPartial('_form_procedures_checklist',array('model'=>$model,'form'=>$form)); ?></div>
      <div class="tab-pane" id="tab3"><?php $this->renderPartial('_form_alerts',array('model'=>$model,'form'=>$form)); ?></div>
      <div class="tab-pane" id="tab4"><?php $this->renderPartial('_activity_log',array('model'=>$model)); ?></div>            
    </div>
  </div>
</div>

<div class="row-fluid">
  <div class="span12">
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'encodeLabel'=>false,
            'type'=>'primary',
            'htmlOptions'=>array('class'=>'btn btn-primary btn-large'),
            'label'=>$model->isNewRecord ? '<span class="icon-ok"></span> Create' : '<span class="icon-ok"></span> Save',
        )); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'link',
            'encodeLabel'=>false,
            'url'=>array('/tar/log'),
            'htmlOptions'=>array('class'=>'btn btn-mini'),
            'label'=>'<span class="icon-trash"></span> Cancel',
        )); ?>
    </div>
  </div>
</div>

<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScript('tar-form-ready-js',"
$('.datepicker').datepicker({
  changeMonth : true,
  changeYear : true,
});
disableForm();
",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('tar-form-fxns-js',"
function enableForm(){
  $('form#tar-log-form input, form#tar-log-form select, form#tar-log-form textarea').each(function(){
    $(this).removeAttr('disabled');
  });
  $('.form-actions, .other-controls').show();
  $('#operation').html('Update');
} 

function disableForm(){
  $('form#tar-log-form input, form#tar-log-form select, form#tar-log-form textarea').each(function(){
    $(this).attr('disabled','disabled');
  });
  $('.form-actions, .other-controls').hide();
  $('#operation').html('View');
}     
",CClientScript::POS_END);  
?>

