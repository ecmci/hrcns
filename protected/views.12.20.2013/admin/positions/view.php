<?php
$this->breadcrumbs=array(
	'Positions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Position','url'=>array('index')),
	array('label'=>'Create Position','url'=>array('create')),
	array('label'=>'Update Position','url'=>array('update','id'=>$model->code)),
	array('label'=>'Delete Position','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->code),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Position','url'=>array('admin')),
);
?>

<h1 class="page-header">View Position #<?php echo $model->code; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'name',
		'job_code',
		'dept_code',
		'job_description',
	),
)); ?>
