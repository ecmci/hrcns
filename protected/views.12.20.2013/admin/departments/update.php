<?php
$this->breadcrumbs=array(
	'Departments'=>array('index'),
	$model->name=>array('view','id'=>$model->code),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Department','url'=>array('index')),
	array('label'=>'Create Department','url'=>array('create')),
	array('label'=>'View Department','url'=>array('view','id'=>$model->code)),
	array('label'=>'Manage Department','url'=>array('admin')),
);
?>

<h1 class="page-header">Update Department <?php echo $model->code; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>