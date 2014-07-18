<div class="row-fluid">
  <div class="span3">
  <?php
   $this->renderPartial('_home_sidebar');
  ?>   
  </div>
  <div class="span9">
    <div class="row-fluid">
      <div class="span12">
       <?php
         $this->renderPartial('_home_tar_list');
        ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
       <?php
         $this->renderPartial('_home_tar_form');
        ?>
      </div>
    </div> 
  </div>
</div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/tar.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
?>