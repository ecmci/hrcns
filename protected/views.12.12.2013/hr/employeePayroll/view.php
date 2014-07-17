<?php
$this->breadcrumbs=array(
	'Employee Payrolls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeePayroll','url'=>array('index')),
	array('label'=>'Create EmployeePayroll','url'=>array('create')),
	array('label'=>'Update EmployeePayroll','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete EmployeePayroll','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeePayroll','url'=>array('admin')),
);
?>

<h1>View EmployeePayroll #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'emp_id',
		'is_pto_eligible',
		'pto_effective_date',
		'fed_expt',
		'fed_add',
		'state_expt',
		'rate_type',
		'rate_proposed',
		'rate_recommended',
		'rate_approved',
		'rate_effective_date',
		'deduc_health_code',
		'deduc_health_amt',
		'deduc_dental_code',
		'deduc_dental_amt',
		'deduc_other_code',
		'deduc_other_amt',
		'is_approved',
		'timestamp',
	),
)); ?>
