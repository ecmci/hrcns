<?php
$message = new TarMessaging;
$new_message_count = $message->getMessages()->itemCount; 
?>
<div class="panel">
  <div class="panel-heading">Quick Actions</div>
  <div class="panel-body">
    <ul class="nav nav-list">
      <li class="nav-header">TAR</li>
      <li><a id="btnNew" href="<?php echo Yii::app()->createUrl('tar/log/create'); ?>"><span class="icon-plus"></span> New TAR Case</a></li>
      <li><a href="<?php echo Yii::app()->createUrl('tar/report'); ?>"><span class="icon-briefcase"></span> Reports</a></li>
      <li><a href="<?php echo Yii::app()->createUrl('tar/message'); ?>"><span class="icon-envelope"></span> Messages <?php if($new_message_count > 0): ?><span class="badge badge-info"><?php echo $new_message_count; ?><?php endif; ?></span></a></li>
      <li class="nav-header">External Sites</li>
      <li><a href="#"><span class="icon-globe"></span> Medi-Cal Website</a></li>
      <li><a href="#"><span class="icon-globe"></span> Matrix Website</a></li>
      <li><a href="#"><span class="icon-globe"></span> Quick Care Website</a></li>
    </ul>
  </div>
</div>