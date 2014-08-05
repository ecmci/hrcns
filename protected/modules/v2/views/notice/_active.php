<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->getModule('v2')->assetsPath.'/css/DT_bootstrap.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/jquery.dataTables.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/DT_bootstrap.js');
Yii::app()->clientScript->registerScript('DT_bootstrap-active-js',"
$('#tbl-active').dataTable( {
	\"sDom\": \"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>\"
} );
$.extend( $.fn.dataTableExt.oStdClasses, {
    \"sWrapper\": \"dataTables_wrapper form-inline\"
} );
",CClientScript::POS_READY);
Yii::app()->clientScript->registerCss('_active-css',"
.dataTables_wrapper .row{
	padding-left:30px;
}

");
?>
<table id="tbl-active" cellpadding="0" cellspacing="0" border="0" class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Facility</th>
			<th>Employee</th>
			<th>Type</th>
			<th>Status</th>
			<th>Created</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($active as $a): ?>
	<tr <?php echo ($a->needsAttention()) ? 'class="attention"' : ''; ?>>
		<td><?php echo $a->id; ?></td>
		<td><?php echo $a->employment->facility->acronym; ?></td>
		<td><?php echo $a->employment->employee->getFullName(); ?></td>
		<td><?php echo App::printEnum($a->getType()); ?></td>
		<td><?php echo $a->getStatus(); ?></td>
		<td><?php echo App::computeInDays($a->timestamp); ?></td>
		<td><a href="<?php echo Yii::app()->createUrl('v2/notice/review/id/'.$a->id); ?>" title="View" class="btn"><i class="icon-search"></i></a></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
