<?php
Yii::import('ext.yii-bootstrap.widgets.TbButtonColumn');
class RequestCButtonColumn extends TbButtonColumn{
  public $template = '{view} {process} {print} {cancel} {delete}';
  public $cancel = '#';
  public $buttons = array(
    'process'=>array(
      'label'=>'Process',
      'icon'=>'cog',
      'url'=>'Yii::app()->createUrl(ItSysHelper::getModuleBaseUrl()."/request/process/id/".$data->id)',
    ),  
    'print'=>array(
      'label'=>'Print',
      'icon'=>'print',
      'url'=>'Yii::app()->createUrl(ItSysHelper::getModuleBaseUrl()."/request/print/id/".$data->id)',
      'options'=>array('target'=>'_blank'),
    ),
    'cancel'=>array(
      'label'=>'Cancel',
      'icon'=>'stop',
      'url'=>'Yii::app()->createUrl(ItSysHelper::getModuleBaseUrl()."/request/cancel/id/".$data->id)',
      'click'=>'function(){
        if(confirm(\'Are you sure you want to cancel this request?\')){
          $.fn.yiiGridView.update("request-grid",{
            type    : "POST",
            url     : $(this).attr("href"),
            success : function(data){
              $("#flash-message").html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut("slow");
              $.fn.yiiGridView.update("request-grid");
              return false;  
            },
          });
        }
        return false;
      }',
    ),
  );
  
  protected function renderDataCellContent($row, $data) {
    $tr = array();
    ob_start();
    foreach ($this->buttons as $id => $button) {
        $this->renderButton($id, $button, $row, $data);
        $tr['{' . $id . '}'] = ob_get_contents();
        ob_clean();
    }
    ob_end_clean();
    echo strtr($this->template, $tr);    
  }
}
?>