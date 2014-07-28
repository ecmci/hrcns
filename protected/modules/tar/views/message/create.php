<?php
$this->breadcrumbs=array(
	'Tar Messagings'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List TarMessaging','url'=>array('index')),
	array('label'=>'Back to Message Center','url'=>array('admin')),
);
?>

<h1 class="page-header">New Message</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>