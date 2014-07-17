<?php
$this->pageTitle = Yii::app()->name.' | Employee | Print Report';
$this->layout = 'print_preview';
Yii::app()->clientScript->registerScript('print',"
$(document).ready(function(){
  /* window.print(); */
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
  	'id'=>'employee-grid',
  	'dataProvider'=>$employee->search(),
    'type'=>array('condensed','','bordered'),
    'enableSorting'=>false,
    'enablePagination'=>false,
  	'columns'=>array(
      array(
        'name'=>'emp_id',
        'filter'=>false,
      ),
      array(
        'name'=>'name',
        'filter'=>false,
      ),
      array(
        'name'=>'status',
        'filter'=>false,
      ),      
      array(
        'name'=>'position_code', 'filter'=>false,
      ),     
      array(
        'name'=>'facility_id',
        'filter'=>false,
      ),
  ),
  )); ?>
<p class="text-right muted"><small>Generated <?php echo date('Y-m-d H:i:s'); ?> by <?php echo Yii::app()->user->name; ?></small></p>  