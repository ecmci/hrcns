<?php
Yii::app()->clientScript->registerScript('items',"
$(document).ready(function(){
  $('#item-loader').hide();  
});
function getQuickViewChangeNoticeItem(id){
  $('#item-loader').fadeIn();
  $('#viewport').hide();
  var url = '".Yii::app()->createAbsoluteUrl('hr/workflowchangenotice/getquick')."';
  var params = 'id='+id;
  $.ajax({
    url : url,
    data : params,
    success : function(data){
      $('#viewport').html(data).fadeIn('fast');
      $('#item-loader').fadeOut('fast');
      $('#btn-decline-confirm').click(btnDecline);
    },
    timeout : 15000,
    error : function( jqXHR, textStatus, errorThrown ) {
      alert('Oops! An Error Occured: ' + textStatus + ' | ' + errorThrown);
      location.reload();
    }
  });
  return false;
}
function btnDecline(){
  var url = '".Yii::app()->createAbsoluteUrl('hr/workflowchangenotice/decline')."';
  var params = 'routeback=' + $('#decline-action').val() + '&id=' + $('#WorkflowChangeNotice_id').val() + '&comment=' + $('#WorkflowChangeNotice_comment').val();
  $.post(url,params,function(response){
    console.log(response);
    if(response == '1'){
      location.reload();
    }else{
      alert(response);
    }
  });
}
");
Yii::app()->clientScript->registerCss('grid-selected',"
.grid-view table.items tr.selected td{
   background: #DFF0D8; 
}
.attention{
  color:#FF1300;
}
");
?>

<fieldset><legend><i class="icon-list"></i>Requests For Approval</legend>
  <?php //$this->renderPartial('_search_quick'); ?>
  <div id="items-list">
  <?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'items-change-notice',
        'type'=>array('hover'),
        'emptyText'=>'No pending change notice requests for you.',
        'dataProvider'=>$noticesForApproval,
        'enableSorting'=>false,
        'summaryText'=>'Showing {start}-{end} Items of {count} Requests',
        'summaryCssClass'=>'alert alert-success',
        'rowCssClassExpression'=>'$data->needsAttention() ? "attention" : "ok"',
        'selectionChanged'=>"function(id){ getQuickViewChangeNoticeItem($.fn.yiiGridView.getSelection('items-change-notice'));}",
        'htmlOptions'=>array('style'=>'cursor:pointer; font-size: 10pt; padding-top:0px;'),      
        'columns'=>array(
            'facility',
            array(
              'name'=>'notice_type',
              'value'=>'Helper::printEnumValue($data->notice_type)',
              'header' => 'Type'
            ),
            array(
              'name'=>'status',
              'value'=>'Helper::printEnumValue($data->status)',
            ),
            array(
              'name'=>'created_days_ago',
              'header' => 'Received',
              'type'=>'raw'
            ),
        ),
    )); ?>
    </div>
</fieldset>
