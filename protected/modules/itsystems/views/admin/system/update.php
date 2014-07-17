<?php
$this->breadcrumbs=array(
	'Systems'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List System','url'=>array('index')),
	array('label'=>'Create System','url'=>array('create')),
	array('label'=>'View System','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage System','url'=>array('admin')),
);
?>

<h1 class="page-header">Update System <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>