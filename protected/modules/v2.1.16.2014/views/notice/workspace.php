<?php
$this->layout = '//layouts/column1';
$this->pageTitle = 'Workspace';
?>
<div class="row-fluid">
	<div class="span4">		
		<!-- search -->
		<div class="well" data-spy="affix" data-offset-top="200">
			<fieldset><legend><i class="icon icon-tasks"></i> Quick Actions</legend>
			<div class="input-append">
				<input class="input-xlarge" id="search" type="text" placeholder="Search Notice or Employee">
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown">
						<i class="icon icon-search"></i>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="icon icon-bullhorn"></i> Notices</a></li>
						<li><a href="#"><i class="icon icon-user"></i><i class="icon icon-user"></i> Employees</a></li>
					</ul>
				</div>
			</div>
			</fieldset>
			
			<!-- side nav -->
			<ul class="nav nav-list">
				<li class="nav-header">CHANGE NOTICES</li>
				<li><a href="<?php echo Yii::app()->createUrl('v2/notice/prepare?f=h'); ?>"><i class="icon icon-plus"></i> New Hire Form</a></li>
				<li><a href="#" class="" data-target="#modal-select-employee" data-toggle="modal"><i class="icon icon-plus"></i> New Change Notice Form</a></li>
				<li><a href="#"><i class="icon icon-folder-open"></i> Reports</a></li>
				<li class="nav-header">IT Support</li>
				<li><a href="#"><i class="icon icon-plus"></i> Request New / Modify Account Form</a></li>
			</ul>
		</div>
		<?php $this->renderPartial('_employee_select'); ?>
	</div>
	<div class="span8">	
		<?php $this->renderPartial('/notice/active',array('model'=>$notice)); ?>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
</div>
