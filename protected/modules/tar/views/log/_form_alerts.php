<?php
$model->data_struct_alerts = empty($model->data_struct_alerts) ? CJSON::decode($model->alerts->data) : $model->data_struct_alerts;
$days = array();
for($c=1 ; $c <= 45; $c++){
  $days[$c] = $c;
}   
?>

<p class="alert alert-info">
 By default, the user who created this TAR will recieve the notification when any of the conditions specified below is true.
</p>
<table class="table" id="table-alert">
  <tr>
    <th>When case is...</th>
    <th>..and status is still...</th>
    <th>...alert:</th>
    <th></th>
  </tr>
  <?php if(!empty($model->data_struct_alerts)) foreach($model->data_struct_alerts as $i=>$alert): ?>
  <tr>
    <td><?php echo $form->dropDownList($model,"data_struct_alerts[$i][age]",$days); ?> day(s) old or more</td>
    <td><?php echo $form->dropDownList($model,"data_struct_alerts[$i][status]",TarStatus::getList(),array('class'=>'span12')); ?></td>
    <td>
      <ul id="data_struct_<?php echo $i; ?>_emails">
      <?php if(!empty($alert['email'])) foreach($alert['email'] as $j=>$email): ?>
          <li><?php echo $form->textField($model,"data_struct_alerts[$i][email][]",array('value'=>$email,'class'=>'span10')); ?><a onclick="$(this).closest('li').remove();" href="#" class="btn btn-danger btn-mini other-controls"><span class="icon-remove"></span></a></li>
      <?php endforeach; ?>
      </ul>
      <p>
       <a onclick="addEmail(<?php echo $i; ?>);" href="#" class="btn btn-info btn-mini other-controls"><span class="icon-plus"></span> Add Email</a>
      </p>  
    </td>
    <td><a onclick="$(this).closest('tr').remove();" href="#" class="btn btn-danger btn-mini other-controls"><span class="icon-remove"></span> Remove Alert</a></td>
  </tr>
  <?php endforeach; ?>
</table>
<p>
 <a onclick="addAlert();" href="#" class="btn btn-info other-controls"><span class="icon-plus"></span> Add Alert</a>
</p>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/tar-form.js',CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScript('_form_alerts_head_js',"
var counter_alert = ".(sizeof($model->data_struct_alerts)+1).";
",CClientScript::POS_HEAD);
?>