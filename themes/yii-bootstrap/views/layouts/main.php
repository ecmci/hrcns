<?php //Yii::beginProfile('overall'); ?>
<?php /* @var $this Controller */ ?>
<?php $baseThemeUrl = Yii::app()->theme->baseUrl; ?>
<?php require_once 'header.php'; ?>

<?php require_once 'navbar.php'; ?>

<div class="container-fluid" id="page">

	 <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	  <?php endif?>
    
    <noscript>
      <div class="alert alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h3>Ooops!</h3> This site relies heavily on Javascript. Please enable it for full functionality of this system.
      </div>
  </noscript>
  
  
	<?php echo $content; ?>

</div><!-- page -->
<?php require_once 'footer.php'; ?>
<?php //Yii::endProfile('overall'); ?>
