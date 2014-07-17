<?php
/* @var $this ManageController */

$this->breadcrumbs=array(
	'Manage',
);
?>
<h1 class="page-header">IT Systems Module Management</h1>

<div class="row-fluid">
  <div class="span8">
    <ul class="nav nav-tabs nav-stacked">
      <li><a href="<?php echo Yii::app()->createUrl('/itsystems/admin/system/index'); ?>">Manage System List</a></li>
      <li><a href="<?php echo Yii::app()->createUrl('/itsystems/admin/systemposition/index'); ?>">Manage Position-System Defaults</a></li>
    </ul> 
  </div>
  <div class="span4"></div> 
</div>