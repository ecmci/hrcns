<?php /* @var $this Controller */ ?>
<?php $baseThemeUrl = Yii::app()->theme->baseUrl; ?>
<?php require_once 'header.php'; ?>

<div class="container-fluid" id="page" style="padding:10px;">
  <div class="row-fluid">
    <div class="span12">
      <h2 class="page-header"><img src="<?php echo Yii::app()->baseUrl; ?>/images/logo-eva.gif" style="height:90px;"/> <?php echo isset($this->form_title) ? $this->form_title : ''; ?></h2>
    </div>    
  </div> 
  <div class="row-fluid"><?php echo $content; ?></div>
</div><!-- page -->