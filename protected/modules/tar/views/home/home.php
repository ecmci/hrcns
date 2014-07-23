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
         $this->renderPartial('_home_tar_list',array('model'=>$model));
        ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
       <?php
         $this->renderPartial('_home_tar_form',array('model'=>$model));
        ?>
      </div>
    </div> 
  </div>
</div>
<?php 
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/tar.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/tar-home.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/client.restful.js');
Yii::app()->clientScript->registerScript('tar-home-head-js',"
var rest_url = '".Yii::app()->createAbsoluteUrl('tar/log')."';
var form_ops = '';
",CClientScript::POS_HEAD);      
Yii::app()->clientScript->registerScript('tar-home-head-js',"
onPageLoad();
",CClientScript::POS_READY); 
?>

<?php
 $this->renderPartial('_page_loader_modal');
?>