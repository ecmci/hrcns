<fieldset><legend>HR User</legend>
<?php echo $form->dropDownListRow($model_hr,'group',ZHtml::enumItem($model_hr,'group'),array('empty'=>'-select-','class'=>'span5')); ?>
<?php echo $form->dropDownListRow($model_hr,'facility_handled_ids',Facility::getList(),array('multiple'=>true,'class'=>'span5','maxlength'=>45,'style'=>'height:200px;','hint'=>'Tip: Hold down CTRL key to select multiple items.')); ?>  
<?php echo $form->checkBoxRow($model_hr,'can_override_routing',array('class'=>'')); ?>
</fieldset>              