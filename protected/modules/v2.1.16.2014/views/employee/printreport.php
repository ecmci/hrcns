<?php
$this->layout = '//layouts/print';
$dataProvider = $employee->search();
$dataProvider->pagination = false;
Yii::app()->clientScript->registerCss('printreport-employee-css',"
.filter-container{
	display:none;
}
thead th{
	background-color:#000;
	color:#ffffff;
}
");
Yii::app()->clientScript->registerScript('printreport-employee-js',"
/* window.print(); */
",CClientScript::POS_READY);
?>
<h1 class="page-title">Employee Report</h1>
<h3><?php echo isset($_GET['t']) ? CHtml::encode($_GET['t']) : ''; ?></h3>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'employee-grid',
	'dataProvider'=>$employee->search(),
	'filter'=>$employee,
	'enableSorting'=>false,
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
			'value'=>'$data->employment->position->name." (".$data->employment->position->job_code.")"',
			'filter'=>CHtml::activeDropDownList($employee,'position_code',Position::getList(),array('empty'=>'ALL')),
		),
		array(
			'name'=>'department_code',
			'value'=>'$data->employment->department->name." (".$data->employment->department->code.")"',
			'filter'=>CHtml::activeDropDownList($employee,'department_code',Department::getList(),array('empty'=>'ALL')),
		),
		array(
			'name'=>'facility_id',
			'value'=>'$data->employment->facility->acronym',
			'filter'=>CHtml::activeDropDownList($employee,'department_code',Department::getList(),array('empty'=>'ALL')),
		),
		array(
			'header'=>'Hired',
			'value'=>'App::printDate($data->employment->date_of_hire)',
			'filter'=>CHtml::activeDropDownList($employee,'facility_id',Facility::getList(),array('empty'=>'ALL')),
		),
		array(
			'header'=>'Terminated',
			'value'=>'$data->employment->date_of_termination ? App::printDate($data->employment->date_of_termination) : ""',
			'filter'=>CHtml::activeDropDownList($employee,'facility_id',Facility::getList(),array('empty'=>'ALL')),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}'
		),
	),
)); ?>
