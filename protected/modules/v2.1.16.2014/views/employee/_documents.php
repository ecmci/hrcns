<?php
$docs = Document::model()->findAll("emp_id = '$emp_id'");
Yii::app()->clientScript->registerScript('DT_bootstrap-documents-js',"
$('#docs').dataTable( {
	\"sDom\": \"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>\"
} );
",CClientScript::POS_READY);
Yii::app()->clientScript->registerCss('_documents-css',"
.attention{
	background-color:red;
}
");
?>
<fieldset><legend>Licenses and Certifications</legend>
	<table id="docs" cellpadding="0" cellspacing="0" border="0" class="table table-condensed">
		<thead>
		<tr>
			<th>Name</th>
			<th>Serial#</th>
			<th>Issued</th>
			<th>Expiration</th>
			<th>File</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($docs as $d): ?>
		<tr <?php echo ($d->isExpired()) ? 'class="alert alert-error"' : ''; ?>>
			<td><?php echo $d->name; ?></th>
			<td><?php echo $d->serial_number; ?></td>
			<td><?php echo App::printDate($d->date_issued); ?></td>
			<td><?php echo App::printDate($d->date_of_expiration); ?></td>
			<td><?php echo empty($d->attachment) ? '<a href="'.Yii::app()->baseUrl.'/uploads/'.$d->attachment.'" title="View File" target="_blank"><i class="icon-file"></i></a>' : ''; ?></td>
			<td><a title="View" target="_blank" title="View" href="<?php echo Yii::app()->createUrl('/license/license/view/id/'.$d->id); ?>"><i class="icon-search"></i></a></td>			
		</tr>
		<?php endforeach; ?>
	</tbody>
	</table>
</fieldset>
