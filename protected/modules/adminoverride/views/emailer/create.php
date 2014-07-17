<?php
$this->breadcrumbs=array(
	'Emailers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Emailer','url'=>array('index')),
	array('label'=>'Manage Emailer','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Emailer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>