<!DOCTYPE html>
<html lang="en">

<head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="css/bootstrap.min.css" rel="stylesheet">
	  <link href="css/datepicker.css" rel="stylesheet">
	  
	  <script src="https://code.jquery.com/jquery.js"></script>
	  <script src="js/bootstrap-datepicker.js"></script>
	  <style type="text/css">
		.bs-example
		{
			margin: 20px;
		}
		.panel
		{
			margin-bottom: 0px;
		}
	  </style>
</head>

<body>

	<div class="bs-example">
<div class="panel-body panel panel-info"> 
			<div class="col-md-3">
				<div class="input-group">
					<button type="button" class="btn btn-primary">
					  <span class="glyphicon glyphicon-plus"></span> New 
					</button>	
					<button type="button" class="btn btn-primary">
					  <span class="glyphicon glyphicon-pencil"></span> Update 
					</button>
					<button type="button" class="btn btn-success">
					  <span class="glyphicon glyphicon-hand-right"></span> Follow Up 
					</button>
				</div>
			</div>
	
			<div class="col-md-3"></div>
			<div class="col-md-2"></div>
			
            <div class="col-md-2">
						<div class="input-group">
							<span class="input-group-addon"><span>#</span></span>
							<input type="text" class="form-control" placeholder="Case No." disabled>
						</div>
            </div>
			
            <div class="col-md-2">
				<div class="row">
					<div class="col-md-5"></div>
					<div class="col-md-7">
						<div class="input-group">
							<select class="form-control" placeholder="TAR Status">
								  <option value="open">Open</option>
								  <option value="close">Close</option>
							</select>
						</div>  
					</div>  					
				</div>
            </div>
		</div>
</div>

	<div class="bs-example">
		<form>
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-primary"><div class="panel-heading"><b>Resident Details</b></div>
						<div class="panel-body panel panel-info">
							<div class="input-group">
								<label id="" class="control-label">Resident Name</label>
								<input type="text" class="form-control" placeholder="Resident Name">
							</div>
							
							<div class="input-group">
								<label id="" class="control-label">Facility Name</label>
								<select id="facnameid" class="form-control">
									  <option value="empress">Empress Care Center</option>
									  <option value="kitcarson">Kit Carson Nursing & Rehab</option>
								</select>
							</div>
				
								<label class="control-label">Admission/Re-Admission Date</label>
							<div class="input-group">	
								<input id="dateid" placeholder="mm/dd/yyyy" type="text" class="form-control" required></input>
							</div>
							
						</div>
					</div>
				</div>
		
				<div class="col-md-5">
					<div class="panel panel-primary">
						<div class="panel-heading"><b>TAR Details</b></div>
						<div class="panel-body panel panel-info">
					
					<div class="row">
			
						<div class="col-md-6">
								<label id="" class="control-label">Control No.</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="TAR Control No.">
							</div>
		
								<label id="" class="control-label">Applied Date</label>
							<div class="input-group">
								<input id="dateid" placeholder="mm/dd/yyyy" data-format="MM/dd/yyyy" type="text" class="form-control" required></input>
							</div>
				
								<label id="" class="control-label">DX Code</label>
							<div class="input-group">	
								<input id="dxcodeid" type="text" placeholder="DX Code" class="form-control"/>
							</div>
							
								<label id="" class="control-label">Requested DOS From</label>
							<div class="input-group">
								<input id="dateid" placeholder="mm/dd/yyyy" data-format="MM/dd/yyyy" type="text" class="form-control" required></input>
							</div>
						</div>
			
						<div class="col-md-6">
								<label id="" class="">Status</label>
							<div class="input-group">
								<span></span>
								<select class="form-control" placeholder="TAR Status">
								  <option value="underrev">Under Review</option>
								  <option value="approved">Approved</option>
								  <option value="modified">Modified</option>
								  <option value="denied">Denied</option>
								  <option value="deferred">Deferred</option>
								</select>
							</div>
		
								<label id="" class="">Type</label>
							<div class="input-group">	
								<select id="tartypeid" class="form-control">
								  <option value="init">Initial</option>
								  <option value="reauth">Reauthorization</option>
								  <option value="retro">Retro</option>
								</select>
							</div>	
		
								<label>Medical No.</label>
							<div class="input-group">	
								<input id="mednoid" type="text" placeholder="Medical No." class="form-control"/>
							</div>
							
								<label id="" class="control-label">Requested DOS Thru</label>
							<div class="input-group">
								<input id="dateid" placeholder="mm/dd/yyyy" data-format="MM/dd/yyyy" type="text" class="form-control" required></input>
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>

	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading"><b>Approval and Billing</b></div>
				
			<div class="panel-body panel panel-info">
				<div class="row">
				
				
				<div class="col-md-6">
				<label>Approval Date</label>
				<div class="input-group">	
				<input id="dateid" placeholder="mm/dd/yyyy" data-format="MM/dd/yyyy" type="text" class="form-control" required></input>
				</div>

				
				<label>Approved Care</label>
				<div class="input-group">	
				<select id="appcareid" class="form-control">
				  <option value="snf">SNF</option>
				  <option value="icf">ICF</option>
				</select>
				</div>
				
				</div>
				
				<div class="col-md-6">
				<label>Bill Back Date</label>
				<div class="input-group">	
				<input id="dateid" placeholder="mm/dd/yyyy" data-format="MM/dd/yyyy" type="text" class="form-control" required></input>
				</div>

				<label>Aging Amount</label>
				<div class="input-group">
				<span class="input-group-addon"><span>$</span></span>
				<input id="" placeholder="00.0" type="text" class="form-control" required></input>
				</div>
				</div>
				
				<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
				<label>Remarks</label>
				<textarea class="form-control" id="" placeholder="Remarks" row="1"></textarea>
				</div>
				</div>
				
				</div>
			</div>
		</div>
	</div>
</div>



	</form>
	</div>

	<style type="text/css">
	.dropdown-menu {
		background-color: #F8F8F8;
	}
	</style>
	
	<script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function() {
		
		$("input#dateid").datepicker({
					format: 'mm/dd/yyyy'
				});
				
		
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		 
		var defdate = $('#dateid').datepicker({
		  onRender: function(date) {
			return date.valueOf() < now.valueOf() ? 'disabled' : '';
		 } });
		});
	</script>

</body>

</html>