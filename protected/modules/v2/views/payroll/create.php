<?php
$this->breadcrumbs=array(
	'Payrolls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Payroll','url'=>array('index')),
	array('label'=>'Manage Payroll','url'=>array('admin')),
);
?>

<h1 class="page-header">Create Payroll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>