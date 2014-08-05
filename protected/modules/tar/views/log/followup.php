<?php
$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	$model->case_id=>array('view','id'=>$model->case_id),
	'Follow Up',
);

$this->menu=array(
	array('label'=>'Create New Case','url'=>array('create')),
	array('label'=>'Back to List','url'=>array('index')),
);
?>

<h1 class="page-header">Log Activity for TAR Case # <?php echo $model->case_id; ?></h1>

<p class="alert alert-info">
Log any calls, emails and any other activities being done for this TAR.
</p>

<?php $this->renderPartial('_form_followup',array('model'=>$model)); ?>