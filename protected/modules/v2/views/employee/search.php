<?php

$this->layout = '//layouts/column1';
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Search',
);

$this->menu=array(
	array('label'=>'List Employee','url'=>array('index')),
	array('label'=>'Create Employee','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employee-grid', {
		data: $(this).serialize()
	});
	$('.search-form').slideToggle();
	return false;
});
");
?>

<h1 class="page-header">Search Employees</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$employee,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'employee-grid',
	'dataProvider'=>$employee->search(),
	'filter'=>$employee,
	'columns'=>array(
		'emp_id',
		'last_name',
		'first_name',
		'middle_name',
		array(
			'name'=>'status',
			'value'=>'App::printEnum($data->employment->status)',
			'filter'=>CHtml::activeDropDownList($employee,'status',App::enumItem(new Employment,'status'),array('empty'=>'ALL')),
		),
		array(
			'name'=>'position_code',
			'value'=>'Employment::model()->find("id = ".$data->active_employment_id)->position->name." (".Employment::model()->find("id = ".$data->active_employment_id)->position->job_code.")"',
			'filter'=>CHtml::activeDropDownList($employee,'position_code',Position::getList(),array('empty'=>'ALL')),
		),
		array(
			'name'=>'department_code',
			'value'=>'Employment::model()->find("id = ".$data->active_employment_id)->department->name." (".Employment::model()->find("id = ".$data->active_employment_id)->department->code.")"',
			'filter'=>CHtml::activeDropDownList($employee,'department_code',Department::getList(),array('empty'=>'ALL')),
		),
		array(
			'name'=>'facility_id',
			//'value'=>'$data->employment->facility->title',
			'value'=>'Facility::model()->findByPk($data->employment->facility_id)->title',
			'filter'=>CHtml::activeDropDownList($employee,'facility_id',Facility::getList(),array('empty'=>'ALL')),
		),
		array(
			'name'=>'date_of_hire',
			'value'=>'App::printDate(Employment::model()->find("id = ".$data->active_employment_id)->date_of_hire)',
			'filter'=>false,
		),
		array(
			'name'=>'date_of_termination',
			'value'=>'App::printDate(Employment::model()->find("id = ".$data->active_employment_id)->date_of_termination)',
			'filter'=>false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}'
		),
	),
)); ?>

