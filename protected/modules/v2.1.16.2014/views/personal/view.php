<?php
$this->breadcrumbs=array(
	'Personals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Personal','url'=>array('index')),
	array('label'=>'Create Personal','url'=>array('create')),
	array('label'=>'Update Personal','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Personal','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Personal','url'=>array('admin')),
);
?>

<h1 class="page-header">View Personal #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'emp_id',
		'birthdate',
		'gender',
		'marital_status',
		'SSN',
		'number',
		'building',
		'street',
		'city',
		'state',
		'zip_code',
		'telephone',
		'cellphone',
		'email',
		'is_approved',
		'timestamp',
	),
)); ?>
