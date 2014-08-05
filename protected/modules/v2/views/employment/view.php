<?php
$this->breadcrumbs=array(
	'Employments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Employment','url'=>array('index')),
	array('label'=>'Create Employment','url'=>array('create')),
	array('label'=>'Update Employment','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Employment','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Employment','url'=>array('admin')),
);
?>

<h1 class="page-header">View Employment #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'emp_id',
		'facility_id',
		'status',
		'date_of_hire',
		'date_of_termination',
		'department_code',
		'position_code',
		'start_date',
		'end_date',
		'contract_file',
		'has_union',
		'reports_to',
		'is_approved',
		'timestamp',
	),
)); ?>
