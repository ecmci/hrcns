<?php
$this->breadcrumbs=array(
	'Employments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Employment','url'=>array('index')),
	array('label'=>'Manage Employment','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Employment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>