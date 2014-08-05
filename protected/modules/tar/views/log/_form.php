<p class="alert alert-warning other-controls">Fields with <span class="required">*</span> are required.</p>

<p>
 <?php
  echo $form->errorSummary($model);
 ?>
</p>

<div class="row-fluid">
  <div class="span4">
    <fieldset><legend><small>Resident Details</small></legend>
      <div class="row-fluid">
        <div class="span12">
        <?php echo BHtml::textField($model,'resident',array('class'=>'span12'),$form); ?>
        <?php echo BHtml::dropDownList($model,'facility_id',TarUser::getFacilityList(true),array('class'=>'span12'),$form); ?>
        <?php echo BHtml::textField($model,'admit_date',array('class'=>'span12 datepicker'),$form); ?>
        <?php echo BHtml::dropDownList($model,'resident_status',array('In-Patient'=>'In-Patient','Discharged/Expired'=>'Discharged/Expired'),array('class'=>'span12 datepicker'),$form); ?>
        </div>
      </div> 
    </fieldset> 
  </div>
  <div class="span4">
    <fieldset><legend><small>TAR Details</small></legend>
      <div class="row-fluid">
        <div class="span6">       
        <?php echo BHtml::textField($model,'requested_dos_date_from',array('class'=>'span12 datepicker'),$form); ?>
        <?php echo BHtml::textField($model,'requested_dos_date_thru',array('class'=>'span12 datepicker'),$form); ?>        
        <?php echo BHtml::textField($model,'applied_date',array('class'=>'span12 datepicker'),$form); ?>
        <?php echo BHtml::textField($model,'denied_deferred_date',array('class'=>'span12 datepicker'),$form); ?>
        <?php echo BHtml::textField($model,'approved_modified_date',array('class'=>'span12 datepicker'),$form); ?>
        </div>
        <div class="span6">
        <?php echo BHtml::dropDownList($model,'status_id',TarStatus::getList(),array('class'=>'span12'),$form); ?>        
        <?php echo BHtml::textField($model,'control_num',array('class'=>'span12'),$form); ?>        
        <?php echo BHtml::dropDownList($model,'type',array('Initial'=>'Initial','Reauthorization'=>'Reauthorization'),array('class'=>'span12 datepicker'),$form); ?>  
        <?php echo BHtml::textField($model,'medical_num',array('class'=>'span12'),$form); ?>         
        <?php echo BHtml::textField($model,'dx_code',array('class'=>'span12'),$form); ?>        
        </div> 
      </div> 
    </fieldset>  
  </div>
  <div class="span4">
    <fieldset><legend><small>Billing Details</small></legend>
      <div class="row-fluid">
        <div class="span12">
        <?php echo BHtml::textField($model,'backbill_date',array('class'=>'span12 datepicker'),$form); ?>
        <?php echo BHtml::dropDownList($model,'approved_care_id',TarApprovedCare::getList(),array('class'=>'span12'),$form); ?>  
        <div class="control-group">
            <label for="TarLog_aging_amount" class="control-label">Aging Amount</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">$</span>
                <?php echo CHtml::activeTextField($model,'aging_amount',array('class'=>''),$form); ?>
              </div>
            </div>
          </div> 
        </div>
      </div> 
    </fieldset> 
  </div>
</div>

<div class="row-fluid">
  <div class="span12">
<!--   <fieldset><legend><small>Case Notes</small></legend> -->
   <?php echo BHtml::textArea($model,'notes',array('class'=>'span12'),$form); ?>
<!--   </fieldset> --> 
  </div>
</div>
