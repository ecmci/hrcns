<fieldset><legend><i class="icon-eye-open"></i>View</legend>
  <div id="item-loader" class="progress progress-striped progress-success active" style="width:90%;">
    <div class="bar" style="width: 80%;">Loading item...Please wait.</div>
  </div>
  <div id="viewport"><?php if(!empty($noticesForApproval->data)) $this->renderPartial('/hr/workflowchangenotice/_quick_view',array('notice'=>$notice,'notice'=>$noticesForApproval->data[0])); else echo 'Today is a good day.'; ?></div>
</fieldset>