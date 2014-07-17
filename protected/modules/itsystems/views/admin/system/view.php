<?php
$this->breadcrumbs=array(
	'Systems'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List System','url'=>array('index')),
	array('label'=>'Create System','url'=>array('create')),
	array('label'=>'Update System','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete System','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage System','url'=>array('admin')),
);
?>

<h1 class="page-header">View System #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
