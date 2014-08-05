<?php
$this->breadcrumbs=array(
	'Tar Alerts Templates'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List TarAlertsTemplate','url'=>array('index')),
	array('label'=>'Manage Alerts Template','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Alerts Template</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>