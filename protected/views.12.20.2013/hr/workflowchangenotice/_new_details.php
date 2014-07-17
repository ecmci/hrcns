<div class="row-fluid">
   <div class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab1" data-toggle="tab">1. Basic Information</a></li>
      <li><a href="#tab2" data-toggle="tab">2. Personal Data</a></li>
      <li><a href="#tab3" data-toggle="tab">3. Employment Details</a></li>
      <li><a href="#tab4" data-toggle="tab">4. Payroll Specifications</a></li>
      <li><a href="#tab5" data-toggle="tab">5. Attachments</a>
        <div id="docs-loader" class="progress progress-striped progress-success active" style="display:none;">
          <div class="bar" style="width: 100%;">Loading Required Documents...Please wait.</div>
        </div>
      </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
          <?php $this->renderPartial('/hr/employee/_form_basic',array('model'=>$emp_basic,'form'=>$form));  ?>
        </div>
        <div class="tab-pane" id="tab2">
        <?php $this->renderPartial('/hr/employee/_form_personal',array('model_personal'=>$emp_personal,'form'=>$form));  ?>
        </div>
        <div class="tab-pane" id="tab3">
         <?php $this->renderPartial('/hr/employee/_form_employment',array('model_employment'=>$emp_employment,'form'=>$form));  ?>
        </div>
        <div class="tab-pane" id="tab4">
        <?php $this->renderPartial('_form_payroll',array('model_payroll'=>$emp_payroll,'form'=>$form,'notice'=>$model));  ?>
        </div>
        <div class="tab-pane" id="tab5">
        <?php $this->renderPartial('_attachments',array('form'=>$form,'notice'=>$model,'type'=>$model->notice_type, 'sub_type'=>$model->notice_sub_type));  ?> 
        </div>
      </div>
    </div>
</div>

