<div class="row-fluid">
  <div class="span3">
  <?php
   $this->renderPartial('_home_sidebar',array('model'=>$model));
  ?>   
  </div>
  <div class="span9">
    <div class="row-fluid" id="home_tar_list">
      <div class="span12">
       <?php
         $this->renderPartial('/log/admin',array('model'=>$model));
        ?>
      </div>
    </div>
  </div>
</div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/tar.css'); 
?>