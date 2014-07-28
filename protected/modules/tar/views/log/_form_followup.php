<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tar-log-form',
	'enableAjaxValidation'=>true,
  'enableClientValidation'=>true,
)); ?>

<?php echo BHtml::textArea($model,'message',array('class'=>'span12'),$form); ?>

<?php echo BHtml::checkBox($model,'send_email',array(),$form); ?>

<?php echo BHtml::textField($model,'send_email_to',array('class'=>'span6','readonly'=>'readonly'),$form); ?>


<div class="row-fluid">
  <div class="span12">
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'encodeLabel'=>false,
            'type'=>'primary',
            'htmlOptions'=>array('class'=>'btn btn-primary btn-large'),
            'label'=>'<span class="icon-envelope"></span> Follow Up',
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
Yii::app()->clientScript->registerScript('form-close-ready-js',"
$('#".CHtml::activeId($model,'send_email')."').on('click',function(){
  if($('#".CHtml::activeId($model,'send_email')."').is(':checked')){
    $('#".CHtml::activeId($model,'send_email_to')."').removeAttr('readonly');
  }else{
    $('#".CHtml::activeId($model,'send_email_to')."').attr('readonly','readonly');
    $('#".CHtml::activeId($model,'send_email_to')."').val('');
  }  
});
",CClientScript::POS_READY); 
?>