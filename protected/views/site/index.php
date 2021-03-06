<?php
Yii::app()->clientScript->registerScript('mod1',"

  $('#employee-module').popover({
    title : 'Employee Module',
    content : 'Manage employees by adding, updating basic information and searching. (Admins Only)' ,
    placement : 'bottom',
    trigger : 'hover'
  });
  $('#change-notice-module').popover({
    title : 'Change Notice Module',
    content : 'Manage Change Notice Requests by creating, working and searching.' ,
    placement : 'bottom',
    trigger : 'hover'
  });
  $('#requisition-module').popover({
    title : 'Requisition Module',
    content : '(Integration is on its way...Please wait for further advise.)' ,
    placement : 'bottom',
    trigger : 'hover'
  });
",CClientScript::POS_READY);
$noticesForApproval = $notice->getRequestsNeedingApproval();
?>
<div class="row-fluid">
	<div class="span12 alert alert-warning">
	<small>
	<strong>Announcement:</strong> Version 1.0 user interface (UI) will be decomissioned on February 25, 2014. Users will be redirected to Version 2.0 UI. The database, however, remains one and the same for both versions.
	<br/>
	<strong>Try version 2.0.</strong> It's better. <a href="<?php echo Yii::app()->createUrl('v2'); ?>" title="Take me to version 2.0.">Click here</a>.
	</small>
	</div>
</div>
<div class="row-fluid" id="#top">
  <!--folders -->
  <div class="span3 well">
    <?php include_once '_folders.php'; ?>
  </div><!--end folders -->
  
  <!-- items -->
  <div class="span3 scrollview">
    <?php include_once '_items.php'; ?> 
  </div><!-- end items -->
  
  <!-- viewport -->
  <div class="span6 scrollview">
    <?php include_once '_viewport.php'; ?>  
  </div>
</div>
<br/>
<div class="row-fluid">
<p class="text-center"><?php echo CHtml::link('Back To Top','#top'); ?></p>
</div>
