<?php
$accts = ITAccounts::model()->findAll("employee_id = '$emp_id'");
Yii::app()->clientScript->registerScript('DT_bootstrap-itaccts-js',"
$('#accts').dataTable( {
	\"sDom\": \"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>\"
} );
",CClientScript::POS_READY);
?>
<fieldset><legend>Licenses and Certifications</legend>
	<table id="accts" cellpadding="0" cellspacing="0" border="0" class="table table-condensed table-striped">
		<thead>
		<tr>
			<th>System</th>
			<th>Status</th>
			<th>Request</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($accts as $a): ?>
		<tr>			
			<td><?php echo $a->system->name; ?></td>
			<td><?php echo App::printEnum($a->status); ?></td>
			<td><?php echo App::printEnum($a->type); ?></td>
			<td><a title="View" target="_blank" title="View" href="<?php echo Yii::app()->createUrl('/itsystems/request/view/id/'.$a->id); ?>"><i class="icon-search"></i></a></td>			
		</tr>
		<?php endforeach; ?>
	</tbody>
	</table>
</fieldset>
