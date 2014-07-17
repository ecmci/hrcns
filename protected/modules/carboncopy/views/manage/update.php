<?php
$this->breadcrumbs=array(
	'Carbon Copies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List CarbonCopy','url'=>array('index')),
	array('label'=>'Create CarbonCopy','url'=>array('create')),
	array('label'=>'View CarbonCopy','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Carbon Copies','url'=>array('admin')),
);
?>

<h1 class="page-header">Update CarbonCopy <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>