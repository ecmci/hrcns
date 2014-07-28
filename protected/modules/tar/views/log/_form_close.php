<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tar-log-form',
	'enableAjaxValidation'=>true,
  'enableClientValidation'=>true,
)); ?>

<?php echo BHtml::textArea($model,'reason_for_closing',array('class'=>'span12'),$form); ?>

<div class="row-fluid">
  <div class="span12">
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'encodeLabel'=>false,
            'type'=>'primary',
            'htmlOptions'=>array('class'=>'btn btn-primary btn-large'),
            'label'=>'<span class="icon-ban-circle"></span> Close',
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