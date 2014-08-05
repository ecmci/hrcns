<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal-select-employee')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Select An Employee</h4>
</div>
 
<div class="modal-body">
    <?php echo CHtml::dropDownList('employee','',Employee::getList(),array('id'=>'emp_id','class'=>'span12')); ?>
    <p class="label label-info">Tip: Type the first letter of the employee's last name.</p>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Build Notice Form',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal','id'=>'btn-build'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Cancel',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('employee-select-js',"
$('#btn-build').on('click',function(){
	window.location = '".Yii::app()->createUrl('v2/notice/prepare/?f=c&e=')."' + $('#emp_id').val();
});
",CClientScript::POS_READY);
?>
