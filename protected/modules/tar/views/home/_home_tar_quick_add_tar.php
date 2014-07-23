<?php
 $model = new TarLog;
?>
<div id="tar-quick-add-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel">Quick Add TAR Log</h3>
  </div>
  <div class="modal-body">
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  	'id'=>'tar-quick-add-form',
  	'enableAjaxValidation'=>false,
  )); ?> 
    <div class="row-fluid">
      <div class="span12">
      <?php echo BHtml::textField($model,'resident',array('class'=>'span12')); ?>
      </div>  
    </div>
    <div class="row-fluid">
      <div class="span12">
      <?php echo BHtml::dropDownList($model,'facility_id',TarHelper::getFacilityList(),array('class'=>'span12')); ?>
      </div>  
    </div>
    <div class="row-fluid">
      <div class="span12">
      <?php echo BHtml::textField($model,'requested_dos_date_from',array('class'=>'span12 datepicker')); ?>
      </div>  
    </div>
  <?php $this->endWidget(); ?> 
  </div>
  <div class="modal-footer">
    <button class="btn btn-mini" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary btn-large">Save</button>
  </div>
</div>