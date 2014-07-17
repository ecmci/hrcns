<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Request','url'=>array('index')),
	array('label'=>'Manage Request','url'=>array('admin')),
);
?>

<h1 class="page-header">New Systems Account Request Form</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>



