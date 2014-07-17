<?php
$this->breadcrumbs=array(
	'Notices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Notice','url'=>array('index')),
	array('label'=>'Create Notice','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('notice-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage Notices</h1>

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
	'id'=>'notice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'notice_type',
		'notice_sub_type',
		'status',
		'processing_group',
		/*
		'initiated_by',		
		'summary_of_changes',
		'reason',				
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
		'attachments',
		'attachment_bom',
		'attachment_fac_adm',
		'attachment_mnl',
		'attachment_corp',
		'effective_date',
		'timestamp',
		'last_updated_timestamp',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
