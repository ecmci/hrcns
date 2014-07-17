<?php
$this->breadcrumbs=array(
	'Hr Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HrUser','url'=>array('index')),
	array('label'=>'Manage HrUser','url'=>array('admin')),
);
?>

<h1 class="page-header">Create HrUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>