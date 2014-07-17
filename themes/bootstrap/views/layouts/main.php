<?php
$baseThemeUrl = Yii::app()->theme->baseUrl;
require_once 'header.php';
require_once 'navbar.php';
?>
<div class="container-fluid">
  <noscript>
    <div class="alert alert-block">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <h3>Ooops!</h3> This site relies heavily on Javascript. Please enable it for full functionality of this system.
    </div>
  </noscript>	
  <?php echo $content; ?>
</div>
<?php require_once 'footer.php'; ?>