<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1 class="page-header">
Self-Service Kiosk 
</h1>

<ul class="nav nav-tabs nav-stacked">
  <li><a href="<?php echo Yii::app()->createUrl('/kiosk/employee/register'); ?>"><i class="icon icon-plus"></i> New Employee Application Form (<small class="muted">Are you a new employee? Use this form to submit your basic information to HR.</small>)</a></li>
</ul>