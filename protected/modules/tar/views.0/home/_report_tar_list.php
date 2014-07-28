<fieldset><legend>TAR List Search</legend>
<form>
  <div class="row-fluid">
    <div class="span4">
      <div class="control-group">
        <label class="control-label">Resident Name</label>
        <div class="controls">
          <input type="text" placeholder="Resident Name" class="span12">
        </div>
      </div> 
    </div>
    <div class="span4">
      <div class="control-group">
        <label class="control-label">TAR #</label>
        <div class="controls">
          <input type="text" placeholder="TAR #" class="span12">
        </div>
      </div> 
    </div>
    <div class="span4">
      <div class="control-group">
        <label class="control-label">Status</label>
        <div class="controls">
          <select class="span12" multiple="true">
					  <option value="underrev">Should Be Applied on Requested Date</option>
            <option value="underrev">Under Review</option>
					  <option value="denied">Denied / Deferred</option>
            <option value="approved">Approved / Modified</option>
					</select>
        </div>
      </div> 
    </div> 
  </div>
  <div class="row-fluid">
    <div class="span4">
      <div class="control-group">
        <label class="control-label">Requsted From</label>
        <div class="controls">
          <input type="text" placeholder="Requsted From" class="span12 datepicker">
        </div>
      </div> 
    </div>
    <div class="span4">
      <div class="control-group">
        <label class="control-label">Requsted Thru</label>
        <div class="controls">
          <input type="text" placeholder="Requsted Thru" class="span12 datepicker">
        </div>
      </div> 
    </div>
    <div class="span4">
      <div class="control-group">
        <label class="control-label">Case</label>
        <div class="controls">
          <select class="span12" multiple="true">
					  <option value="underrev">Open</option>
            <option value="underrev">Close</option>
					</select>
        </div>
      </div>
    </div> 
  </div>
  <div class="row-fluid form-control">
  <button class="btn btn-primary btn-large"><span class="icon-search"></span> Search</button>
  <button class="btn"><span class="icon-download-alt"></span> Export</button>
  <button class="btn"><span class="icon-print"></span> Print</button>
  <input type="reset" value="Reset" class="btn btn-mini"/>
  </div>
</form>
<table class="table table-condensed table-hover" id="tbl-active-tar">
  <thead>
	  <tr> <!--Header double-click sort list/records-->
		 <th>Case No.</th>
		 <th>Resident Name</th>
		 <th>TAR No.</th>
		 <th>Status</th>
		 <th>Age</th>
		 <th>Requested DOS From</th>
		 <!--<th>Progress</th>-->
		 <th>Status</th>
	  </tr>
	</thead>
  <tbody>
    <?php for($i=0;$i < 2; $i++): ?>
    <tr class=""> 
		 <td id="id_case"><a href="#">123</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Should be Applied</td>
		 <td id="id_age">?</td>
		 <td id="id_prog">?</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 60%;">60%</div></div></td> -->
		 <td id="id_lastaction">Open</td>
	  </tr>
    <tr class=""> 
		 <td id="id_case"><a href="#">124</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Under Review</td>
		 <td id="id_age">15 day(s)</td>
		 <td id="id_prog">01/25/2014</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 60%;">60%</div></div></td> -->
		 <td id="id_lastaction">Closed</td>
	  </tr>
    <tr class=""> 
		 <td id="id_case"><a href="#">125</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Approved/Modified</td>
		 <td id="id_age">15 day(s)</td>
		 <td id="id_prog">01/25/2014</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 99%;">99%</div></div></td> -->
		 <td id="id_lastaction">Open</td>
	  </tr>
    <tr class=""> 
		 <td id="id_case"><a href="#">126</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Denied/Deferred</td>
		 <td id="id_age">15 day(s)</td>
		 <td id="id_prog">01/25/2014</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 99%;">99%</div></div></td> -->
		 <td id="id_lastaction">Open</td>
	  </tr>
    <?php endfor; ?>
  </tbody>
</table>
<p class="muted pull-right"><small>LEGEND:</small> <span class="legend good">Good</span> <span class="legend warning">Warning</span> <span class="legend critical">Critical</span></p>
<div class="pagination">
  <ul>
    <li><a href="#">Prev</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#">Next</a></li>
  </ul>  
</div> 
</fieldset>

<?php
Yii::app()->clientScript->registerCss('report-tar-list-css',"
span.legend{
  padding: 3px;
}

span.warning{
  background:#fcf8e3;
}
span.critical{
  background:#f2dede;
}
span.good{
  background:#dff0d8;
}
"); 
?>