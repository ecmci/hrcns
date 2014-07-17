<?php
 $this->layout = '//layouts/print';
 $this->pageTitle = Yii::app()->name.' | Change Notice ID '.$notice->id;
 Yii::app()->clientScript->registerCss('print',"
 .table .field{
    text-align:left;
    font-weight:bold;
    font-size:6pt;
  }
  
  p.value{
    text-align:left;
    padding-left:0px;
  }

  .table, p {
      font-size:8pt;

  }
  .strong{
	font-weight:bold;
  }
  .divider{
    border-bottom:1px solid #000000;
  } 
 ");
 Yii::app()->clientScript->registerScript("printing-notice","
 window.print();
 ",CClientScript::POS_READY)
?>

<table class="table table-condensed">
<tr>
    <td><small class="field">Facility</small><p class="value"><?php echo $notice->employmentProfile->facility->title; ?></p></td>
    <td><small class="field">Notice</small><p class="value"><?php echo Helper::printEnumValue($notice->notice_type.' - '.$notice->notice_sub_type); ?></p></td>
    <td><small class="field">Status</small><p class="value"><?php echo Helper::printEnumValue($notice->status); ?></p></td>
    <td><small class="field">Effective Date</small><p class="value"><?php echo $notice->effective_date; ?></p></td>
</tr>
<tr>
    <td><small class="field">Last Name</small><p class="value"><?php echo $notice->employmentProfile->emp->last_name; ?></p></td>
    <td><small class="field">First Name</small><p class="value"><?php echo $notice->employmentProfile->emp->first_name; ?></p></td>
    <td><small class="field">Middle Name</small><p class="value"><?php echo $notice->employmentProfile->emp->middle_name; ?></p></td>
    <td><small class="field">Gender</small><p class="value"><?php echo $notice->personalProfile->gender; ?></p></td>
</tr>
<tr>
    <td><small class="field">Address and Contact</small>
    <address>
      <?php echo $notice->personalProfile->building.' '.$notice->personalProfile->street.','; ?><br>
      <?php echo $notice->personalProfile->city.', '.$notice->personalProfile->state.' '.$notice->personalProfile->zip_code; ?><br>
      Phone: <?php echo $notice->personalProfile->telephone; ?><br>
      Cell: <?php echo $notice->personalProfile->cellphone; ?><br>
      Email: <?php echo $notice->personalProfile->email; ?><br>
    </address>
    </p></td>
    <td><small class="field">Date of Birth</small><p class="value"><?php echo $notice->personalProfile->birthdate; ?></p></td>
    <td><small class="field">Marital Status</small><p class="value"><?php echo $notice->personalProfile->marital_status; ?></p></td>
    <td><small class="field">SSN</small><p class="value"><?php echo $notice->personalProfile->SSN; ?></p></td>
</tr>
<tr>
    <td><small class="field">Employment Status</small><p class="value"><?php echo $notice->employmentProfile->status; ?></p></td>
    <td><small class="field">Position</small><p class="value"><?php echo $notice->employmentProfile->positionCode->job_code.' - '.$notice->employmentProfile->positionCode->name; ?></p></td>
    <td><small class="field">Department</small><p class="value"><?php echo $notice->employmentProfile->departmentCode->code.' - '.$notice->employmentProfile->departmentCode->name; ?></p></td>
    <td><small class="field"></small><p class="value"></p></td>
</tr>
<tr>
    <td><small class="field">PTO Eligibility</small><p class="value"><?php echo $notice->payrollProfile->is_pto_eligible == '1' ? "Yes" : "No"; ?></p></td>
    <td><small class="field">Effective Date</small><p class="value"><?php echo $notice->payrollProfile->pto_effective_date; ?></p></td>
    <td><small class="field"></small><p class="value"></p></td>
    <td><small class="field"></small><p class="value"></p></td>
</tr>
<tr>
    <td><small class="field">Fed Expt</small><p class="value"><?php echo $notice->payrollProfile->fed_expt; ?></p></td>
    <td><small class="field">Fed Add</small><p class="value"><?php echo $notice->payrollProfile->fed_add; ?></p></td>
    <td><small class="field">State Expt</small><p class="value"><?php echo $notice->payrollProfile->state_expt; ?></p></td>
    <td><small class="field">State Add</small><p class="value"><?php echo $notice->payrollProfile->state_add; ?></p></td>
</tr>
<tr>
    <td><small class="field"></small><p class="value <?php echo ($notice->notice_type=='NEW_HIRE') ? 'strong':''; ?>">New Hire Details</p></td>
    <td><small class="field">Hire Date</small><p class="value"><?php echo $notice->employmentProfile->date_of_hire; ?></p></td>
    <td><small class="field">Rate</small><p class="value">$ <?php echo AccessRules::canSee('rate_approved') ? $notice->payrollProfile->rate_approved : ''; ?></p></td>
    <td><small class="field">Rate Type</small><p class="value"><?php echo AccessRules::canSee('rate_type') ? $notice->payrollProfile->rate_type : ''; ?></p></td>
</tr>
<tr>
    <td rowspan="3"><small class="field"></small><p class="value <?php echo ($notice->notice_type=='CHANGE') ? 'strong':''; ?>">Change Details</p></td>
    <?php
      $last_rates = WorkflowChangeNotice::getLastRates($notice->employmentProfile->emp_id);
      $last_approved_rate = (!empty($last_rates)) ? $last_rates->rate_approved : 0; 
      $rate_proposed = $notice->payrollProfile->rate_proposed; 
      $percent_increase = 0;
      $last_increase_date = (!empty($last_rates)) ? date('Y-m-d',strtotime($last_rates->timestamp)) : '';
      if($last_approved_rate > 0){
        $percent_increase = abs( (($rate_proposed - $last_approved_rate)/$last_approved_rate) * 100 );
        $percent_increase = number_format($percent_increase,3);
      }
      //trap confidentail
      $last_approved_rate = AccessRules::canSee('rate_approved') ? $last_approved_rate : '';
      $rate_proposed = AccessRules::canSee('rate_proposed') ? $rate_proposed : ''; 
      $percent_increase = AccessRules::canSee('rate_approved') ? $percent_increase : '';
    ?>
    <td><small class="field">From</small><p class="value">$ <?php  echo $last_approved_rate; ?></p></td>
    <td><small class="field">To</small><p class="value">$ <?php echo $rate_proposed; ?></p></td>
    <td><small class="field">% Increase / Decrease</small><p class="value"><?php echo $percent_increase.' %'; ?></p></td>
</tr>
<tr>
    <td><small class="field">Current Rate</small><p class="value">$ <?php  echo $last_approved_rate; ?></p></td>
    <td><small class="field">Recommended Wage</small><p class="value">$ <?php echo AccessRules::canSee('rate_recommended') ? $notice->payrollProfile->rate_recommended : ''; ?></p></td>
    <td><small class="field">Last Wage Increase Date</small><p class="value"><?php echo $last_increase_date; ?></p></td>
</tr>
<tr>
    <td><small class="field">Rate Type</small><p class="value"><?php echo AccessRules::canSee('rate_type') ? $notice->payrollProfile->rate_type : ''; ?></p></td>
    <td><small class="field">Reason</small><p class="value"><?php echo $notice->reason; ?></p></td>
    <td><small class="field"></small><p class="value"></p></td>
</tr>
<tr>
    <td><small class="field"></small><p class="value <?php echo ($notice->notice_type=='RE_HIRE') ? 'strong':''; ?>">Re-Hire Details</p></td>
    <td><small class="field">Re-Hire Date</small><p class="value"><?php echo $notice->employmentProfile->date_of_hire; ?></p></td>
    <td><small class="field">Rate</small><p class="value">$ <?php echo AccessRules::canSee('rate_approved') ? $notice->payrollProfile->rate_approved : ''; ?></p></td>
    <td><small class="field">Rate Type</small><p class="value"><?php echo AccessRules::canSee('rate_type') ? $notice->payrollProfile->rate_type : ''; ?></p></td>
</tr>
<tr>
    <td class="divider" rowspan="2"><small class="field"></small><p class="value <?php echo ($notice->notice_type=='TERMINATED') ? 'strong':''; ?>">Termination Details</p></td>
    <td><small class="field">Terminated Date</small><p class="value"><?php echo ($notice->employmentProfile->date_of_termination != '0000-00-00') ? $notice->employmentProfile->date_of_termination : ''; ?></p></td>
    <td><small class="field">Reason</small><p class="value"><?php echo $notice->reason; ?></p></td>
    <td><small class="field"></small><p class="value"></p></td>
</tr>
<tr>
    <td class="divider" colspan="4"><small class="field"></small>
      <table class="table table-bordered table-condensed">
          <caption><strong>Deductions</strong></caption>
          <tr><th colspan="4">HEALTH</th><th colspan="4">DENTAL</th></tr>
          <tr>
            <th>Code</th><td><?php echo $notice->payrollProfile->deduc_health_code; ?></td>
            <th>Amount</th><td>$ <?php echo $notice->payrollProfile->deduc_health_amt; ?></td>
            <th>Code</th><td><?php echo $notice->payrollProfile->deduc_dental_code; ?></td>
            <th>Amount</th><td>$ <?php echo $notice->payrollProfile->deduc_dental_amt; ?></td>
          </tr>
          <tr>
            <th>Other</th><td><?php echo $notice->payrollProfile->deduc_other_code; ?></td>
            <th>Amount</th><td>$ <?php echo $notice->payrollProfile->deduc_other_amt; ?></td>
            <th></th><td></td>
            <th></th><td></td>
          </tr>
      </table>
    </td>
</tr>
<tr>
    <td class="divider" rowspan="3"><small class="field"></small><p class="value">Office Use Only</p></td>
    <td><small class="field">Prepared By</small><p class="value"><?php echo ($notice->bom) ? $notice->bom->getFullName() : ''; ?></p></td>
    <td><small class="field">Date</small><p class="value"><?php echo $notice->timestamp_bom_signed; ?></p></td>
    <td><small class="field">Comment</small><p class="value"><?php echo $notice->parseComment($notice->comment_bom); ?></p></td>
</tr>
<tr>
    <td><small class="field">Facility Administrator</small><p class="value"><?php echo ($notice->facAdm) ? $notice->facAdm->getFullName() : ''; ?></p></td>
    <td><small class="field">Date</small><p class="value"><?php echo $notice->timestamp_fac_adm_signed; ?></p></td>
    <td><small class="field">Comment</small><p class="value"><?php echo $notice->parseComment($notice->comment_fac_adm); ?></p></td>
</tr>
<tr>
    <td class="divider"><small class="field">Biller</small><p class="value"><?php echo ($notice->mnl) ? $notice->mnl->getFullName() : ''; ?></p></td>
    <td class="divider"><small class="field">Date</small><p class="value"><?php echo $notice->timestamp_mnl_signed; ?></p></td>
    <td class="divider"><small class="field">Comment</small><p class="value"><?php echo $notice->parseComment($notice->comment_mnl); ?></p></td>
</tr>
<tr>
    <td><small class="field"></small><p class="value">Corporate Office Use Only</p></td>
    <td><small class="field">Approved</small><p class="value"><?php echo $notice->corp_id; ?></p></td>
    <td><small class="field">Date</small><p class="value"><?php echo $notice->timestamp_corp_signed; ?></p></td>
    <td><small class="field">Comment</small><p class="value"><?php echo $notice->parseComment($notice->comment_corp); ?></p></td>
</tr>
</table>
<p class="muted">
  Rev. 10/09/2013<br>
 Submitted: 2013-10-01 23:56:06
</p>
