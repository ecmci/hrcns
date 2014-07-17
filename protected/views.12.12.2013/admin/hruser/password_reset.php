<?php
$this->breadcrumbs=array(
	'HR User'=>array('index'),
	'Password Reset',
);
?>
<h1 class="page-header">Password Reset</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'hr-pwreset-form',
	'type'=>'horizontal',
  'focus'=>array($model,'new_password'),
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

  <?php echo $form->passwordFieldRow($model, 'new_password', array('placeholder'=>'New Password')); ?>

  <?php echo $form->passwordFieldRow($model, 'repeat_password', array('placeholder'=>'Repeat Password')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>'Save',
		)); ?> 
    
	</div>

<?php $this->endWidget(); ?>