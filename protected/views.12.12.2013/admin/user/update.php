<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->idUSER=>array('view','id'=>$model->idUSER),
	'Update',
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create')),
	array('label'=>'View User','url'=>array('view','id'=>$model->idUSER)),
	array('label'=>'Manage User','url'=>array('admin')),
);
?>

<h1 class="page-header">Update User <?php echo $model->idUSER; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>