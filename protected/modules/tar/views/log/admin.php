<?php
$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'Create TarLog','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tar-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage Tar Logs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tar-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'case_id',
		'control_num',
		'resident',
		'medical_num',
		'dx_code',
		'admit_date',
		/*
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
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
