<?php
$this->layout = '//layouts/print';
Yii::app()->clientScript->registerScript('notice-print-js',"
window.print();
",CClientScript::POS_READY);
?>
<h1 id="top" class="page-header"><?php echo $notice->employee; ?> <small><?php echo App::printEnum($notice->notice_type); ?> Notice (<?php echo $notice->id; ?>) Effective <?php echo App::printDate($notice->effective_date); ?></small></h1>
<div class="row-fluid">  
	<div class="span12">
		<h2 id="notice" class="page-header">Notice</h2>
		<?php $this->renderPartial('_header_print',array('notice'=>$notice)); ?>
		<h2 id="employee" class="page-header">Proposed Employee Information</h2>
		<?php $this->renderPartial('_employee',array('employee'=>$employee,'personal'=>$personal,'employment'=>$employment,'payroll'=>$payroll)); ?>
		<h2 id="workflow" class="page-header">Workflow</h2>
		<?php $this->renderPartial('_workflow',array('notice'=>$notice)); ?>
        <?php if($notice->isSignable()): ?>
        <h2 id="decide" class="page-header">Decide</h2>
		<?php $this->renderPartial('_sign',array('notice'=>$notice)); ?>
        <?php endif; ?>
	</div>
</div>
<br/><br/><br/>
