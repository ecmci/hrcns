<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->getModule('v2')->assetsPath.'/css/DT_bootstrap.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/jquery.dataTables.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/DT_bootstrap.js');
Yii::app()->clientScript->registerScript('DT_bootstrap-routed-js',"
$('#tbl-routed').dataTable( {
	\"sDom\": \"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>\"
} );
$.extend( $.fn.dataTableExt.oStdClasses, {
    \"sWrapper\": \"dataTables_wrapper form-inline\"
} );
",CClientScript::POS_READY);
Yii::app()->clientScript->registerCss('_routed-css',"
.dataTables_wrapper .row{
	padding-left:30px;
}
");
?>
<table id="tbl-routed" cellpadding="0" cellspacing="0" border="0" class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Facility</th>
			<th>Employee</th>
			<th>Type</th>
			<th>Status</th>
			<th>Received</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($routed as $r): ?>
	<tr <?php echo ($r->needsAttention()) ? 'class="attention"' : ''; ?>>
		<td><?php echo $r->id; ?></td>
		<td><?php echo $r->employment->facility->acronym; ?></td>
		<td><?php echo $r->employment->employee->getFullName(); ?></td>
		<td><?php echo App::printEnum($r->getType()); ?></td>
		<td><?php echo $r->getStatus(); ?></td>
    <?php
     $t = ($r->status == 'NEW') ? $r->timestamp : $r->last_updated_timestamp;
    ?>
		<td><?php echo App::computeInDays($t); ?></td>
		<td><a href="<?php echo Yii::app()->createUrl('v2/notice/review/id/'.$r->id); ?>" title="Review And Sign" class="btn btn-warning"><i class="icon-pencil"></i></a></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
