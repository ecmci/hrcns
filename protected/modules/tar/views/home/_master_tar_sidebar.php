<div data-spy="affix" data-offset-top="200" class="affix well" style="min-width:19%;">
  <fieldset><legend>Quick Actions</legend>
    <div class="input-append">
      <input class="span12" id="appendedInputButtons" type="text" placeholder="Case#,TAR#,Resident">
      <button class="btn" type="button"><span class="icon-search"></span></button>
    </div>
    <ul class="nav nav-list">
      <li class="nav-header">TAR</li>
      <li><a id="btnNew" href="#"><span class="icon-plus"></span> New TAR Log</a></li>
      <li><a href="<?php echo Yii::app()->createUrl('tar/home/report'); ?>"><span class="icon-briefcase"></span> Reports</a></li>
      <li class="nav-header">External Sites</li>
      <li><a href="#"><span class="icon-globe"></span> Medi-Cal Website</a></li>
      <li><a href="#"><span class="icon-globe"></span> Matrix Website</a></li>
      <li><a href="#"><span class="icon-globe"></span> Emdeon Website</a></li>
      <li><a href="#"><span class="icon-globe"></span> Quick Care Website</a></li>
    </ul> 
  </fieldset>
</div>
<!-- <fieldset><legend>Quick Facts</legend>
  <p><strong>Top 5 Reasons Why TARs Get Denied/Deferred</strong> <small>(As of June 2014)</small></p>
  <ol>
    <li>Late Application</li>
    <li>Lost Document Trail</li>
    <li>Reasons</li>
    <li>Another Reason</li>
    <li>Yet Another Reason</li>
  </ol>
</fieldset> -->