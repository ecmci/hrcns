<?php
$this->breadcrumbs=array(
	'Hr Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List HrUser','url'=>array('index')),
	array('label'=>'Create HrUser','url'=>array('create')),
	array('label'=>'Update HrUser','url'=>array('update','id'=>$model->user_id)),
	array('label'=>'Delete HrUser','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HrUser','url'=>array('admin')),
);
?>

<h1>View HrUser #<?php echo $model->user_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'group',
    'can_override_routing:boolean',
		array(
      'name'=>'facility_handled',
      'type'=>'raw',
    ),
	),
)); ?>
