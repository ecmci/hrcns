<?php
$this->menu = array(
    array('label'=>'Edit','url'=>array('edit','id'=>$notice->id)),
	array('label'=>'Print','url'=>array('print','id'=>$notice->id)),
	array('label'=>'Cancel Notice','url'=>'#','linkOptions'=>array('submit'=>array('cancel','id'=>$notice->id),'confirm'=>'Are you sure you want to cancel this notice?')),
    array('label'=>'Back','url'=>Yii::app()->request->urlReferrer),
);

Yii::app()->clientScript->registerCss('prepare-css',"
.sticky-nav{
	max-width:200px;
}
");

?>

<h1 id="top" class="page-header"><?php echo $notice->employee; ?> <small><?php echo App::printEnum($notice->notice_type); ?> Notice (<?php echo $notice->id; ?>) Effective <?php echo App::printDate($notice->effective_date); ?></small></h1>

<div class="row-fluid">            
	<div class="span3">
		<div class="sticky-nav well" data-spy="affix" data-offset-top="200">
			<strong>Reviewing Steps:</strong>
			<ol class="nav nav-tabs nav-stacked">
				<li><a href="#notice">Notice</a></li>
				<li><a href="#employee">Proposed Employee Information</a></li>
				<li><a href="#workflow">Workflow</a></li>
				<?php if($notice->isSignable()): ?>
                <li><a href="#decide">Decide</a></li>
                <?php endif; ?>
                <li><a href="#top">Back to Top</a></li>
			</ol>
		</div>
	</div>
	<div class="span9">
		<h2 id="notice" class="page-header">Notice</h2>
		<?php $this->renderPartial('_header',array('notice'=>$notice)); ?>
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
