<?php
$this->pageTitle = Yii::app()->name.' | '.$notice->notice_type.' Notice | ID '.$notice->id;
$this->layout = 'print_preview';
Yii::app()->clientScript->registerScript('print',"
$(document).ready(function(){
  window.print();
  $('.btn-group').hide();
});
");
Yii::app()->clientScript->registerCss('grid',"
.grid-view{
  padding:0px;
}
.no-border th, .no-border td{
  border-top: 0px solid white;
}
.no-border td{
  width:500px;
}
");

?>
<h1 class=""><?php echo $notice->notice_type; ?> Notice <small>(Effective <?php echo $notice->effective_date; ?>)</small></h1>

<div class="row-fluid">
  <div class="span12">
  <?php $this->renderPartial('_quick_view',array('notice'=>$notice,'print'=>true)); ?>
  </div>
</div>

<div class="row-fluid">
  <div class="span12">  
  <?php $this->renderPartial('_summary_of_changes',array('notice'=>$notice)); ?>
  </div>
</div>

<div class="row-fluid">
  <div class="span12">
  <?php $this->renderPartial('_employee_no_js',array('notice'=>$notice)); ?>
  </div>
</div>

