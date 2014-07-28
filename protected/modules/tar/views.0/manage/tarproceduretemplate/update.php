<?php
$this->breadcrumbs=array(
	'Tar Procedure Templates'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TarProcedureTemplate','url'=>array('index')),
	array('label'=>'Create TarProcedureTemplate','url'=>array('create')),
	array('label'=>'View TarProcedureTemplate','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TarProcedureTemplate','url'=>array('admin')),
);
?>

<h1 class="page-header">Update TarProcedureTemplate <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>