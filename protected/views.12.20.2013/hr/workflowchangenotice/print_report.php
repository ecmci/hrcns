<?php
$this->pageTitle = Yii::app()->name.' | Workflow | Change Notice Request | Print Report';
$this->layout = 'print_preview';
Yii::app()->clientScript->registerScript('print',"
$(document).ready(function(){
  window.print();
});
");
Yii::app()->clientScript->registerCss('grid',"
.grid-view{
  padding:0px;
}
th{
  background: #EEEEEE;
}
");
?>
<h3 class=""><?php echo $title; ?></h3>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'workflow-change-notice-grid',
	'dataProvider'=>$notice->getActiveRequests(),
	//'filter'=>$notice,
  'type'=>array('condensed','','bordered'),
  'enableSorting'=>false,
  'enablePagination'=>false,
	'columns'=>array(
		array(
      'name'=>'id','filter'=>false,
    ),
    array(
      'name'=>'facility','filter'=>false,
    ),
    array(
      'name'=>'employee','filter'=>false,
    ),
    array(
      'name'=>'position','filter'=>false,
    ),
    array(
      'name'=>'status','filter'=>false,
    ),
    array(
      'name'=>'notice_type','filter'=>false,
    ),
    array(
      'name'=>'processing_group','filter'=>false,
    ),
    array(
      'name'=>'effective_date','filter'=>false,
    ),
    array(
      'name'=>'comments','value'=>'$data->getAllComments()','filter'=>false,'type'=>'raw',
    ),
     array(
      'name'=>'timestamp','filter'=>false,'header'=>'Date Requested',
    ),
	),
)); ?>
<p class="text-right muted"><small>Generated <?php echo date('Y-m-d H:i:s'); ?> by <?php echo Yii::app()->user->name; ?></small></p>
