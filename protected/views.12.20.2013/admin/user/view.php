<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->idUSER,
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create')),
	array('label'=>'Update User','url'=>array('update','id'=>$model->idUSER)),
	array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->idUSER),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User','url'=>array('admin')),
);
?>

<h1 class="page-header">View User #<?php echo $model->idUSER; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'idUSER',
		'username',
		'password',
		'f_name',
		'l_name',
		'm_name',
		'GROUP_idGROUP',
		'FACILITY_idFACILITY',
	),
)); ?>
