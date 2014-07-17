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

	<div class="alert alert-warning">
		<strong>Overriding this notice will do the following:</strong>
		<ol>
			<li>It does not approve or decline this notice unless you set the status to 'DECLINED'.</li>
			<li>This routes it back to the processing group you specify below.</li>			
			<li>Saves your comment, name and date signed.</li>		
			<li>Alert that group.</li>				
		</ol>
	</div>
	
	 <?php echo $form->errorSummary($model);?>

  <?php echo $form->dropdownListRow($model,'status',ZHtml::enumItem($model,'status'),array('class'=>'span5','hint'=>'If you want to route this back to BOM, set the status to WAITING.')); ?>

  <?php echo $form->dropdownListRow($model,'processing_group',ZHtml::enumItem($model,'processing_group'),array('class'=>'span5','hint'=>'What user or group should re-process this?')); ?>
  
  <?php echo $form->textAreaRow($model,'comment',array('class'=>'span5','hint'=>'Why do you want this routed back?')); ?>

  <div class="form-actions">   
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Override','size'=>'large')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
  </div>

<?php $this->endWidget(); ?>
