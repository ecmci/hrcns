<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

$this->menu = array(
	//array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
	array('label'=>Yii::t('app', 'Cancel'), 'url' => array('admin')),
	array('label'=>Yii::t('app', 'Generate Printable Form'), 'url'=>'#', 'linkOptions' => array('id'=>'gen-form')),
);
?>

<script type="text/javascript">
	$(document).ready(function(){
		jQuery('#gen-form').click(function (event){			
			if(confirm("Note: This will just generate a printer-friendly request form. Your request will not be saved. Continue?")){
				var data = jQuery('#requisition-form').serialize();
				var url = "<?=Yii::app()->baseUrl.'/index.php/requisition/requisition/getprintableform?'?>"+data;
				var windowName = "popUp";//$(this).attr("name");
				window.open(url, windowName, "width=850,height=600,scrollbars=yes,menubar=yes"); 
				event.preventDefault();
			}
		});
	});
</script>

<?php $request = ($model->REQTYPE_idREQTYPE == '1') ? 'Purchase' :  'Service'?>
<h1><?php echo Yii::t('app', '') . ' ' . $request.' Request Form'; ?></h1>

<?php
if($model->REQTYPE_idREQTYPE == '1'){
$this->renderPartial('_form_p', array(
		'model' => $model,
		'items'=>$items,
		'buttons' => 'create'));
}elseif($model->REQTYPE_idREQTYPE == '2'){
	$this->renderPartial('_form_s', array(
		'model' => $model,
		'vendors'=>$vendors,
		'buttons' => 'create'));
}
?>