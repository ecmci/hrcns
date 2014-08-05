<?php
$this->breadcrumbs=array(
	'Position License Maps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PositionLicenseMap','url'=>array('index')),
	array('label'=>'Manage PositionLicenseMap','url'=>array('admin')),
);
?>

<h1 class="page-header">Create PositionLicenseMap</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>