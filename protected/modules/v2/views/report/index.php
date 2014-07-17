<?php
/* @var $this ReportController */
$this->layout = '//layouts/column1';
$this->breadcrumbs=array(
	'Report',
);
?>
<h1 class="page-title">Reports</h1>

<fieldset><legend>Quick Reports</legend>
	<ul class="nav nav-tabs nav-stacked">
		<li><a class="report-link" href="#" data-link="<?php echo Yii::app()->createUrl('v2/report/view/r/1'); ?>">Union Employees</a></li>
		<li><a class="report-link" href="#" data-link="<?php echo Yii::app()->createUrl('v2/report/view/r/2'); ?>">Employee Birthday</a></li>
	</ul>
</fieldset>

<?php
Yii::app()->clientScript->registerScript('report-index.js',"
$('.report-link').on('click',function(){
	var url = $(this).attr('data-link');
	var title = prompt('Title of this report?');
	window.open(url + '?t=' + title);
	$.preventDefault();
});
",CClientScript::POS_READY);

?>


