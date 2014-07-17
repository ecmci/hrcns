<?php
//$this->layout = 'column1';
$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
  'Override',
  $model->id,
);

$this->menu=array(
   array('label'=>'Back To Notices','url'=>array('admin')),
);
?>
<h1 class="page-header">Override Notice ID <?php echo $model->id ?></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workflow-override-form',
	'enableClientValidation'=>true,
  'enableAjaxValidation'=>true,
  'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>  

  <?php echo $form->dropdownListRow($model,'status',ZHtml::enumItem($model,'status'),array('class'=>'span5')); ?>
  
  <?php echo $form->dropdownListRow($model,'processing_group',ZHtml::enumItem($model,'processing_group'),array('class'=>'span5')); ?>
  
  <?php echo $form->dropdownListRow($model,'decision',array(
    'process'=>'Process',
    'approve'=>'Approve',
    'decline'=>'Decline',
    'na'=>'NA',
    ),array('empty'=>'- select your decision -','class'=>'span5')); ?>
  
  <?php echo $form->textAreaRow($model,'comment',array('class'=>'span5')); ?>

  <div class="form-actions">
    <?php echo $form->errorSummary($model);?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Override','size'=>'large')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
  </div>

<?php $this->endWidget(); ?>