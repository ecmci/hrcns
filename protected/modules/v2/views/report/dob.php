<?php 

$this->layout = '//layouts/print';
$this->breadcrumbs=array(
	'Reports'=>array('index'),
	'Birthday Report',
);
Yii::app()->clientScript->registerCss('printreport-css',"
.filter-container{
	display:none;
}
thead th{
	background-color:#000;
	color:#ffffff;
}
");
?>
<h1 class="page-title">Birthday Report <?php echo date('Y',time()); ?></h1>
<h2><?php echo isset($_GET['t']) ? CHtml::encode($_GET['t']) : '';  ?></h2>
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>Month</th>
			<th>Birthdays</th>
		</tr>
	</thead>
	<tbody>
		<?php for($month = 1; $month <= 12; $month++): $monthName = date("F", mktime(0, 0, 0, $month, 10));  ?>
		<tr>
			<td><?php echo $monthName;  ?></td>
			<td>
				<table class="table">
					<tr>
						<th>Employee</th>
						<th>Birth Date</th>
					</tr>
					<?php
						$bdays = Report::getEmployeeBirthday($month);
						foreach($bdays->getData() as $b):
					?>
					<tr>
						<td style="width:50%;"><?php echo $b['first_name'].' '.$b['last_name']; ?></td>
						<td><?php echo App::printDate($b['birthdate']); ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</td>
		</tr>
		<?php endfor; ?>
	</tbody>
</table>
