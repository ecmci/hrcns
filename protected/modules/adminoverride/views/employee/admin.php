<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Employee','url'=>array('index')),
	array('label'=>'Create Employee','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employee-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage Employees</h1>

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
	'id'=>'employee-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'emp_id',
		'last_name',
		'first_name',
		'middle_name',
		//'photo',
		
		array(
			'name'=>'active_personal_id',
			'type'=>'raw',
			'value'=>'EmployeeView::profileLink("personal", $data->active_personal_id)',
		),		
		
		array(
			'name'=>'active_employment_id',
			'type'=>'raw',
			'value'=>'EmployeeView::profileLink("employment", $data->active_employment_id)',
		),
		
		array(
			'name'=>'active_payroll_id',
			'type'=>'raw',
			'value'=>'EmployeeView::profileLink("payroll", $data->active_payroll_id)',
		),
		
		array(
			'header'=>'Active Profile',
			'type'=>'raw',
			'value'=>'EmployeeView::profile($data->emp_id)',
		),
		
		//'timestamp',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php
class EmployeeView{
	public static function profileLink($profile, $id){
		return '<a href="'.Yii::app()->createUrl('/adminoverride/'.$profile.'/view/id/'.$id).'" target="_blank">'.$id.'</a>';
	}
	public static function profile($id){
		return '<a href="'.Yii::app()->createUrl('/hr/employee/view/id/'.$id).'" target="_blank">'.$id.'</a>';
	}
}
?>
