<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->emp_id,
);

$this->menu=array(
	array('label'=>'List Employee','url'=>array('index')),
	array('label'=>'Create Employee','url'=>array('create')),
	array('label'=>'Update Employee','url'=>array('update','id'=>$model->emp_id)),
	array('label'=>'Delete Employee','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->emp_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Employee','url'=>array('admin')),
);
?>

<h1 class="page-header">View Employee #<?php echo $model->emp_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'emp_id',
		'last_name',
		'first_name',
		'middle_name',
		'photo',
		'active_personal_id',
		'active_employment_id',
		'active_payroll_id',
		'timestamp',
	),
)); ?>
