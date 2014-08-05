<?php
$this->breadcrumbs=array(
	'Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Document','url'=>array('index')),
	array('label'=>'Manage Document','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Document</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>