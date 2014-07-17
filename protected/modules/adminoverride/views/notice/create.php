<?php
$this->breadcrumbs=array(
	'Notices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Notice','url'=>array('index')),
	array('label'=>'Manage Notice','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Notice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>