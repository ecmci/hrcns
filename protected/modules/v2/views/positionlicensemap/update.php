<?php
$this->breadcrumbs=array(
	'Position License Maps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PositionLicenseMap','url'=>array('index')),
	array('label'=>'Create PositionLicenseMap','url'=>array('create')),
	array('label'=>'View PositionLicenseMap','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PositionLicenseMap','url'=>array('admin')),
);
?>

<h1 class="page-header">Update PositionLicenseMap <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>