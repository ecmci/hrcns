<?php
$this->layout = '//layouts/column1'; 
?>
<div class="row-fluid">
  <div class="span3">
    <div class="row-fluid">
     <div class="span12">
     <?php $this->renderPartial('/home/_home_sidebar',array('model'=>$model)); ?> 
     </div>
    </div>
    <div class="row-fluid">
     <div class="span12">
     <?php //$this->renderPartial('/message/_message'); ?>  
     </div>
    </div> 
  </div>
  <div class="span9">
    <div class="row-fluid">
      <div class="span12">
       <?php $this->renderPartial('index',array('model'=>$model)); ?>
      </div>
    </div>
  </div>
</div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/tar.css'); 
?>