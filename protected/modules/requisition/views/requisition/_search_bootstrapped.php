<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
  'htmlOptions' => array('class'=>'form-vertical'),
)); ?>

	<div class="row-fluid">
    <div class="span4">
  		<?php echo $form->label($model, 'idREQUISITION'); ?>
  		<?php echo $form->textField($model, 'idREQUISITION'); ?>
  	</div>
  	
  	<div class="span4">
  		<?php echo $form->label($model, 'po_num'); ?>
  		<?php echo $form->textField($model, 'po_num'); ?>
  	</div>
  
  	<div class="span4">
  		<?php echo $form->label($model, 'confirmation_number'); ?>
  		<?php echo $form->textField($model, 'confirmation_number'); ?>
  	</div>
  </div>
  
  <div class="row-fluid">
  	<div class="span4">
  		<?php echo $form->label($model, 'FACILITY_idFACILITY'); ?>
  		<?php //echo $form->dropDownList($model, 'FACILITY_idFACILITY', GxHtml::listDataEx(Facility::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
  		<?php $user = $user = User::model()->findByPk(Yii::app()->user->getState('id')); ?>
  		<?php echo $form->dropDownList($model,'FACILITY_idFACILITY', CHtml::listData($user->myFacilities, 'idFACILITY', 'title'), array('prompt' => Yii::t('app', 'All'))); ?>		
  	</div>
   
  	<div class="span4">
  		<?php echo $form->label($model, 'PRIORITY_idPRIORITY'); ?>
  		<?php echo $form->dropDownList($model, 'PRIORITY_idPRIORITY', GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
  	</div>
  
  	<div class="span4">
  		<?php echo $form->label($model, 'STATUS_idSTATUS'); ?>
  		<?php echo $form->dropDownList($model, 'STATUS_idSTATUS', GxHtml::listDataEx(Status::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
  	</div>
  </div>
	
  <div class="row-fluid">
	<div class="span4">
		<?php echo $form->label($model, 'REQTYPE_idREQTYPE'); ?>
		<?php echo $form->dropDownList($model, 'REQTYPE_idREQTYPE', GxHtml::listDataEx(ReqType::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="span4">
		<?php echo $form->label($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 100)); ?>
	</div>

	<div class="span4">
		<?php echo $form->label($model, 'preferred_vendor'); ?>
		<?php echo $form->textField($model, 'preferred_vendor', array('maxlength' => 100)); ?>
	</div>
  </div>

  <div class="row-fluid">
	<div class="span4">
		<?php echo $form->label($model, 'project_name'); ?>
		<?php echo $form->textField($model, 'project_name', array('maxlength' => 250)); ?>
	</div>
  </div>

	<div class="form-actions">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search'),array('class'=>'btn btn-primary btn-large')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
