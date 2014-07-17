<?php
$this->breadcrumbs=array(
	'HR User'=>array('index'),
	'Account Recovery',
);
?>
<h1 class="page-header">Account Recovery</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'hr-user-form',
	'type'=>'horizontal',
  'enableClientValidation'=>true,
  'enableAjaxValidation'=>true,
  'focus'=>array($model,'last_name'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

  <?php
    $flashMessages = Yii::app()->user->getFlashes();
    if ($flashMessages) {        
      foreach($flashMessages as $key => $message) {
          echo '<div class="alert alert-info '.$key.'">';
          echo '<button class="close" data-dismiss="alert" type="button">X</button>';
          echo $message;
          echo '</div>';
      }
    }
    ?>

  <?php echo $form->textFieldRow($model, 'email', array('placeholder'=>'Registered Email Address')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>'Recover',
		)); ?> 
    
	</div>

<?php $this->endWidget(); ?>
