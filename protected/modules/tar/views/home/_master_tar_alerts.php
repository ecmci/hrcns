<div class="panel">
  <div class="panel-heading"></div>
  <div class="panel-body">
    If today is or past <input type="text" value="10/10/2014" readonly="readonly"> and this is still <select class="" disabled="disabled">
  	  <option value="underrev" selected>Should Be Applied on Requested Date</option>
      <option value="underrev">Under Review</option>
  	  <option value="denied">Denied / Deferred</option>
      <option value="approved">Approved / Modified</option>
  	</select>, alert the following:
   
    <div class="alert alert-info alert-receiver">
      bom@evacare.com
    </div>
  </div>
</div>

<div class="panel">
  <div class="panel-heading"></div>
  <div class="panel-body">
    If today is or past <input type="text" value="10/10/2014" readonly="readonly"> and this is still <select class="" disabled="disabled">
  	  <option value="underrev">Should Be Applied on Requested Date</option>
      <option value="underrev" selected>Under Review</option>
  	  <option value="denied">Denied / Deferred</option>
      <option value="approved">Approved / Modified</option>
  	</select>, alert the following:
   
    <div class="alert alert-info alert-receiver">
      bom@evacare.com
    </div>
  </div>
</div>

<div class="panel">
  <div class="panel-heading"><button class="btn btn-mini"><span class="icon-remove"></span> Remove Alert</button></div>
  <div class="panel-body">
    If today is or past <input type="text" value="10/20/2014"> and this is still <select class="">
  	  <option value="underrev">Should Be Applied on Requested Date</option>
      <option value="underrev">Under Review</option>
  	  <option value="denied">Denied / Deferred</option>
      <option value="approved" selected>Approved / Modified</option>
  	</select>, alert the following:
   
    <div class="alert alert-info alert-receiver">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      biller@evacare.com
    </div>
    <div class="alert alert-info alert-receiver">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      killer@evacare.com
    </div>
  </div>
</div>

<p><button class="btn"><span class="icon-plus"></span> Add Alert</button></p>

<?php
Yii::app()->clientScript->registerCss('tar-alerts-css',"
.alert-receiver{
  width:200px;
}
"); 
?>