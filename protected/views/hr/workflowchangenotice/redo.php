<?php

 $this->layout = 'column1';

 $this->breadcrumbs=array(

	'Workflow Change Notices'=>array('index'),

	'New',

);



Helper::includeJui();

Helper::renderDatePickers();



Yii::app()->clientScript->registerScript('dona',"

function showTab(idx){

$('#dona'+idx).tab('show');

}

",CClientScript::POS_BEGIN);

Helper::uploadifyFileFields();

?>

<h1 id="form" class="page-header">Change Notice Form</h1>



<?php 

$tab0Buttons = '<div class="form-actions"><a onclick="showTab(1)" href="#form" class="btn btn-large">Next</a></div>';

$tab1Buttons = '<div class="form-actions"><a onclick="showTab(0)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(2)" href="#form" class="btn btn-large">Next</a></div>';

$tab2Buttons = '<div class="form-actions"><a onclick="showTab(1)" href="#form" class="btn btn-large">Back</a> <a onclick="showTab(3)" href="#form" class="btn btn-large">Next</a></div>';

$tab3Buttons = '<div class="form-actions"><input class="btn btn-large btn-primary" value="Submit" type="submit"/> <a onclick="showTab(2)" href="#form" class="btn btn-large">Back</a></div>';

?>



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(

	'id'=>'workflow-change-notice-form',

  'type'=>'horizontal',

  'enableClientValidation'=>true,

  'enableAjaxValidation'=>true,

  'focus'=>array($model,'notice_type'),

  'clientOptions'=>array(

    'validateOnSubmit'=>true,

  ),



)); ?>



<div class="">

 <?php echo $form->errorSummary(array($model,$emp_basic,$emp_personal,$emp_employment,$emp_payroll)); ?>

</div>



<?php $this->widget('bootstrap.widgets.TbTabs', array(

  'id'=>'',

  'type'=>'tabs',

  'placement'=>'left', // 'above', 'right', 'below' or 'left'

  'tabs'=>array(

      array(

        'label'=>'Change Notice', 

        'content'=>$this->renderPartial('_new2',array('form'=>$form,'model'=>$model,'employment'=>$emp_employment),true).$tab0Buttons, 

        'active'=>true, 

        'linkOptions'=>array('id'=>'dona0')

      ),

      array(

        'label'=>'Employee Information', 

        'content'=>

          $this->renderPartial('/hr/employee/_form_basic',array('model'=>$emp_basic,'form'=>$form),true).

          $this->renderPartial('/hr/employee/_form_personal',array('model_personal'=>$emp_personal,'form'=>$form),true).

          $this->renderPartial('/hr/employee/_form_employment',array('model_employment'=>$emp_employment,'form'=>$form,'notice'=>$model),true).

          $this->renderPartial('_form_payroll',array('model_payroll'=>$emp_payroll,'form'=>$form,'notice'=>$model),true).$tab1Buttons, 

        'linkOptions'=>array('id'=>'dona1')

      ),

      array(

        'label'=>'Attachments', 

        'content'=>'<div id="attachment-section">'.$this->renderPartial('_redo_attachments',array('form'=>$form,'notice'=>$model,'type'=>$model->notice_type, 'subtype'=>$model->notice_sub_type),true).'</div>'.$tab2Buttons, 

        'linkOptions'=>array('id'=>'dona2'),
        
        //'active'=>true,

      ),

      array(

        'label'=>'Workflow Comments', 

        'content'=>$form->textAreaRow($model,'comment',array('class'=>'span5')).

                   $form->textFieldRow($model,'effective_date',array('class'=>'span5 datepicker')).$tab3Buttons, 

        'linkOptions'=>array('id'=>'dona3')

      ),      

  ),

)); ?>



<?php $this->endWidget(); ?>   
