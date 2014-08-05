<?php
$this->breadcrumbs=array(
	'Payrolls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Payroll','url'=>array('index')),
	array('label'=>'Create Payroll','url'=>array('create')),
	array('label'=>'Update Payroll','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Payroll','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Payroll','url'=>array('admin')),
);
?>

<h1 class="page-header">View Payroll #<?php echo $model->id; ?></h1>

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
		'state_add',
		'rate_type',
		'w4_status',
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
