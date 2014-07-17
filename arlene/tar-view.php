<!DOCTYPE html>
<html>
   <head>
      <title>TAR View</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="css/bootstrap.min.css" rel="stylesheet">
   </head>
   
   <body>
	 
	<div class="container">
	<div class="btn-group">
		  <button type="button" class="btn btn-default">Main</button>
		  <button type="button" class="btn btn-default">Reports</button>
	</div>

	<div class="row">
	 <div class="col-md-10">
	 <div class="panel panel-primary">
	   <div class="panel-heading"><b>TAR Reminder Log</b> <span class="badge">5</span></div>
	     <div class="panel-body panel panel-info">

		<table class="table table table-striped">
			<thead>
			  <tr> <!--Header double-click sort list/records-->
				 <th>Case ID</th>
				 <th>Resident Name</th>
				 <th>TAR No.</th>
				 <th>Status</th>
				 <th>Age</th>
				 <th>Requested Date</th>
				 <th>Progress</th>
				 <th>Last Action</th>
			  </tr>
			</thead>
			<tbody> <!--Record click views tar-info as modal-->
			
				<!--table row classes:danger/success/warning -->
				  <tr class="danger"> 
					 <td id="id_case"><a href="#">1</a></td>
					 <td id="id_resident"><a href="#">Charles White</a></td>
					 <td id="id_tar"><a href="#">2562535000</a></td>
					 <td id="id_stat">Under Review</td>
					 <td id="id_age">15 day(s)</td>
					 <td id="id_prog">Jan. 25, 2014</td>
					 <td id="id_reqdate">
					 <div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">60%</div></div>
					</td>
					 <td id="id_lastaction">Call manager and request for signed form of Step 2 by Username</td>
				  </tr>
			</tbody>
			
		</table>
	</div> 
	<span class="label label-info"><span class="glyphicon glyphicon-filter"></span> Filter Applied: </span>
</div> 
</div>

	 <div class="col-md-2">
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Top Reasons for Denied TARs</b></div>
				<div class="panel-body panel panel-info">
					<a href="#">Accounting office sends 1st collection letter.</a>
				</div>
			</div>
		</div>
	</div>


	  
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- Include all compiled plugins (below), or include individual files 
            as needed -->
      <script src="js/bootstrap.min.js"></script>
	  <script src="js/bootstrap-progressbar.js"></script>
	  
	  <script type="text/javascript">
	  $(document).ready(function() {
		//If progress bar == 100% then print Completed
		$('#progressbar').progressbar();
		$('#progressbar').progressbar('setStep', 80);
		$('#progressbar').progressbar('stepIt');

		$('#progressbar').progressbar({
			maximum: 100,
			step: 5
		});
		});
	  </script>
	  
	  <style type="text/css">
		.panel-info {
		border-color: #FFFFFF !important;
		}
	  	.dropdown-menu {
		background-color: #F8F8F8;
	    }
		.progress-bar-warning {
			background-color: #5CB85C !important;
		}
		.progress-bar-danger {
			background-color: #5CB85C !important;
		}
		th{
			text-align:center;
		}
	  </style>
   </body>
</html>