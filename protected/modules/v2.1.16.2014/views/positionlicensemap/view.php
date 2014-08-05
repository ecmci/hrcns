<?php
$this->breadcrumbs=array(
	'Position License Maps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PositionLicenseMap','url'=>array('index')),
	array('label'=>'Create PositionLicenseMap','url'=>array('create')),
	array('label'=>'Update PositionLicenseMap','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PositionLicenseMap','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PositionLicenseMap','url'=>array('admin')),
);
?>

<h1 class="page-header">View PositionLicenseMap #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'position_code',
		'license_name',
		'default_expiration',
	),
)); ?>
