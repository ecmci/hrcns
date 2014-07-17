<?php

$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	$notice->id,
);

$this->menu=array(
  array('label'=>'ADMIN',),
	array('label'=>'Override','url'=>'#','linkOptions'=>array('submit'=>array('override','id'=>$notice->id),'confirm'=>"Are you sure you want to OVERRIDE this notice?\n\nWARNING: Overriding removes signatures, attachment and comments on the workflow depending on what stage it needs to regress.")),
  '---',
  array('label'=>'Print Preview','url'=>array('print','id'=>$notice->id),'linkOptions'=>array('target'=>'_blank')),
  array('label'=>'Back To Notices','url'=>array('admin')),
);
?>
<h2 class="page-header"><?php echo Helper::printEnumValue($notice->notice_type).' - '.Helper::printEnumValue($notice->notice_sub_type); ?> Notice - <?php echo Employee::model()->find("emp_id = '".$notice->personalProfile->emp_id."'")->getFullName(); ?> <small>(Effective <?php echo $notice->effective_date; ?>)</small></h2>
<?php $this->renderPartial('_notice_header',array('notice'=>$notice)); ?>


<div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li><a href="#tab1" data-toggle="tab">Proposed Employee Information</a></li>
    <li><a href="#tab2" data-toggle="tab">Summary of Changes</a></li>
    <li class="active"><a href="#tab3" data-toggle="tab">Workflow</a></li>
    
  </ul>
  <div class="tab-content">                
    <div class="tab-pane" id="tab1">
      <?php 
      $this->renderPartial('_employee',array(
        'notice'=>$notice,
      ));
       ?>
    </div>
    <div class="tab-pane" id="tab2">
    <?php $this->renderPartial('_summary_of_changes',array(
        'notice'=>$notice,
      )); ?>
    </div>
    <div class="tab-pane active" id="tab3">
      <?php $this->renderPartial('_workflow',array(
        'notice'=>$notice,
      )); ?>           
    </div>
  </div>
</div>

