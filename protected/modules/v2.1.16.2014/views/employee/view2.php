<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$employee->emp_id,
);

$this->menu=array(
	array('label'=>'New Change Notice','url'=>array('/v2/notice/prepare','f'=>'c','e'=>$employee->emp_id)),
	array('label'=>'New License and Certfication','url'=>array('/license/license/create','e'=>$employee->emp_id)),
	array('label'=>'Request New/Modify IT Account','url'=>array('/itsystems/request/create','e'=>$employee->emp_id)),
	array('label'=>'Back','url'=>Yii::app()->request->urlReferrer),
);

Yii::app()->clientScript->registerCssFile(Yii::app()->getModule('v2')->assetsPath.'/css/DT_bootstrap.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/jquery.dataTables.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/DT_bootstrap.js');
Yii::app()->clientScript->registerCss('employee-view2-css',"
.dataTables_wrapper .row{
	padding-left:30px;
}
");
Yii::app()->clientScript->registerScript('DT_bootstrap-employee-view2-js',"
$.extend( $.fn.dataTableExt.oStdClasses, {
    \"sWrapper\": \"dataTables_wrapper form-inline\"
} );
",CClientScript::POS_READY);
?>

<h1 class="page-header"><?php echo $employee->getFullName(); ?></h1>

<div class="row-fluid">
	<div class="span2">
		<ul class="thumbnails">
			<li class="span12">
				<a title="<?php echo $employee->getFullName(); ?>" href="#" class="thumbnail">
				<img src="<?php echo Yii::app()->baseUrl.'/uploads/'.$employee->photo; ?>" title="<?php echo $employee->getFullName(); ?>" alt="<?php echo $employee->getFullName(); ?>">
				</a>
			</li>
		</ul>
	</div>
	<div class="span10">
	<?php $this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs', // 'tabs' or 'pills'
		'encodeLabel'=>false,
		'tabs'=>array(
			array('active'=>true,'label'=>'Employee Information', 'content'=>$this->renderPartial('/notice/_employee',array('employee'=>$employee,'personal'=>$personal,'employment'=>$employment,'payroll'=>$payroll),true)),
			array('label'=>'Change Notices','content'=>$this->renderPartial('_change_notices',array('emp_id'=>$employee->emp_id),true)),
			array('label'=>'Licences and Certifications','content'=>$this->renderPartial('_documents',array('emp_id'=>$employee->emp_id),true)),
			array('label'=>'IT Accounts','content'=>$this->renderPartial('_it_accounts',array('emp_id'=>$employee->emp_id),true)),
		),
	)); ?>
	</div>
</div>
<br/><br/>
