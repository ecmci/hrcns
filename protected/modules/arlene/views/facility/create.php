<?php
$this->breadcrumbs=array(
	'Facilities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Facility','url'=>array('index')),
	array('label'=>'Manage Facility','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Facility</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>