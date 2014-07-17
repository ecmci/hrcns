<?php
Yii::app()->clientScript->registerScript('nice',"
$(document).ready(function(){
  var windowHeight = $(window).height()-350;
  $('#scroll-view-1').height(windowHeight);
  $('#scroll-view-2').height(windowHeight);
  $('#scroll-view-3').height(windowHeight);
  $('#scroll-view-4').height(windowHeight);
});
");
?>

<div class="row-fluid">
  <div class="span2">
    <?php $basic = $notice->getProposedBasic();  ?>
    <div class="thumbnail">
         <img alt="No Photo" src="<?php echo Yii::app()->baseUrl; ?>/uploads/<?php echo $basic->photo; ?>">
    </div>
  </div>
  <div class="span10">       
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1-1" data-toggle="tab">Employee Information</a></li>
        </ul>        
        <div class="tab-content">
          <div class="tab-pane active" id="tab1-1">
            <div id="scroll-view-1">
            <fieldset><legend>Personal</legend>
            <?php 
              $this->widget('bootstrap.widgets.TbDetailView',array(
                'id'=>'employee-basic',
                'data' => $basic,
                'attributes'=>array(
                  'emp_id',
                  'last_name',
                  'first_name',
                  'middle_name',
                  'timestamp'
                ),
              ));
            ?>
            <?php 
                $this->widget('bootstrap.widgets.TbDetailView',array(
                  'id'=>'employee-personal',
                  'data' => $notice->personalProfile,
                  'attributes'=>array(
                    //'id',
                    'birthdate',
                    'gender',
                    'marital_status',
                    'SSN',
//                     'number',
//                     'building',
//                     'street',
//                     'city',
//                     'state',
//                     'zip_code',
//                     'telephone',
//                     'cellphone',
//                     'email',
//                     //'is_approved:boolean',
                    'timestamp',
                  ),
                ));
              ?>
              </fieldset>
              <fieldset><legend>Contact</legend>
              <?php 
                $this->widget('bootstrap.widgets.TbDetailView',array(
                  'id'=>'employee-personal',
                  'data' => $notice->personalProfile,
                  'attributes'=>array(
                    //'number',
                    'building',
                    'street',
                    'city',
                    'state',
                    'zip_code',
                    'telephone',
                    'cellphone',
                    'email',
                    //'is_approved:boolean',
                    'timestamp',
                  ),
                ));
              ?>
              </fieldset>
              <fieldset><legend>Employment</legend>
              <?php
              $employment = $notice->employmentProfile; 
              $this->widget('bootstrap.widgets.TbDetailView',array(
                'id'=>'employee-employment',
                'data' => $employment,
                'attributes'=>array(
                  //'id',
                  'facility',
                 // 'department_code',
                  array(
                    'name'=>'department_code',
                    'type'=>'raw',  
                    'value'=>$employment->departmentCode ? $employment->departmentCode->code." - ".$employment->departmentCode->name : "",
                  ),
                  array(
                    'name'=>'position_code',
                    'value'=>$employment->positionCode ? $employment->positionCode->job_code." - ".$employment->positionCode->name : "",
                  ),
                  //'status',
                  array(
                    'name'=>'status',
                    'value'=>Helper::printEnumValue($employment->status),
                  ),
                  'date_of_hire',
                  'start_date',
                  'date_of_termination',
                  //'date_end',
                  //'contract_file',
                  'has_union:boolean',
                  //'is_approved:boolean',
                  'timestamp',
                ),
              ));
            ?>
            </fieldset>
            <fieldset>
             <legend>Payroll</legend>
                           <?php 
                $payrollProfile = $notice->payrollProfile;
                $this->widget('bootstrap.widgets.TbDetailView',array(
                  'id'=>'employee-payroll',
                  'data' => $payrollProfile,
                  'attributes'=>array(
                    //'id',
                    
					array(
                      'name'=>'rate_type',
                      'visible'=>AccessRules::canSee('rate_type'),
                    ),
                    array(
                      'name'=>'rate_proposed',
                      'value'=>Helper::numberFormat($payrollProfile->rate_proposed),
                      'visible'=>AccessRules::canSee('rate_proposed'),
                    ),
                    
                    array(
                      'name'=>'rate_recommended',
                      'value'=>Helper::numberFormat($payrollProfile->rate_recommended),
                      'visible'=>AccessRules::canSee('rate_recommended'),
                    ),
                    
                    array(
                      'name'=>'rate_approved',
                      'value'=>Helper::numberFormat($payrollProfile->rate_approved),
                      'visible'=>AccessRules::canSee('rate_approved'),
                    ),
                    
                    array(
                      'name'=>'rate_effective_date',
                      'visible'=>AccessRules::canSee('rate_effective_date'),
                    ),

                    'deduc_health_code',
                    
                    array(
                      'name'=>'deduc_health_amt',
                      'value'=>Helper::numberFormat($payrollProfile->deduc_health_amt),
                    ),
                    'deduc_dental_code',
                    
                    array(
                      'name'=>'deduc_dental_amt',
                      'value'=>Helper::numberFormat($payrollProfile->deduc_dental_amt),
                    ),
                    'deduc_other_code',
                    
                    array(
                      'name'=>'deduc_other_amt',
                      'value'=>Helper::numberFormat($payrollProfile->deduc_other_amt),
                    ),
//                     'w4_status',
//                     'fed_expt',
//                     
//                     array(
//                       'name'=>'fed_add',
//                       'value'=>Helper::numberFormat($payrollProfile->fed_add),
//                     ),
//                     'state_expt',
//                     
//                     array(
//                       'name'=>'state_add',
//                       'value'=>Helper::numberFormat($payrollProfile->state_add),
//                     ),
                    'is_pto_eligible:boolean',
                    'pto_effective_date',
                    //'is_approved:boolean',
                    'timestamp',
                  ),
                ));
              ?>
            </fieldset>
            </div>
          </div>
        </div>
  </div>
</div>


