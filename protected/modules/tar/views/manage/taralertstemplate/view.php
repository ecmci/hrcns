<?php
$this->breadcrumbs=array(
	'Tar Alerts Templates'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List TarAlertsTemplate','url'=>array('index')),
	array('label'=>'New Alerts Template','url'=>array('create')),
	//array('label'=>'Update TarAlertsTemplate','url'=>array('update','id'=>$model->id)),
	//array('label'=>'Delete TarAlertsTemplate','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Alerts Template','url'=>array('admin')),
);
?>

<h1 class="page-header">View TarAlertsTemplate #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'edit'=>true)); ?>
