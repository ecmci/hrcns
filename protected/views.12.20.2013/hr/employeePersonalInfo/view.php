<?php
$this->breadcrumbs=array(
	'Employee Personal Infos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeePersonalInfo','url'=>array('index')),
	array('label'=>'Create EmployeePersonalInfo','url'=>array('create')),
	array('label'=>'Update EmployeePersonalInfo','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete EmployeePersonalInfo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeePersonalInfo','url'=>array('admin')),
);
?>

<h1>View EmployeePersonalInfo #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'emp_id',
		'facility_id',
		'birthdate',
		'gender',
		'marital_status',
		'SSN',
		'number',
		'building',
		'street',
		'zip_code',
		'telephone',
		'cellphone',
		'email',
		'is_approved',
		'timestamp',
	),
)); ?>
