<?php
$this->layout = '//layouts/print';
$dataProvider = $notice->search();
$dataProvider->pagination = false;
Yii::app()->clientScript->registerCss('printreport-css',"
.filter-container{
	display:none;
}
thead th{
	background-color:#000;
	color:#ffffff;
}
");
Yii::app()->clientScript->registerScript('printreport-css',"
window.print();
",CClientScript::POS_READY);
?>
<h1 class="page-title">Change Notices Report</h1>
<h3><?php echo isset($_GET['t']) ? CHtml::encode($_GET['t']) : ''; ?></h3>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'notice-grid',
	'type'=>array('condensed','bordered','striped'),
	'dataProvider'=>$dataProvider,
	'filter'=>$notice,
	'enableSorting' => false,
	'columns'=>array(
		'id',
		array(
			'name'=>'facility',
			'value'=>'$data->facility',
			'filter'=>CHtml::activeDropdownList($notice,'facility',Facility::getList(),array('empty'=>'ALL')),
		),
		
		array(
			'name'=>'employee',
			'value'=>'$data->employee',
			'filter'=>CHtml::activeDropdownList($notice,'employee',Employee::getList(),array('empty'=>'ALL')),
		),
		array(
			'name'=>'notice_type',
			'value'=>'App::printEnum($data->notice_type)',
			'filter'=>CHtml::activeDropdownList($notice,'notice_type',App::enumItem($notice,'notice_type'),array('empty'=>'ALL')),
		),
		
		array(
			'name'=>'notice_sub_type',
			'value'=>'App::printEnum($data->notice_sub_type)',
			'filter'=>CHtml::activeDropdownList($notice,'notice_sub_type',App::enumItem($notice,'notice_sub_type'),array('empty'=>'ALL')),
		),
		
		array(
			'name'=>'effective_date',
			'value'=>'App::printDate($data->effective_date)',
			'filter'=>false,
		),
		
		array(
			'name'=>'status',
			'value'=>'$data->getStatus()',
			'filter'=>CHtml::activeDropdownList($notice,'status',App::enumItem($notice,'status'),array('empty'=>'ALL')),
		),

	),
)); ?>
