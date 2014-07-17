<?php
$this->breadcrumbs=array(
	'System Positions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SystemPosition','url'=>array('index')),
	array('label'=>'Manage SystemPosition','url'=>array('admin')),
);
?>

<h1 class="page-header">Create SystemPosition</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>