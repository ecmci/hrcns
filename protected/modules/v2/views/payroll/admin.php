<?php
$this->breadcrumbs=array(
	'Payrolls'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Payroll','url'=>array('index')),
	array('label'=>'Create Payroll','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('payroll-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage Payrolls</h1>

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
	'id'=>'payroll-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'emp_id',
		'is_pto_eligible',
		'pto_effective_date',
		'fed_expt',
		'fed_add',
		/*
		'state_expt',
		'state_add',
		'rate_type',
		'w4_status',
		'rate_proposed',
		'rate_recommended',
		'rate_approved',
		'rate_effective_date',
		'deduc_health_code',
		'deduc_health_amt',
		'deduc_dental_code',
		'deduc_dental_amt',
		'deduc_other_code',
		'deduc_other_amt',
		'is_approved',
		'timestamp',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
