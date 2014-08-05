<?php
$this->breadcrumbs=array(
	'Tar Procedure Templates'=>array('index'),
	$model->name,
);


$this->menu=array(
	//array('label'=>'List TarProcedureTemplate','url'=>array('index')),
	array('label'=>'Create New Procedure Template','url'=>array('create')),
	//array('label'=>'Update TarProcedureTemplate','url'=>array('update','id'=>$model->id)),
	//array('label'=>'Delete TarProcedureTemplate','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Procedure Templates','url'=>array('admin')),
);

?>

<h1 class="page-header">View TarProcedureTemplate # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'edit'=>'1')); ?>


