<p class="alert alert-info">If available, please fill out the fields needed for each license or certification below. Else, just set the expiration dates to one year from submission of this notice.</p>
<table id="licenses" class="table">
	<thead>
		<th>Name</th>
		<th>Serial #</th>
		<th>Date Issued</th>
		<th>Date Of Expiration</th>
		<th></th>
	</thead>
	<tbody>
		<?php $ls = (!empty($notice->licenses)) ? $notice->licenses : array(); foreach($ls as $i=>$l): ?>
		<tr>
			<td><?php echo CHtml::activeTextField($notice,'licenses['.$i.'][name]',array('class'=>'span12')); ?></td>
			<td><?php echo CHtml::activeTextField($notice,'licenses['.$i.'][serial_number]',array('class'=>'span12')); ?></td>
			<td><?php echo CHtml::activeTextField($notice,'licenses['.$i.'][date_issued]',array('class'=>'span12 datepicker','placeholder'=>'YYYY-MM-DD')); ?></td>
			<td><?php echo CHtml::activeTextField($notice,'licenses['.$i.'][date_of_expiration]',array('required'=>'required', 'class'=>'span12 datepicker','placeholder'=>'YYYY-MM-DD')) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php
Yii::app()->clientScript->registerScript('licenses-js',"
$('#".CHtml::activeId(new Employment,'position_code')."').on('change',getlicenses)
",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('licenses-js',"
function getlicenses(){
	var params = 'p=' + $(this).val();
	var url = '".Yii::app()->createUrl('/v2/positionlicensemap/getmappedlicenses')."';
	$.get(url,params,function(r){
		$('table#licenses tbody').html(r);		
	});
}
",CClientScript::POS_BEGIN);
?>

