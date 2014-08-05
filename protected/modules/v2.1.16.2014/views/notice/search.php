<?php
$this->layout = '//layouts/column1';

$this->breadcrumbs=array(
	'Notices'=>array('index'),
	'Search',
);

$this->menu=array(
	array('label'=>'List Notice','url'=>array('index')),
	array('label'=>'Create Notice','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('notice-grid', {
		data: $(this).serialize()
	});
	$('.search-form').slideToggle();
	return false;
});
");
?>

<h1 class="page-header">Search Notices</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$notice,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'notice-grid',
	'dataProvider'=>$notice->search(),
	'filter'=>$notice,
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
			'value'=>'App::printEnum($data->status)',
			'filter'=>CHtml::activeDropdownList($notice,'status',App::enumItem($notice,'status'),array('empty'=>'ALL')),
		),
		
		array(
			'name'=>'processing_group',
			'value'=>'App::printEnum($data->processing_group)',
			'filter'=>CHtml::activeDropdownList($notice,'processing_group',App::enumItem($notice,'processing_group'),array('empty'=>'ALL')),
		),
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>

