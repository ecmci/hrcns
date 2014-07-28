<?php
$this->breadcrumbs=array(
	'Tar Alerts Templates'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List TarAlertsTemplate','url'=>array('index')),
	array('label'=>'New Alerts Template','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tar-alerts-template-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage Tar Alerts Templates</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tar-alerts-template-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'name',
		//'data_struct',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
