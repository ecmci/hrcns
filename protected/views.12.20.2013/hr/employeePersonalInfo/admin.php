<?php
$this->breadcrumbs=array(
	'Employee Personal Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EmployeePersonalInfo','url'=>array('index')),
	array('label'=>'Create EmployeePersonalInfo','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employee-personal-info-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Employee Personal Infos</h1>

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
	'id'=>'employee-personal-info-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'emp_id',
		'facility_id',
		'birthdate',
		'gender',
		'marital_status',
		/*
		'SSN',
		'number',
		'building',
		'street',
		'zip_code',
		'telephone',
		'cellphone',
		'email',
		'is_approved',
		'timestamp',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
