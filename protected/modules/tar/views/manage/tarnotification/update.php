<?php
$this->breadcrumbs=array(
	'Tar Alerts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TarAlerts','url'=>array('index')),
	array('label'=>'Create TarAlerts','url'=>array('create')),
	array('label'=>'View TarAlerts','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TarAlerts','url'=>array('admin')),
);
?>

<h1 class="page-header">Update TarAlerts <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>