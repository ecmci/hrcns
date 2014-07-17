<?php
$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WorkflowChangeNotice','url'=>array('index')),
	array('label'=>'Create WorkflowChangeNotice','url'=>array('create')),
	array('label'=>'Update WorkflowChangeNotice','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete WorkflowChangeNotice','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WorkflowChangeNotice','url'=>array('admin')),
);
?>

<h1 class="page-header">View WorkflowChangeNotice #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'initiated_by',
		'notice_type',
		'status',
		'processing_group',
		'processing_user',
		'profile_id',
		'personal_profile_id',
		'employment_profile_id',
		'payroll_profile_id',
		'bom_id',
		'fac_adm_id',
		'mnl_id',
		'corp_id',
		'timestamp_bom_signed',
		'timestamp_fac_adm_signed',
		'timestamp_mnl_signed',
		'timestamp_corp_signed',
		'decision_bom',
		'decision_fac_adm',
		'decision_mnl',
		'decision_corp',
		'comment_bom',
		'comment_fac_adm',
		'comment_mnl',
		'comment_corp',
		'attachment_bom',
		'attachment_fac_adm',
		'attachment_mnl',
		'attachment_corp',
		'timestamp',
	),
)); ?>
