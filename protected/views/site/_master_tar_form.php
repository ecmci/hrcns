<div id="tar-form-preloader" style="display:none;"><img src="images/preloader.GIF"></div>
<div class="panel" id="tar-log-form">
  <div class="panel-heading">
    <div class="row-fluid">
      <div class="span5">
        <b><span id="operation">View</span> Treatment Authorization Request</b> 
      </div>
      <div class="span7">
        <div class="pull-right">
          <div id="triggers-ops">
            <button id="btnCopyNew" type="button" class="btn btn-success btn-mini"><span class="icon-book"></span> Copy as New</button>
            <button id="btnUpdate" type="button" class="btn btn-warning btn-mini"><span class="icon-edit"></span> Update</button>
            <button id="btnClose" type="button" class="btn btn-danger btn-mini"><span class="icon-stop"></span> Close</button>
            <button id="btnFup" type="button" class="btn btn-info btn-mini"><span class="icon-exclamation-sign"></span> Follow Up</button>
            <button id="btnPrint" type="button" class="btn btn-mini"><span class="icon-print"></span> Print</button>                    
          </div>
          <div id="commit-ops" style="display:none;">
            <button id="btnSave" type="button" class="btn btn-large btn-warning"><span class="icon-ok"></span> Save</button>
            <button id="btnCancel" type="button" class="btn"><span class="icon-trash"></span> Cancel</button>
          </div>
        </div>
      </div> 
    </div>    
  </div>
  <div class="row-fluid"><!-- begin details section -->
    <div class="span4">
      <fieldset><legend><small>Resident Details</small></legend>
        <div class="row-fluid">
          <div class="span12">
            <div class="control-group">
              <label class="control-label">Case No.</label>
              <div class="controls">
                <input type="text" placeholder="Case No." class="span12" disabled>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Resident Name</label>
              <div class="controls">
                <input type="text" placeholder="Resident Name" class="span12">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Facility</label>
              <div class="controls">
                <select id="facnameid" class="span12">
									  <option value="empress">Empress Care Center</option>
									  <option value="kitcarson">Kit Carson Nursing & Rehab</option>
								</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Admitted / Re-Admitted Date</label>
              <div class="controls">
                <input type="text" placeholder="mm/dd/yyyy" class="span12 datepicker">
              </div>
            </div> 
          </div>
        </div> 
      </fieldset> 
    </div>
    <div class="span4">
      <fieldset><legend><small>TAR Details</small></legend>
        <div class="row-fluid">
          <div class="span6">
            <div class="control-group">
              <label class="control-label">Control No.</label>
              <div class="controls">
                <input type="text" placeholder="Control No." class="span12">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Applied Date</label>
              <div class="controls">
                <input type="text" placeholder="Applied Date" class="span12 datepicker">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">DX Code</label>
              <div class="controls">
                <input type="text" placeholder="DX Code" class="span12">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Requested DOS From</label>
              <div class="controls">
                <input type="text" placeholder="Requested DOS From" class="span12 datepicker">
              </div>
            </div>
          </div>
          <div class="span6">
            <div class="control-group">
              <label class="control-label">Status</label>
              <div class="controls">
                <select class="span12">
								  <option value="underrev">Should Be Applied on Requested Date</option>
                  <option value="underrev">Under Review</option>
								  <option value="denied">Denied / Deferred</option>
                  <option value="approved">Approved / Modified</option>
								</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Type</label>
              <div class="controls">
                <select class="span12">
								  <option value="init">Initial</option>
								  <option value="reauth">Reauthorization</option>
								  <option value="retro">Retro</option>
								</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Medi-Cal No.</label>
              <div class="controls">
                <input type="text" placeholder="Medi-Cal No." class="span12">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Requested DOS Thru</label>
              <div class="controls">
                <input type="text" placeholder="Requested DOS Thru" class="span12 datepicker">
              </div>
            </div>
          </div>
        </div>   
      </fieldset> 
    </div>
    <div class="span4">
      <fieldset><legend><small>Billing Details</small></legend>
        <div class="row-fluid">
          <div class="span6"> 
            <div class="control-group">
              <label class="control-label">Approval Date</label>
              <div class="controls">
                <input type="text" placeholder="Approval Date" class="span12 datepicker">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Approved Care</label>
              <div class="controls">
                <select class="span12">
								  <option value="snf">SNF</option>
				          <option value="icf">ICF</option>
								</select>
              </div>
            </div>
          </div>
          <div class="span6"> 
            <div class="control-group">
              <label class="control-label">Bill Back Date</label>
              <div class="controls">
                <input type="text" placeholder="Bill Back Date" class="span12 datepicker">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Aging Amount</label>
              <div class="controls input-prepend">
                  <span class="add-on">$</span>
                  <input class="span10" type="text" placeholder="Aging Amount">
              </div>
            </div> 
          </div> 
        </div>
        <div class="row-fluid">
          <div class="span12">
            <div class="control-group">
              <label class="control-label">Remarks</label>
              <div class="controls">
                  <textarea class="span12"></textarea>
              </div>
            </div>
          </div>
        </div> 
      </fieldset>       
    </div>
  </div><!-- End Details section -->
  
  <div class="row-fluid"><!-- begin procedures section -->
    <div class="span12">
      <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab"><strong>Procedures and Checklists</strong></a></li>
          <li><a href="#tab2" data-toggle="tab"><strong>Configured Alerts</strong></a></li>
          <li><a href="#tab3" data-toggle="tab"><strong>Audit Log</strong></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
          <?php
           include '_master_tar_procedures_checklist.php';
          ?>

                                                                
          </div>
          <div class="tab-pane" id="tab2">
            <p><strong>While this is an open case...</strong></p>
            <div class="row-fluid">
              <?php
               include '_master_tar_alerts.php';
              ?>            
            </div>
          </div>
          <div class="tab-pane" id="tab3">
            <table class="table table-condensed">
             <thead>
              <tr>
                <th>Action</th>
                <th>Message</th>
                <th>Timestamp</th>
                <th>By User</th>
              </tr>
             </thead>
             <tbody>
                <tr>
                  <td>Created</td>
                  <td>Santa created this request.</td>
                  <td>7/10/2014 9:59 AM</td>
                  <td>Santa</td>
                </tr>
                <tr>
                  <td>Viewed</td>
                  <td>The goblin viewed this request.</td>
                  <td>7/10/2014 9:59 PM</td>
                  <td>Goblin</td>
                </tr>
                <tr>
                  <td>Viewed</td>
                  <td>The goblin viewed this request.</td>
                  <td>7/10/2014 9:59 PM</td>
                  <td>Goblin</td>
                </tr>
             </tbody>
            </table>
          </div>
        </div>
      </div> 
    </div> 
  </div><!-- Procedures section -->
