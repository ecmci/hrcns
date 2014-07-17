<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'New Systems Account Request Form','url'=>array('create')),
  array('label'=>'Process','url'=>array('process','id'=>$model->id)),
  array('label'=>'Manage Requests','url'=>array('admin')),
);
?>

<h1 class="page-header"><?php echo $model->type.' '.$model->system->name; ?> Account Request - <small><?php echo $model->status; ?></small></h1>

<?php echo $this->renderPartial('_view',array('model'=>$model)); ?>
