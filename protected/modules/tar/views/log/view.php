<?php
$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	$model->case_id,
);

$this->menu=array(
	array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'Create TarLog','url'=>array('create')),
	array('label'=>'Update TarLog','url'=>array('update','id'=>$model->case_id)),
	array('label'=>'Delete TarLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->case_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TarLog','url'=>array('admin')),
);
?>

<h1 class="page-header">View TarLog #<?php echo $model->case_id; ?></h1>
<pre>
 <?php
  //print_r(CJSON::decode($model->procedures->data));
 ?>
</pre>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'case_id',
		'control_num',
		'resident',
		'medical_num',
		'dx_code',
		'admit_date',
		'type',
		'requested_dos_date_from',
		'requested_dos_date_thru',
		'applied_date',
		'denied_deferred_date',
		'approved_modified_date',
		'backbill_date',
		'aging_amount',
		'notes',
		'is_closed',
		'reason_for_closing',
		'created_timestamp',
		'approved_care_id',
		'status_id',
		'created_by_user_id',
		'facility_id',
		'resident_status',
	),
)); ?>
