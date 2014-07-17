<?php
//$this->layout = 'column1';
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Employee','url'=>array('index')),
	//array('label'=>'Create Employee','url'=>array('create')),
  array('label'=>'New Hire Form','url'=>array('create'),'icon'=>'icon-plus'),
  //array('label'=>'Print Preview','url'=>array('printreport'),'icon'=>'icon-print','linkOptions'=>array('id'=>'print-preview')),
);

Yii::app()->clientScript->registerScript('search-begin', "
$('.search-form').show();
", CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('employee-grid', {
        data: $(this).serialize()
    });
    window.location = '#result';
    return false;
});
");
?>
<h1 class="page-header">Research Employees</h1>
<div class="row-fluid">
  <div class="span12">
    <?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
    <div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
    	'model'=>$model,
    )); ?>
    </div><!-- search-form -->         
  </div>
</div>
<div class="row-fluid" id="result">
  <div class="span10">
  <?php $this->widget('bootstrap.widgets.TbGridView',array(
  	'id'=>'employee-grid',
    //'enableHistory'=>true,
  	'dataProvider'=>$model->search(),
  	'filter'=>$model,
    'htmlOptions'=>array(
      'class'=>'table table-hover table-condensed',
    ),
  	'columns'=>array(
  		array(
        'name'=>'photo',
        'type'=>'raw',
        'value'=>array($model,'renderGridPhoto'),
        'filter'=>false,
        'htmlOptions'=>array(
          'style'=>'width:10px;'
        ),
      ),
      //'name',
      
      array(
        'name'=>'last_name',
        'filter'=>CHtml::activeTextField($model,'last_name',array('class'=>'')),
      ),
      
      array(
        'name'=>'first_name',
        'filter'=>CHtml::activeTextField($model,'first_name',array('class'=>'')),
      ),
      array(
        'name'=>'emp_id',
        'filter'=>CHtml::activeTextField($model,'emp_id',array('class'=>'input-small')),
      ),
   
//       array(
//         'name'=>'employmentProfile.status',
//         'filter'=>CHtml::activeDropDownList($model,'status',ZHtml::enumItem(new EmployeeEmployment, 'status' ),array('empty'=>'-ALL-')),
//       ),    
      
      array(
        'name'=>'position_code',
        'value'=>'$data->employmentProfile ? $data->employmentProfile->positionCode->name : ""',
        'filter'=>CHtml::activeDropDownList($model,'position_code',Position::getList(),array('empty'=>'-ALL-','class'=>'input input-medium')),
      ),
      
      array(
        'name'=>'employmentProfile.facility',
        'filter'=>CHtml::activeDropDownList($model,'facility_id',Facility::getList(),array('empty'=>'-ALL-')),
      ),
      
      //'has_active_change_notice:boolean',
      array(
        'header'=>'Actions',
        'value'=>array($this,'renderGridviewButtonColumn'),       
      ),
  ),
  )); ?>
  </div>
  <div class="span2"></div> 
</div>


