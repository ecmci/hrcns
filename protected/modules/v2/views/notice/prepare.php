<?php
$this->layout = '//layouts/column1';
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'notice-form',
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>

<h1 class="page-header"><?php echo $frm; ?> Form</h1>

<div class="row-fluid">
	<div class="span3">
		<div class="sticky-nav well" data-spy="affix" data-offset-top="200">
			<strong>Sections:</strong>
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="#notice">Notice</a></li>
				<li><a href="#employee">Employee Information</a></li>
				<li><a href="#attachments">Attachments</a></li>
				<li><a href="#workflow">Workflow</a></li>
			</ul>
		</div>
	</div>
	<div class="span9">
		<p class="alert alert-warning">Fields with <span class="required">*</span> are required.</p>
		<?php echo $form->errorSummary(array($notice,$employee,$personal,$employment,$payroll)); ?>
		<div id="notice">
			<h4 class="page-header">Notice</h4>
			<?php $this->renderPartial('/notice/_form',array('model'=>$notice,'form'=>$form)); ?>
		</div>
		<div id="employee">
			<h4 class="page-header">Employee Information</h4>
			<?php $this->renderPartial('/employee/_form',array('model'=>$employee,'form'=>$form)); ?>
			<?php $this->renderPartial('/personal/_form',array('model'=>$personal,'form'=>$form)); ?>
			<?php $this->renderPartial('/employment/_form',array('model'=>$employment,'form'=>$form)); ?>
			<?php $this->renderPartial('/payroll/_form',array('model'=>$payroll,'form'=>$form)); ?>
		</div>
		<div id="attachments">
			<h4 class="page-header">Attachments</h4>
			<?php $this->renderPartial('attachment',array('notice'=>$notice)); ?>
		</div>
		<?php if(isset($_GET['f']) and $_GET['f'] == 'h'):  ?>	
		<div id="licences">
			<h4 class="page-header">Licences, Certifications and Other Documents</h4>
			<?php $this->renderPartial('/document/_form',array('notice'=>$notice)); ?>
		</div>
		<?php endif; ?>
		<div id="workflow">
			<h4 class="page-header">Workflow</h4>
			<?php echo $form->textAreaRow($notice,'comments',array('placeholder'=>'Do you have something that the processors should note about? Comment here.', 'rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
		</div>
        <?php //if($notice->processing_group != 'CORP'): ?>
        <div id="push">
            <?php echo $form->checkBoxRow($notice,'push',array('class'=>'','hint'=>'<strong>Note:</strong> Check this if you want to push this to the next signing group.')); ?>
        </div>
        <?php //endif; ?>
		<div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'htmlOptions'=>array('class'=>'btn btn-success btn-large'),
            'label'=>'Submit',
        )); ?>
		</div> 
	</div>
</div>

<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('prepare-js-begin',"
function togglePtoEligibility(){
	var ptoSubForm = $('#ptoSubForm');
	var status = $('#".CHtml::activeId($employment,'status')."');
	var is_pto_eligible = $('#".CHtml::activeId($payroll,'is_pto_eligible')."');
	var pto_effective_date = $('#".CHtml::activeId($payroll,'pto_effective_date')."');
	var effective_date = $('#".CHtml::activeId($notice,'effective_date')."');
	ptoSubForm.hide();
	is_pto_eligible.removeAttr('checked');
	pto_effective_date.val('');
	if(status.val() == 'FULL_TIME'){
		ptoSubForm.show();
		is_pto_eligible.attr('checked','checked');
		pto_effective_date.val(effective_date.val());
	}
}
function setOtherDates(){
	var effective_date = $('#".CHtml::activeId($notice,'effective_date')."');	
	var notice_type = $('#".CHtml::activeId($notice,'notice_type')."');
	var rate_effective_date = $('#".CHtml::activeId($payroll,'rate_effective_date')."');
	var doh = $('#".CHtml::activeId($employment,'date_of_hire')."');
	var dot = $('#".CHtml::activeId($employment,'date_of_termination')."');
	
	rate_effective_date.val('');
	doh.val('');
	dot.val('');
	
	switch(notice_type.val()){
		case 'NEW_HIRE': case 'RE_HIRE':
			doh.val(effective_date.val());
			rate_effective_date.val(effective_date.val());
		break;
		case 'TERMINATED':
			dot.val(effective_date.val());
		break;
		case 'CHANGE':
			rate_effective_date.val(effective_date.val());
		break;
	}
}
function toggleDohDot(){
	var doh = $('#doh');
	var dot = $('#dot');
	var notice_type = $('#".CHtml::activeId($notice,'notice_type')."');
	doh.hide();
	dot.hide();
	switch(notice_type.val()){
		case 'NEW_HIRE': case 'RE_HIRE':
			doh.show();
		break;
		case 'TERMINATED':
			dot.show();
		break;
	}
}
",CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScript('prepare-js-ready',"
toggleDohDot();
/* togglePtoEligibility(); */
$('#".CHtml::activeId($notice,'notice_type')."').on('change',toggleDohDot);
$('#".CHtml::activeId($notice,'effective_date')."').on('change',setOtherDates);
$('#".CHtml::activeId($employment,'status')."').on('change',togglePtoEligibility);
",CClientScript::POS_READY);
Yii::app()->clientScript->registerCss('prepare-css',"
.sticky-nav{
	width:200px;
}
");
?>
<p>&nbsp;</p><p>&nbsp;</p>
