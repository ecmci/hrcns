<div class="panel">
  <div class="panel-heading">Quick Actions</div>
  <div class="panel-body">
    <ul class="nav nav-list">
      <li class="nav-header">TAR</li>
      <li>
        <div class="input-append">
          <input class="span12" id="appendedInputButtons" type="text" placeholder="Case#,TAR#,Resident">
          <button class="btn" type="button"><span class="icon-search"></span></button>
        </div>
      </li>
      <li><a id="btnNew" href="#"><span class="icon-plus"></span> New TAR Log</a></li>
      <li><a href="<?php echo Yii::app()->createUrl('tar/home/report'); ?>"><span class="icon-briefcase"></span> Reports</a></li>
      <li><a href="#"><span class="icon-envelope"></span> Notifications <span class="badge badge-info">12</span></a></li>
      <li class="nav-header">External Sites</li>
      <li><a href="#"><span class="icon-globe"></span> Medi-Cal Website</a></li>
      <li><a href="#"><span class="icon-globe"></span> Matrix Website</a></li>
      <li><a href="#"><span class="icon-globe"></span> Quick Care Website</a></li>
    </ul>
  </div>
</div>