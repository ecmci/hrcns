<?php
$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'Manage TarLog','url'=>array('admin')),
);
?>

<h1 class="page-header">Create TarLog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>