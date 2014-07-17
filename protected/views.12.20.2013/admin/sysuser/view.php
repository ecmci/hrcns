<?php
$this->breadcrumbs=array(
	'Sys Users'=>array('index'),
	$model->idUSER,
);

$this->menu=array(
	array('label'=>'List SysUser','url'=>array('index')),
	array('label'=>'Create SysUser','url'=>array('create')),
	array('label'=>'Update SysUser','url'=>array('update','id'=>$model->idUSER)),
	array('label'=>'Delete SysUser','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->idUSER),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SysUser','url'=>array('admin')),
);
?>

<h1 class="page-header">View SysUser #<?php echo $model->idUSER; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'idUSER',
		'username',
		'password',
		'f_name',
		'l_name',
		'm_name',
		'active',
	),
)); ?>
