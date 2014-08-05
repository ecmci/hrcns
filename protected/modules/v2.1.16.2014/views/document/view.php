<?php
$this->breadcrumbs=array(
	'Documents'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Document','url'=>array('index')),
	array('label'=>'Create Document','url'=>array('create')),
	array('label'=>'Update Document','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Document','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Document','url'=>array('admin')),
);
?>

<h1 class="page-header">View Document #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'emp_id',
		'submitted_by',
		'name',
		'serial_number',
		'date_issued',
		'date_of_expiration',
		'attachment',
		'timestamp',
	),
)); ?>
