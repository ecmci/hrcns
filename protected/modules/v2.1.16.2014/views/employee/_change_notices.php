<?php
$notices = Notice::getHistory($emp_id);
Yii::app()->clientScript->registerScript('DT_bootstrap-change-notices-js',"
$('#notices').dataTable( {
	\"sDom\": \"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>\"
} );
",CClientScript::POS_READY);
?>
<fieldset><legend>Change Notices</legend>
<table id="notices" cellpadding="0" cellspacing="0" border="0" class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Type</th>
			<th>Status</th>
			<th>Effective Date</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($notices->getData() as $n): ?>
		<tr>
			<td><?php echo $n->id; ?></td>
			<td><?php echo App::printEnum($n->getType()); ?></td>
			<td><?php echo $n->getStatus(); ?></td>
			<td><?php echo App::printDate($n->effective_date); ?></td>
			<td><a target="_blank" title="View" href="<?php echo Yii::app()->createUrl('/v2/notice/review/id/'.$n->id); ?>"><i class="icon-search"></i></a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</fieldset>
