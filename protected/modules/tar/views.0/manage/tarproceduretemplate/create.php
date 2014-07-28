<?php
$this->breadcrumbs=array(
	'Tar Procedure Templates'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List TarProcedureTemplate','url'=>array('index')),
	array('label'=>'Manage Procedure Templates','url'=>array('admin')),
);
?>

<h1 class="page-header">Create TarProcedureTemplate</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>