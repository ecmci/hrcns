<?php
$this->breadcrumbs=array(
	'Departments'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Department','url'=>array('index')),
	array('label'=>'Create Department','url'=>array('create')),
	array('label'=>'Update Department','url'=>array('update','id'=>$model->code)),
	array('label'=>'Delete Department','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->code),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Department','url'=>array('admin')),
);
?>

<h1>View Department #<?php echo $model->code; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'name',
		'description',
	),
)); ?>
