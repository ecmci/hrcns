<?php
$this->breadcrumbs=array(
	'Tar Users'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List TarUser','url'=>array('index')),
	array('label'=>'Back to User List','url'=>array('admin')),
);
?>

<h1 class="page-header">Create TAR User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>