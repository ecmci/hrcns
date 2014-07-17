<?php
$this->breadcrumbs=array(
	'HR Notice Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage HR Notice Required Documents','url'=>array('admin')),
);
?>

<h1 class="page-header">Create HR Notice Required Document</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>