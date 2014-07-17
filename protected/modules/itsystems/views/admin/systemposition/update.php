<?php
$this->breadcrumbs=array(
	'System Positions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SystemPosition','url'=>array('index')),
	array('label'=>'Create SystemPosition','url'=>array('create')),
	array('label'=>'View SystemPosition','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SystemPosition','url'=>array('admin')),
);
?>

<h1 class="page-header">Update SystemPosition <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>