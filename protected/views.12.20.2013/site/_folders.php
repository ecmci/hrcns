<?php
Yii::app()->clientScript->registerScript('folders',"
  $('#folder-change-notice').click(function(){
    $.fn.yiiGridView.update('items-change-notice');
    return false;
  });
");
?>
<fieldset><legend><i class="icon-inbox"></i> Inbox</legend>
  <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'id'=>'folders',
    'encodeLabel'=>false,
    'items'=>array(
        array('label'=>'CHANGE NOTICE'),
        array('label'=>"Change Notice Requests <span id='count_notices' class='badge badge-important'>$noticesForApproval->totalItemCount</span>", 'icon'=>'folder-open', 'url'=>'#', 'active'=>true, 'linkOptions'=>array('id'=>'folder-change-notice')),
        //array('label'=>'REQUISITION'),
        //array('label'=>'Purchase / Service Requests', 'icon'=>'folder-open', 'url'=>'#'),
    ),
    )); ?>
</fieldset>
<fieldset><legend><i class="icon-search"></i> Search</legend>
  <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'encodeLabel'=>false,
    'items'=>array(
        array('label'=>"Search Employees", 'icon'=>'search', 'url'=>array('/hr/employee/admin')),
        array('label'=>"Search Notices", 'icon'=>'search', 'url'=>array('/hr/workflowchangenotice/admin')),        
    ),
    )); ?>
</fieldset>
<fieldset><legend><i class="icon-file"></i> Forms</legend>
  <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'encodeLabel'=>false,
    'items'=>array(
        array('label'=>'CHANGE NOTICE'),
        array('label'=>"New Hire Form", 'icon'=>'plus', 'url'=>array('/hr/employee/create')),
        array('label'=>"New Change Notice Form", 'icon'=>'plus', 'url'=>array('/hr/workflowchangenotice/newforemployee')),
        '---',
        array('label'=>'IT Support'),
        array('label'=>'Request New/Modify Account Form', 'icon'=>'plus', 'url'=>array('/itsystems/request/create')),
        //array('label'=>'New Service Request Form', 'icon'=>'plus', 'url'=>'#'),
        array('label'=>'License Management'),
        array('label'=>'New License Form', 'icon'=>'plus', 'url'=>array('/license/license/create')),
    ),
    )); ?>
</fieldset>