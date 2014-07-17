<?php
$this->breadcrumbs=array(
	'HR Notice Documents'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create HR Notice Required Document','url'=>array('create')),
	array('label'=>'Manage HR Notice Required Documents','url'=>array('admin')),
);
?>

<h1 class="page-header">Update HR Notice Required Document <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>