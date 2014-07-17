<?php $baseUrl = Yii::app()->baseUrl; ?>
<h1 class="page-header"><?php echo $model->getFullName(); ?></h1>
<div class="row-fluid">
    <div class="span3">
    <ul class="thumbnails">    
        <li class="span12">
          <div class="thumbnail">
            <img alt="<?php echo $model->photo; ?>" src="<?php echo $baseUrl; ?>/uploads/<?php echo $model->photo; ?>">
            <br/>
            <!--<p class="alert alert-error">Needs TLC</p>
            <p class="alert alert-warning">Sucks at photoshop</p>
            <p class="alert alert-info">Birthday wish is to skydive</p>-->
          </div>
        </li>
    </ul>
    </div>
    <div class="span9">
      <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab">Employee Information</a></li>
          <li><a href="#tab2" data-toggle="tab">Change Notice History</a></li>
          <li><a href="#tab3" data-toggle="tab">License and Certification</a></li>
          <li><a href="#tab4" data-toggle="tab">IT Accounts</a></li>          
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
          <fieldset><legend>Personal</legend>
          <?php $this->widget('bootstrap.widgets.TbDetailView',array(
          	'data'=>$model,
            'attributes'=>array(
          		'emp_id',
          		'last_name',
          		'first_name',
              'middle_name',
          	),
          )); ?>
          <?php 
            $mPersonal =  EmployeePersonalInfo::getInfo($model);            
            $this->widget('bootstrap.widgets.TbDetailView',array(
          	'data'=>$mPersonal,
            'attributes'=>array(
          		//'id',
              
              array(
                'name'=>'birthdate',
                'value'=> $mPersonal->birthdate ?  date(Yii::app()->params['dateFormat'],strtotime( $mPersonal->birthdate)) : '',
              ),
          		'gender',
          		'marital_status',
              'SSN',              
              //'number',
          		//'building',
          		//'street',
              //'zip_code',
              //'telephone',
          		//'cellphone',
//               array(
//                 'name'=>'email',
//                 'type'=>'raw',
//                 'value'=>CHtml::link(isset($mPersonal->email)?$mPersonal->email : '','mailto:'.isset($mPersonal->email)?$mPersonal->email : ''),
//               ),
              //'is_approved:boolean',
              'timestamp',
          	),
          )); ?>
          <fieldset>
           <legend>Contact</legend>
           <?php 
            $mPersonal =  EmployeePersonalInfo::getInfo($model);            
            $this->widget('bootstrap.widgets.TbDetailView',array(
          	'data'=>$mPersonal,
            'attributes'=>array(             
              //'number',
          		'building',
          		'street',
              'city',
              'state',
              'zip_code',
              'telephone',
          		'cellphone',
              array(
                'name'=>'email',
                'type'=>'raw',
                'value'=>CHtml::link(isset($mPersonal->email)?$mPersonal->email : '','mailto:'.isset($mPersonal->email)?$mPersonal->email : ''),
              ),
              'timestamp',
          	),
          )); ?>
          </fieldset>
          <fieldset><legend>Employment</legend>      
          <?php 
            $mEmployment = EmployeeEmployment::getInfo($model);
            $this->widget('bootstrap.widgets.TbDetailView',array(
          	'data'=>$mEmployment,
            'attributes'=>array(
              //'id',
              array(
                'name'=>'facility_id',
                'value'=>$mEmployment->facility ? $mEmployment->facility->title : '',
              ),
          		array(
                'name'=>'status',
                'value'=>Helper::printEnumValue($mEmployment->status),
              ),
              array(
                'name'=>'date_of_hire',
                'value'=>($mEmployment->date_of_hire and $mEmployment->date_of_hire != '0000-00-00') ? date(Yii::app()->params['dateFormat'],strtotime($mEmployment->date_of_hire)) : '',
              ),
              array(
                'name'=>'date_of_termination',
                'value'=>($mEmployment->date_of_termination and $mEmployment->date_of_termination != '0000-00-00') ? date(Yii::app()->params['dateFormat'],strtotime($mEmployment->date_of_termination)) : '',
              ),
              
              array(
                'name'=>'department_code',  
                'value'=>$mEmployment->departmentCode ? $mEmployment->departmentCode->code.' - '.$mEmployment->departmentCode->name : '',
              ),
          		
              array(
                'name'=>'position_code',
                'value'=>$mEmployment->positionCode ? $mEmployment->positionCode->job_code.' - '.$mEmployment->positionCode->name : '',
              ),
          		
              array(
                'name'=>'start_date',
                'value'=>($mEmployment->start_date and $mEmployment->start_date != '0000-00-00') ?date(Yii::app()->params['dateFormat'],strtotime($mEmployment->start_date)) : '',
              ),
              
              array(
                'name'=>'end_date',
                'value'=>($mEmployment->end_date and $mEmployment->end_date != '0000-00-00') ? date(Yii::app()->params['dateFormat'],strtotime($mEmployment->end_date)) : '',
              ),
              
//               array(
//                 'name'=>'contract_file',
//                 'type'=>'raw',
//                 'value'=>CHtml::link($mEmployment->contract_file,Yii::app()->baseUrl.'/uploads/'.$mEmployment->contract_file),
//               ),
              'has_union:boolean',
              //'is_approved:boolean',
              'timestamp',
          	),
          )); ?>          
          </fieldset>
          <fieldset><legend>Payroll</legend>
          <?php 
            $mPayroll =  EmployeePayroll::getInfo($model);
            $this->widget('bootstrap.widgets.TbDetailView',array(
          	'data'=>$mPayroll,
            'attributes'=>array(
          		//'id',
              /*
              'rate_type',
              array(
                'name'=>'rate_proposed',
                'value'=>Helper::numberFormat($mPayroll->rate_proposed),
              ),
               array(
                 'name'=>'rate_recommended',
                 'value'=>Helper::numberFormat($mPayroll->rate_recommended),
               ),
               * */
              array(
                'name'=>'rate_approved',
                'value'=>Helper::numberFormat($mPayroll->rate_approved),
                'visible'=>AccessRules::canSee('rate_approved'),
              ),
              array(
                'name'=>'rate_effective_date',
                'value'=>($mPayroll->rate_effective_date and $mPayroll->rate_effective_date != '0000-00-00') ? date(Yii::app()->params['dateFormat'],strtotime($mPayroll->rate_effective_date)) : '',
                'visible'=>AccessRules::canSee('rate_effective_date'),
              ),
              
          	 'deduc_health_code',
              array(
                'name'=>'deduc_health_amt',
                'value'=>Helper::numberFormat($mPayroll->deduc_health_amt),
              ),
              'deduc_dental_code',
              array(
                'name'=>'deduc_dental_amt',
                'value'=>Helper::numberFormat($mPayroll->deduc_dental_amt),
              ),
          		'deduc_other_code',
              array(
                'name'=>'deduc_other_amt',
                'value'=>Helper::numberFormat($mPayroll->deduc_other_amt),
              ),
//               'w4_status',
//               'fed_expt',              
//               array(
//                 'name'=>'fed_add',
//                 'value'=>Helper::numberFormat($mPayroll->fed_add),
//               ),
//               'state_expt',
//               
//               array(
//                 'name'=>'state_add',
//                 'value'=>Helper::numberFormat($mPayroll->state_add),
//               ),
              'is_pto_eligible:boolean',
              array(
                'name'=>'pto_effective_date',
                'value'=>($mPayroll->pto_effective_date and $mPayroll->pto_effective_date != '0000-00-00') ? date(Yii::app()->params['dateFormat'],strtotime($mPayroll->pto_effective_date)) : '',
              ),
              //'is_approved:boolean',
              'timestamp',
          	),
          )); ?> 
          </fieldset> 
          </div>
          <div class="tab-pane" id="tab2">
            <?php $this->widget('bootstrap.widgets.TbGridView',array(
            	'id'=>'workflow-change-notice-grid',
              'htmlOptions'=>array('class'=>'table table-condensed table-striped'),
            	'dataProvider'=>WorkflowChangeNotice::getHistory($model->emp_id),
            	'columns'=>array(
                'id',
                
                array(
                  'name'=>'notice_type',
                  'value'=>'Helper::printEnumValue($data->notice_type)',
                ),
                
                array(
                  'name'=>'notice_sub_type',
                  'value'=>'Helper::printEnumValue($data->notice_sub_type)',
                ),
                
                array(
                  'name'=>'status',
                  'value'=>'Helper::printEnumValue($data->status)',
                ),
                
                array(
                  'name'=>'processing_group',
                  'value'=>'Helper::printEnumValue($data->processing_group)',
                ),
                array(
                  'header'=>'Created',
                  'name'=>'timestamp'
                ),
            		array(
            			'class'=>'bootstrap.widgets.TbButtonColumn',
                  'template'=>'{view}',
                  'viewButtonUrl'=>'Yii::app()->createUrl("hr/workflowchangenotice/view",array("id"=>$data->id))',
            		),
            	),
            )); ?> 
          </div>
          <div class="tab-pane" id="tab3">
            <div id="licenses">
            <dt>Legend:</dt><dd><br><span class="alert alert-error">Expired</span></dd>
            <?php 
              include Yii::getPathOfAlias('license.components').'/LicenseApp.php'; 
              LicenseApp::renderManagementInterface($model->emp_id);
            ?>
            </div>
          </div>
          <div class="tab-pane" id="tab4">
            <div id="it-accts">
            <?php 
              Yii::import('itsystems.components.ItSysHelper'); 
              ItSysHelper::renderManagementInterface($model->emp_id);
            ?>
          </div>
          </div>
        </div>          
      </div>
    </div>
</div>
