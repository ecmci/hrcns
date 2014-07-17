<table class="table table-bordered">
	<tbody>
        <tr>
            <td colspan="5">
                <p><small><strong>Employee</strong></small></p>
				<p><h4><?php echo $employee->getFullName(); ?></h4></p>    
            </td>
        </tr>
		<tr>
			<td>
				<p><small><strong>Employee ID</strong></small></p>
				<p><?php echo $employee->emp_id; ?></p>
			</td>
			<td>
				<p><small><strong>Employment Status</strong></small></p>
				<p><?php echo App::printEnum($employment->status); ?></p>
			</td>
			<td>
				<p><small><strong>Position</strong></small></p>
				<p><?php echo $employment->position->name; ?> <br><small>(<?php echo $employment->position->job_code; ?>)</small></p>
			</td>
			<td>
				<p><small><strong>Department</strong></small></p>
				<p><?php echo $employment->department->name; ?> <br><small>(<?php echo $employment->department->code; ?>)</small></p>
			</td>
			<td>
				<p><small><strong>Facility</strong></small></p>
				<p><?php echo $employment->facility->title; ?></p>
			</td>
		</tr>
		
		<tr>
			<td>
				<p><small><strong>Hire Date</strong></small></p>
				<p><?php echo App::printDate($employment->date_of_hire); ?></p>
			</td>
			<td>
				<p><small><strong>Termination Date</strong></small></p>
				<p><?php echo App::printDate($employment->date_of_termination); ?></p>
			</td>
			<td>
				<p><small><strong>Rate</strong></small></p>
				<p><strong>Approved: $ <?php echo $payroll->rate_approved; ?> / <?php echo $payroll->rate_type;  ?> <br><small>(Effective <?php echo App::printDate($payroll->rate_effective_date);  ?>)</small></strong></p>
                <p>Proposed: $ <?php echo $payroll->rate_proposed; ?> / <?php echo $payroll->rate_type;  ?></p>
			</td>
			<td>
				<p><small><strong>PTO</strong></small></p>
				<p><?php echo $payroll->is_pto_eligible == '1' ? 'Yes' : 'No'; ?> <br><small>(Effective <?php echo App::printDate($payroll->pto_effective_date);  ?>)</small></p>
			</td>
			<td>
				<p><small><strong>Union</strong></small></p>
				<p><?php echo $employment->has_union == '1' ? 'Yes' : 'No';  ?> <small></small></p>
			</td>
		</tr>
    
		<tr>
			<td>
				<p><small><strong>Address and Contact</strong></small></p>
				<p>
					<address>
					  <?php echo $personal->street;  ?><br>
					  <?php echo $personal->city;  ?>, <?php echo $personal->state;  ?> <?php echo $personal->zip_code;  ?><br>
					  <i class="glyphicon glyphicon-earphone"></i> Phone: <?php echo $personal->telephone;  ?><br>
					  <i class="glyphicon glyphicon-phone"></i> Cell: <?php echo $personal->cellphone;  ?><br>
					  <i class="glyphicon glyphicon-envelope"></i> Email: <?php echo $personal->email;  ?>
					</address>
				</p>
			</td>
			<td>
				<p><small><strong>Date of Birth</strong></small></p>
				<p><?php echo $personal->dob;  ?></p>
			</td>
			<td>
				<p><small><strong>SSN</strong></small></p>
				<p><?php echo $personal->_ssn;  ?></p>
			</td>
			<td>
				<p><small><strong>W4 Status</strong></small></p>
				<p><?php echo App::printEnum($payroll->w4_status);  ?></p>
			</td>
			<td>
				<p><small><strong>Gender</strong></small></p>
				<p><?php echo $personal->gender;  ?></p>
			</td>
		</tr>
	</tbody>
</table>
