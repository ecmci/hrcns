<?php
$routed = $model->getRouted()->getData();
$active = $model->getActive()->getData();
?>
<h1 class="page-header"><i class="icon icon-tasks"></i> Notices <span class="badge badge-important"><?php echo (sizeof($routed) + sizeof($active)); ?></span></h1>
<table class="table table-condensed table-hover">
<tr><th></th><th>ID</th><th>Facility</th><th>Employee</th><th>Notice</th><th>Status</th><th>Received</th></tr>
<tr><td colspan="7"><h4 class="muted">Waiting On You <span class="badge badge-important"><?php echo sizeof($routed); ?></span></h4></td></tr>
<?php foreach($routed as $d): ?>
<tr <?php echo ($d->needsAttention()) ? 'class="attention"' : ''; ?>>
	<td><?php echo ActiveView::renderActiveActions($d); ?></td>
	<td><?php echo $d->id; ?></td>
	<td><?php echo $d->employment->facility->acronym; ?></td>
	<td><?php echo $d->employment->employee->getFullName(); ?></td>
	<td><?php echo App::printEnum($d->getType()); ?></td>
	<td><?php echo $d->getStatus(); ?></td>
	<td><?php echo $d->getReceived(); ?></td>	
</tr>
<?php endforeach; ?>
<tr><td colspan="7"><h4 class="muted">Active <span class="badge badge-important"><?php echo sizeof($active); ?></span></h4></td></tr>
<tr><th></th><th>ID</th><th>Facility</th><th>Employee</th><th>Notice</th><th>Status</th><th>Submitted</th></tr>
<?php foreach($active as $d): ?>
<tr <?php echo ($d->needsAttention()) ? 'class="attention"' : ''; ?>>
	<td><?php echo ActiveView::renderActiveActions($d); ?></td>
	<td><?php echo $d->id; ?></td>
	<td><?php echo $d->employment->facility->acronym; ?></td>
	<td><?php echo $d->employment->employee->getFullName(); ?></td>
	<td><?php echo App::printEnum($d->getType()); ?></td>
	<td><?php echo $d->getStatus(); ?></td>
	<td><?php echo App::computeInDays($d->timestamp); ?></td>	
</tr>
<?php endforeach; ?>
</table>


<?php
/*
 * Helper class for active view
 * 
 */  
 class ActiveView{
	/**
	 * Returns status in human form
	 */
	public static function renderActiveActions($model){
		$icon = ($model->processing_group === Yii::app()->user->getState('hr_group')) ? 'pencil' : 'eye-open';
		$title = ($model->processing_group === Yii::app()->user->getState('hr_group')) ? 'Review and Sign' : 'View';
		$btn_type = ($model->processing_group === Yii::app()->user->getState('hr_group')) ? 'warning' : 'default';
    $a = '
		<a class="btn btn-mini btn-'.$btn_type.'" href="'.Yii::app()->createUrl('v2/notice/review/id/'.$model->id).'" title="'.$title.'"><i class="icon icon-'.$icon.'"></i></a> 
		';
		return $a;
	} 
}

Yii::app()->clientScript->registerCss('active-css',"
tr.attention{
	color:#FF1300;
}
");

?>

<br/>
