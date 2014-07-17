<?php
$this->breadcrumbs=array(
	'System Positions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SystemPosition','url'=>array('index')),
	array('label'=>'Create SystemPosition','url'=>array('create')),
	array('label'=>'Update SystemPosition','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SystemPosition','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SystemPosition','url'=>array('admin')),
);
?>

<h1 class="page-header">View SystemPosition #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
    array(
      'name'=>'position_id',
      'value'=>$model->position->name
    ),
		array(
      'name'=>'system_id',
      'type'=>'raw',
      'value'=>$model->getSystemNames()
    ),
	),
)); ?>
