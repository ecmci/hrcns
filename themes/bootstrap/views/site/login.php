<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' | Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="page-header">
  <h2>Welcome</h2> 
</div>
<div class="row-fluid">	
    <div class="well span6 offset3">
    <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'login-form',              
              'htmlOptions'=>array('class'=>'form-horizontal'),
          )); 
      ?>      
      <div class="control-group">
        <?php echo $form->labelEx($model,'username',array('class'=>'control-label','for'=>'username')); ?>
        <div class="controls">
          <?php echo $form->textField($model,'username',array('placeholder'=>'Username','required'=>'required','id'=>'username')); ?>

        </div>
      </div>
      <div class="control-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label','for'=>'password')); ?>
        <div class="controls">
          <?php echo $form->passwordField($model,'password',array('placeholder'=>'Password','required'=>'required')); ?>
        </div>
      </div>
      <div class="control-group">        
        <div class="controls">
          <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary btn-large')); ?>
        </div>
      </div>
      <div class="control-group">        
        <div class="controls">
        <?php Helper::displayErrorMessage($model);  ?>
        </div>
      </div>
      <?php $this->endWidget(); ?>
    </div><!-- well -->
</div>

