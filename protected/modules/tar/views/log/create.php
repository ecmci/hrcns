<?php
$this->layout = '//layouts/column1';

$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'Manage TarLog','url'=>array('admin')),
);
?>

<h1 class="page-header">New TAR Case</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tar-log-form',
	//'enableAjaxValidation'=>true,
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    //'validateOnChange'=>true,  
  )
)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'form'=>$form)); ?>

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
",CClientScript::POS_READY);
?>