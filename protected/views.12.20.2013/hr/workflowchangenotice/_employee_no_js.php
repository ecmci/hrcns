<fieldset><legend>Basic Information</legend>
<table class="detail-view no-border table table-condensed" id="employee-personal">
<tbody>
<tr>
<th>Employee ID</th><td><?php $basic = $notice->getProposedBasic(); echo $basic->emp_id; ?></td>
</tr>
<tr>
    <th>Full Name</th><td><?php echo $basic->getFullName(); ?></td>
</tr>
<tr>
    <th>Last Updated</th><td><?php echo $basic->timestamp; ?></td><th></th><td></td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset><legend>Personal Information</legend>
<table id="employee-personal" class="detail-view no-border table table-condensed">
<tbody>
<tr>
    <th>Birthdate</th><td><?php $personal = $notice->personalProfile; echo $personal->birthdate; ?></td><th>Gender</th><td><?php echo $personal->gender; ?></td>
</tr>
<tr>
    <th>Marital Status</th><td><?php echo $personal->marital_status; ?></td><th>Social Security #</th><td><?php echo $personal->SSN; ?></td>
</tr>
<tr>
    <th>Address</th><td><?php echo $personal->number.' '.$personal->building.' '.$personal->street.' '.$personal->city.' '.$personal->state.' '.$personal->zip_code; ?></td><th>Email</th><td><?php echo $personal->email; ?></td>
</tr>
<tr>
    <th>Telephone</th><td><?php echo $personal->telephone; ?></td><th>Cellphone</th><td colspan="2"><?php echo $personal->cellphone; ?></td>
</tr>
<tr>
    <th>Approved Profile?</th><td><?php echo $personal->is_approved == '1' ? 'Yes' : 'No'; ?></td><th>Last Updated</th><td><?php echo $personal->timestamp; ?></td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset><legend>Employment Information</legend>
<table id="employee-personal" class="detail-view no-border table table-condensed">
<tbody>
<tr>
    <th>Status</th><td><?php $employment = $notice->employmentProfile; echo $employment->status; ?></td><th>Facility</th><td><?php echo $employment->facility; ?></td>
</tr>
<tr>
    <th>Hire Date</th><td><?php echo $employment->date_of_hire; ?></td><th>Start Date</th><td><?php echo $employment->start_date; ?></td>
</tr>
<tr>
    <th>Termination Date</th><td><?php echo $employment->date_of_termination; ?></td><th>End Date</th><td><?php echo $employment->end_date; ?></td>
</tr>
<tr>
    <th>Contract</th><td><?php echo CHtml::link($employment->contract_file,Yii::app()->baseUrl.'/images/employee/file/'.$employment->contract_file); ?></td><th>Has Union</th><td><?php echo $employment->has_union == '1' ? 'Yes' : 'No'; ?></td>
</tr>
<tr>
    <th>Approved Profile?</th><td><?php echo $employment->is_approved == '1' ? 'Yes' : 'No'; ?></td><th>Last Updated</th><td><?php echo $employment->timestamp; ?></td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset><legend>Payroll Information</legend>
<table id="employee-personal" class="detail-view no-border table table-condensed">
<tbody>
<tr>
    <th>Rate Type</th><td><?php $payroll = $notice->payrollProfile; echo $payroll->rate_type; ?></td><th>W4 Status</th><td><?php echo $payroll->w4_status; ?></td>
</tr>
<tr>
    <th>Proposed Rate</th><td><?php echo AccessRules::canSee('rate_proposed') ? Helper::numberFormat($payroll->rate_proposed) : ''; ?></td><th>Recommended Rate</th><td><?php echo AccessRules::canSee('rate_recommended') ? Helper::numberFormat($payroll->rate_recommended) : ''; ?></td>
</tr>
<tr>
    <th>Approved Rate</th><td><?php echo AccessRules::canSee('rate_approved') ? Helper::numberFormat($payroll->rate_approved) : ''; ?></td><th>Effective Date</th><td><?php echo AccessRules::canSee('rate_effective_date') ? $payroll->rate_effective_date : ''; ?></td>
</tr>
<tr>
    <th>Health Code</th><td><?php echo $payroll->deduc_health_code; ?></td><th>Health Amt</th><td><?php echo Helper::numberFormat($payroll->deduc_health_amt); ?></td>
</tr>
<tr>
    <th>Dental Code</th><td><?php echo $payroll->deduc_dental_code; ?></td><th>Dental Amt</th><td><?php echo Helper::numberFormat($payroll->deduc_dental_amt); ?></td>
</tr>
<tr>
    <th>Other Code</th><td><?php echo $payroll->deduc_other_code; ?></td><th>Other Amt</th><td><?php echo Helper::numberFormat($payroll->deduc_other_amt); ?></td>
</tr>
<tr>
    <th>Fed Expt</th><td><?php echo $payroll->fed_expt; ?></td><th>Fed Add</th><td><?php echo Helper::numberFormat($payroll->fed_add); ?></td>
</tr>
<tr>
    <th>State Expt</th><td><?php echo $payroll->state_expt; ?></td><th>State Add</th><td><?php echo Helper::numberFormat($payroll->state_add); ?></td>
</tr>
<tr>
    <th>Eligible for PTO?</th><td><?php echo $payroll->is_pto_eligible == '1' ? 'Yes' : 'No'; ?></td><th>PTO Effective Date</th><td><?php echo $payroll->pto_effective_date; ?></td>
</tr>
<tr>
    <th>Approved Profile?</th><td><?php echo $payroll->is_approved == '1' ? 'Yes' : 'No'; ?></td><th>Last Updated</th><td><?php echo $payroll->timestamp; ?></td>
</tr>
</tbody>
</table>
</fieldset>
