<?php
$this->breadcrumbs=array(
	'Tar Alerts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TarAlerts','url'=>array('index')),
	array('label'=>'Create TarAlerts','url'=>array('create')),
	array('label'=>'Update TarAlerts','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TarAlerts','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TarAlerts','url'=>array('admin')),
);
?>

<h1 class="page-header">View TarAlerts #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'data',
		'log_case_id',
		'alerts_tpl_id',
	),
)); ?>
