	<?php echo $form->dropDownListRow($model,'notice_type',ZHtml::enumItem($model,'notice_type'),array('class'=>'span5','maxlength'=>10)); ?>

	<div id="noticeSubForm">
		<?php echo $form->dropDownListRow($model,'notice_sub_type',ZHtml::enumItem($model,'notice_sub_type'),array('empty'=>'-select-','class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->dropDownListRow($model,'reason',array(
			'Probation'=>'Probation',
			'Annual'=>'Annual',
			'Status Change'=>'Status Change',
			'Other'=>'Other',
		),array('empty'=>'-select-','class'=>'span5','maxlength'=>256)); ?>
		<div id="otherReason">
			<?php echo $form->textAreaRow($model,'other_reason',array('class'=>'span5','maxlength'=>256)); ?>
		</div>
	</div>
	
	<?php echo $form->textFieldRow($model,'effective_date',array('class'=>'span5 datepicker','maxlength'=>256)); ?>
	
<?php 
App::renderDatePickers();
Yii::app()->clientScript->registerScript('notice-js-ready',"
/*on load*/
initMe();

/*events*/
$('#".CHtml::activeId($model,'notice_type')."').on('change',toggleNoticeSubForm);
$('#".CHtml::activeId($model,'reason')."').on('change',toggleOtherReason);
",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('notice-js-begin',"
function toggleOtherReason(){
	var reason = $('#".CHtml::activeId($model,'reason')."');
	var other_reason = $('#otherReason');
	other_reason.hide();
	switch(reason.val()){
		case 'Other': other_reason.show(); break;
	}	
}
function toggleNoticeSubForm(){
	var noticeSubForm = $('#noticeSubForm');
	var notice_type = $('#".CHtml::activeId($model,'notice_type')."');
	noticeSubForm.hide();
	switch(notice_type.val()){
		case 'CHANGE': noticeSubForm.show(); break;
	}	
}
function initMe(){
	toggleNoticeSubForm();
	toggleOtherReason();
}
",CClientScript::POS_BEGIN);
?>




