<h1 class="page-header">TAR Report</h1>
<div class="row-fluid">
  <div class="span10">
  <?php
   include '_report_tar_aging_amount_trend.php';
  ?>
  </div>
  <div class="span2">
  <?php
   include '_report_tar_top5_unapproved.php';
  ?>
  </div>
</div>
<div class="row-fluid">
  <div class="span6">
  <?php
   include '_report_tar_trend.php';
  ?> 
  </div>
  <div class="span6">
  <?php
   include '_report_tar_pie.php';
  ?> 
  </div> 
</div>

<div class="row-fluid">
  <div class="span12">
  <?php
   include '_report_tar_list.php';
  ?>
  </div>
</div>
<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(
	Yii::app()->clientScript->getCoreScriptUrl().
	'/jui/css/base/jquery-ui.css'
);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.flot.min.js'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.flot.symbol.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.flot.axislabels.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.flot.time.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.flot.pie.min.js');
Yii::app()->clientScript->registerScript('report-ready-js',"
$('.datepicker').datepicker();
",CClientScript::POS_READY);  
?>