<?php
$this->breadcrumbs=array(
	'Carbon Copies'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List CarbonCopy','url'=>array('index')),
	array('label'=>'Manage Carbon Copies','url'=>array('admin')),
);
?>

<h1 class="page-header">Create CarbonCopy</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>