<?php
$this->breadcrumbs=array(
	'Tar Alerts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TarAlerts','url'=>array('index')),
	array('label'=>'Manage TarAlerts','url'=>array('admin')),
);
?>

<h1 class="page-header">Create TarAlerts</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>