<?php
$this->breadcrumbs=array(
	'Sys Users'=>array('index'),
	$model->idUSER=>array('view','id'=>$model->idUSER),
	'Update',
);

$this->menu=array(
	array('label'=>'List SysUser','url'=>array('index')),
	array('label'=>'Create SysUser','url'=>array('create')),
	array('label'=>'View SysUser','url'=>array('view','id'=>$model->idUSER)),
	array('label'=>'Manage SysUser','url'=>array('admin')),
);
?>

<h1 class="page-header">Update SysUser <?php echo $model->idUSER; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>