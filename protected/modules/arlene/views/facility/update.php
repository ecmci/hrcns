<?php
$this->breadcrumbs=array(
	'Facilities'=>array('index'),
	$model->title=>array('view','id'=>$model->idFACILITY),
	'Update',
);

$this->menu=array(
	array('label'=>'List Facility','url'=>array('index')),
	array('label'=>'Create Facility','url'=>array('create')),
	array('label'=>'View Facility','url'=>array('view','id'=>$model->idFACILITY)),
	array('label'=>'Manage Facility','url'=>array('admin')),
);
?>

<h1 class="page-header">Update Facility <?php echo $model->idFACILITY; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>