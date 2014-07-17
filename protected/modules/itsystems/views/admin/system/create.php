<?php
$this->breadcrumbs=array(
	'Systems'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List System','url'=>array('index')),
	array('label'=>'Manage System','url'=>array('admin')),
);
?>

<h1 class="page-header">Create System</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>