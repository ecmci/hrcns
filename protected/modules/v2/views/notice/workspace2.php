<?php
$this->layout = '//layouts/column1';
$this->pageTitle = 'HRCNS Workspace';

$this->breadcrumbs=array(
	'Workspace',
);

Yii::app()->clientScript->registerCss('workspace-css',"
.table{
	font-size:10pt;
}
");
?>
<div class="row-fluid">
	<div class="span4">
		<!-- search -->
		<div class="well" data-spy="affix" data-offset-top="200">
			<fieldset><legend><i class="icon icon-tasks"></i> Quick Actions</legend>
			<div class="input-append">
				<label>Quick Search</label>
				<input class="input-xlarge" id="search" type="text" placeholder="Notice ID or Employee ID/Name">
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown">
						<i class="icon icon-search"></i>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a id="btn-search-notices" href="#"><i class="icon icon-bullhorn"></i> Notices</a></li>
						<li><a id="btn-search-employee" href="#"><i class="icon icon-user"></i><i class="icon icon-user"></i> Employees</a></li>
					</ul>
				</div>
			</div>
			</fieldset>
			
			<!-- side nav -->
			<ul class="nav nav-list">
				<li class="nav-header">CHANGE NOTICES</li>
				<li><a href="<?php echo Yii::app()->createUrl('v2/notice/prepare?f=h'); ?>"><i class="icon icon-plus"></i> New Hire Form</a></li>
				<li><a href="#" class="" data-target="#modal-select-employee" data-toggle="modal"><i class="icon icon-plus"></i> New Change Notice Form</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('v2/report'); ?>"><i class="icon icon-folder-open"></i> Reports</a></li>
				<li class="nav-header">IT Support</li>
				<li><a href="<?php echo Yii::app()->createUrl('itsystems/request/create'); ?>"><i class="icon icon-plus"></i> Request New / Modify Account Form</a></li>
			</ul>
		</div>
		<?php $this->renderPartial('_employee_select'); ?>
	</div>
	<div class="span8">
	<?php
		$routed = $notice->getRouted()->getData();
		$active = $notice->getActive()->getData();
	?>
	<fieldset><legend><i class="icon icon-bullhorn"></i> Notices <span class="badge badge-important"><?php echo (sizeof($routed) + sizeof($active)); ?></span></legend>
	<?php $this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'pills', // 'tabs' or 'pills'
		'encodeLabel'=>false,
		'tabs'=>array(
			array('label'=>'<strong>For Your Review</strong> <span class="badge badge-important">'.(sizeof($routed)).'</span>', 'content'=>$this->renderPartial('_routed',array('routed'=>$routed),true), 'active'=>true),
			array('label'=>'<strong>Active</strong> <span class="badge badge-important">'.(sizeof($active)).'</span>', 'content'=>$this->renderPartial('_active',array('active'=>$active),true)),
		),
	)); ?>
	</div>
	</fieldset>
</div>

<?php
Yii::app()->clientScript->registerScript('workspace-search-js',"
$('#btn-search-notices').on('click',function(){
	var url = '".Yii::app()->createUrl('v2/notice/search')."';
	var search = $('#search').val();
	window.location = url + '?Notice[id]=' + search;
});
$('#btn-search-employee').on('click',function(){
	var url = '".Yii::app()->createUrl('v2/employee/search')."';
	var search = $('#search').val();
	window.location = url + '?Employee[emp_id]=' + search;
});
",CClientScript::POS_READY);
?>
