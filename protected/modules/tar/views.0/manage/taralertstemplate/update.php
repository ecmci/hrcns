<?php
$this->breadcrumbs=array(
	'Tar Alerts Templates'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TarAlertsTemplate','url'=>array('index')),
	array('label'=>'Create TarAlertsTemplate','url'=>array('create')),
	array('label'=>'View TarAlertsTemplate','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TarAlertsTemplate','url'=>array('admin')),
);
?>

<h1 class="page-header">Update TarAlertsTemplate <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>