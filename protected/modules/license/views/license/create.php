<?php
$this->breadcrumbs=array(
	'Licenses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List License','url'=>array('index')),
	array('label'=>'Manage License','url'=>array('admin')),
);
?>

<h1 class="page-header">Create License</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>