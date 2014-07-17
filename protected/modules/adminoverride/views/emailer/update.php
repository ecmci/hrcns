<?php
$this->breadcrumbs=array(
	'Emailers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Emailer','url'=>array('index')),
	array('label'=>'Create Emailer','url'=>array('create')),
	array('label'=>'View Emailer','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Emailer','url'=>array('admin')),
);
?>

<h1 class="page-header">Update Emailer <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>