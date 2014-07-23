<input id="loaded_tar_id" type="hidden">
<div class="panel">
  <div class="panel-heading">
    <div class="row-fluid"><!-- Form Operations -->
      <div class="span4"><span id="operation">View</span> TAR Case # <span id="tar-case-id"><?php echo $model->case_id; ?></span></div>
      <div class="span8">
        <div class="pull-right">
          <div id="update-buttons">
            <button id="btnNewToo" type="button" class="btn btn-success btn-mini"><span class="icon-plus"></span> New</button>            
            <button id="btnCopyNew" type="button" class="btn btn-success btn-mini"><span class="icon-book"></span> Copy as New</button>
            <button id="btnUpdate" type="button" class="btn btn-warning btn-mini"><span class="icon-edit"></span> Edit</button>
            <a href="#modal-close-case" role="button" class="btn btn-danger btn-mini" data-toggle="modal"><span class="icon-stop"></span> Close</a>
            <a href="#modal-follow-up" role="button" class="btn btn-info btn-mini" data-toggle="modal"><span class="icon-exclamation-sign"></span> Log Activity / Follow Up</a>            
            <button id="btnPrint" type="button" class="btn btn-mini"><span class="icon-print"></span> Print</button>                    
          </div><!-- end triggers-ops -->
          <div id="new-buttons" style="display:none;">
            <button id="btnSave" type="button" class="btn btn-large btn-warning"><span class="icon-ok"></span> Save</button>
            <button id="btnCancel" type="button" class="btn"><span class="icon-trash"></span> Cancel</button>
          </div><!-- commit-ops -->
        </div><!-- pull-right -->
      </div><!-- span8 -->
    </div>  
  </div>
  <div class="panel-body" id="tar-form">
  <?php
   $this->renderPartial('_tar_form',array('model'=>$model)); 
  ?>
  </div>
</div>