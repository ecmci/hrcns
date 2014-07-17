<fieldset><legend>Requisition User</legend>
<?php echo $form->dropDownListRow($model_req,'group',Group::getList(),array('empty'=>'-select-','class'=>'span5')); ?>
<?php echo $form->dropDownListRow($model_req,'facility_handled_ids',Facility::getList(),array('multiple'=>true,'class'=>'span5','maxlength'=>45,'style'=>'height:200px;','hint'=>'Tip: Hold down CTRL key to select multiple items.')); ?>  
</fieldset>                                              