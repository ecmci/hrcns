<?php
$this->breadcrumbs=array(
	'Departments'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Department','url'=>array('index')),
	array('label'=>'Manage Department','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Department</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>