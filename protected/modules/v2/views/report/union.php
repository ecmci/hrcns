<?php $this->layout = '//layouts/print';
$this->breadcrumbs=array(
	'Reports'=>array('index'),
	'Union Employee Report',
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
<h1 class="page-title">Union Employees</h1>
<h2><?php echo isset($_GET['t']) ? CHtml::encode($_GET['t']) : '';  ?></h2>
<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>Employee Name</th>
			<th>Address</th>
			<th>Phone</th>
			<th>SSN</th>
			<th>DOH</th>
			<th>Rate</th>
			<th>Status</th>
			<th>Position</th>
			<th>DOB</th>
			<th>Employee ID</th>
			<th>Gender</th>
			<th>Department</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($dataProvider->getData() as $d):  ?>
		<tr>
			<td><?php echo $d['last_name'].', '.$d['first_name']; ?></td>
			<td><?php echo $d['street'].'<br>'.$d['city'].', '.$d['state'].' '.$d['zip_code']; ?></td>
			<td><?php echo $d['telephone']; ?></td>
			<td><?php echo $d['SSN']; ?></td>
			<td><?php echo App::printDate($d['date_of_hire']); ?></td>
			<td><?php echo '$ '.$d['rate_approved']; ?></td>
			<td><?php echo App::printEnum($d['status']); ?></td>
			<td><?php echo $d['position']; ?></td>
			<td><?php echo App::printDate($d['birthdate']); ?></td>
			<td><?php echo $d['emp_id']; ?></td>
			<td><?php echo $d['gender']; ?></td>
			<td><?php echo $d['department']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<br>

