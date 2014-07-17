<?php echo $form->dropDownListRow($employment,'position_code',Position::getList(),array('empty'=>'', 'class'=>'span5')); ?>

<?php echo $form->dropDownListRow($employment,'facility_id',KioskApp::getFacilityList(),array('empty'=>'', 'class'=>'span5')); ?>