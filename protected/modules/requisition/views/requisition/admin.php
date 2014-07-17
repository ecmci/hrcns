<?php
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'New Purchase Request Form'), 'url'=>array('createpo')),
		array('label'=>Yii::t('app', 'New Service Request Form'), 'url'=>array('createso')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('requisition-grid', {
		data: $(this).serialize()
	});
	return false;
});
$(document).ready(function(){
	$('.search-form').hide();
});
");
?>

<h1 class="page-header"><?php echo Yii::t('app', 'Facility') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search_bootstrapped', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<style type="text/css">
	.row_urgent{background:#FF8B73;}
</style>
<?php $user = $user = User::model()->findByPk(Yii::app()->user->getState('id')); ?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'requisition-grid',
	'dataProvider' => $model->search(),
	'htmlOptions'=>array('style'=>'cursor: pointer;','class'=>'table table-condensed table-striped'),
	'selectionChanged'=>"function(id){window.location='" . Yii::app()->urlManager->createUrl('requisition/requisition/view/', array('id'=>'')) . "/' + $.fn.yiiGridView.getSelection(id);}",
	'rowCssClassExpression'=>'($data->PRIORITY_idPRIORITY==\'1\' and $data->STATUS_idSTATUS!=\'11\') ? \'row_urgent\' : \'normal\'', //hard coded id for High Priority from priority table
	'filter' => $model,
	'columns' => array(
		//'idREQUISITION',
    array(
      'name'=>'idREQUISITION',
      'filter'=>CHtml::activeTextField($model,'idREQUISITION',array('class'=>'span12')),
    ),
		array(
				'name'=>'FACILITY_idFACILITY',
				'value'=>'GxHtml::valueEx($data->fACILITYIdFACILITY)',
        'filter'=>CHtml::activeDropDownList($model,'FACILITY_idFACILITY',CHtml::listData($user->myFacilities, 'idFACILITY', 'title'),array('empty'=>'ALL','class'=>'span12')),
				//'filter'=>CHtml::listData($user->myFacilities, 'idFACILITY', 'title'),
				),
		//'date_posted',
    array(
      'name'=>'date_posted',
      'filter'=>false,
    ),
		array(
				'name'=>'STATUS_idSTATUS',
				'value'=>'GxHtml::valueEx($data->sTATUSIdSTATUS)',
				//'filter'=>GxHtml::listDataEx(Status::model()->findAllAttributes(null, true),array('empty'=>'ALL','class'=>'span12')),
        'filter'=>CHtml::activeDropDownList($model,'STATUS_idSTATUS',CHtml::listData(Status::model()->findAllAttributes(null, true),'idSTATUS','title'),array('empty'=>'ALL','class'=>'span12')),
				),

    array(
      'name'=>'title',
      'filter'=>CHtml::activeTextField($model,'title',array('class'=>'span12')),
    ),
		/*
		array(
			'class' => 'CButtonColumn',
		),
		*/
	),
)); ?>

