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
		 <th>Last Action</th>
	  </tr>
	</thead>
  <tbody>
    <?php for($i=0;$i < 1; $i++): ?>
    <tr class=""> 
		 <td id="id_case"><a href="#">123</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Should be Applied</td>
		 <td id="id_age">?</td>
		 <td id="id_prog">?</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 60%;">60%</div></div></td> -->
		 <td id="id_lastaction">1/30/2013 8:00 AM - Created by Person X</td>
	  </tr>
    <tr class="warning"> 
		 <td id="id_case"><a href="#">124</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Under Review</td>
		 <td id="id_age">15 day(s)</td>
		 <td id="id_prog">01/25/2014</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 60%;">60%</div></div></td> -->
		 <td id="id_lastaction">1/30/2013 8:00 AM - Updated by Person Y</td>
	  </tr>
    <tr class="success"> 
		 <td id="id_case"><a href="#">125</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Approved/Modified</td>
		 <td id="id_age">15 day(s)</td>
		 <td id="id_prog">01/25/2014</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 99%;">99%</div></div></td> -->
		 <td id="id_lastaction">1/30/2013 8:00 AM - Checklist updated by Person Z</td>
	  </tr>
    <tr class="error"> 
		 <td id="id_case"><a href="#">126</a></td>
		 <td id="id_resident"><a href="#">Charles White</a></td>
		 <td id="id_tar"><a href="#">2562535000</a></td>
		 <td id="id_stat">Denied/Deferred</td>
		 <td id="id_age">15 day(s)</td>
		 <td id="id_prog">01/25/2014</td>
<!-- 		 <td id="id_reqdate"><div class="progress"><div class="bar" style="width: 99%;">99%</div></div></td> -->
		 <td id="id_lastaction">1/30/2013 8:00 AM - Follow Up sent by Person XYZ</td>
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

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->getModule('v2')->assetsPath.'/css/DT_bootstrap.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/jquery.dataTables.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/DT_bootstrap.js');
Yii::app()->clientScript->registerScript('DT_bootstrap-active-tar-js',"
$('#tbl-active-tars').dataTable( {
	\"sDom\": \"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>\"
} );
$.extend( $.fn.dataTableExt.oStdClasses, {
    \"sWrapper\": \"dataTables_wrapper form-inline\"
} );
",CClientScript::POS_READY);
Yii::app()->clientScript->registerCss('_active-css',"
.dataTables_wrapper .row{
	padding-left:30px;
}
table.tbl-active-tar tr:hover {
  cursor: pointer !important;
}
");
Yii::app()->clientScript->registerScript('active-tar-ready-js',"
$('#tbl-active-tar td').on('click',function(){
  $('#tar-form-preloader').show();
  $('#tar-log-form').hide();
  setTimeout(function(){
    $('#tar-form-preloader').hide();
    $('#tar-log-form').show();
  },1000);
});
",CClientScript::POS_READY);
?>