</div>

<?php
Yii::app()->clientScript->registerScript('tar-form-js',"
$('button#btnCopyNew').on('click',function(){
  $('div#triggers-ops').hide();
  $('div#commit-ops').show(); 
  $('span#operation').html('Copy as New');
  $('div#tar-list-section').hide();
  enableInputs();
});
$('button#btnUpdate').on('click',function(){
  $('div#triggers-ops').hide();
  $('div#commit-ops').show();
  $('div#tar-list-section').hide();
  $('span#operation').html('Updating');
  enableInputs();
});
$('button#btnClose').on('click',function(){
  if(confirm('Sure?')){
    
  }
});
$('button#btnFup').on('click',function(){
  alert('Modal containg email form.');
});

$('a#btnNew').on('click',function(){
  $('span#operation').html('New');
  $('div#commit-ops').show();
  $('div#triggers-ops').hide();
  $('div#tar-list-section').hide();
});

$('button#btnSave').on('click',function(){
  if(confirm('Sure?')){
    $('div#commit-ops').hide();
    $('div#triggers-ops').show();
    disableInputs();  
  }
  $('div#tar-list-section').show();
});
$('button#btnCancel').on('click',function(){
  $('div#triggers-ops').hide();
  if(confirm('Sure?')){
      
  }
  $('div#commit-ops').hide();
  $('div#triggers-ops').show();
  $('div#tar-list-section').show();
  disableInputs();
});

",CClientScript::POS_READY); 
?>

