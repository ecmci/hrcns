<div class="row-fluid">
  <div class="span3">
    <?php include '_master_tar_sidebar.php';  ?>
  </div>
  <div class="span9">
    <div class="row-fluid" id="tar-list-section">
      <div class="span12">
        <div class="panel">
          <div class="panel-heading"><b>Treatment Authorization Requests</b> <span class="badge">16</span>
            <button class="btn btn-mini pull-right" type="button"><span class="icon-download-alt"></span> Export</button>
          </div>
            <div class="scrollview">
            <?php include '_master_tar_list.php';  ?> 
            </div>
        </div> 
      </div> 
    </div>
    <div class="row-fluid" id="tar-form-section">
      <div class="span12">
          <?php
           include '_master_tar_form.php';
          ?> 
      </div>  
    </div>
  </div>
</div>

<div class="clear">
 &nbsp;
</div>


<?php
Yii::app()->clientScript->registerCss('master-css',"
#tar-form-preloader img{
  display:block;
  margin-left: auto;
  margin-right: auto
}

label{
  font-size:0.85em;
  font-weight:bold;
}

.table{
  font-size:0.85em;
}

span.legend{
  padding: 3px;
}

span.warning{
  background:#fcf8e3;
}
span.critical{
  background:#f2dede;
}
span.good{
  background:#dff0d8;
}

.panel {
  padding: 15px;
  margin-bottom: 20px;
  background-color: #ffffff;
  border: 1px solid #dddddd;
  border-radius: 4px;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
}

.panel-heading {
  padding: 10px 15px;
  margin: -15px -15px 15px;
  font-size: 17.5px;
  font-weight: 500;      
  background-color: #f5f5f5;
  border-bottom: 1px solid #dddddd;
  border-top-right-radius: 3px;
  border-top-left-radius: 3px;
}

.panel-footer {
  padding: 10px 15px;
  margin: 15px -15px -15px;
  background-color: #f5f5f5;
  border-top: 1px solid #dddddd;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
}

.panel-primary {
  border-color: #428bca;
}

.panel-primary .panel-heading {
  color: #ffffff;
  background-color: #428bca;
  border-color: #428bca;
}

.panel-success {
  border-color: #d6e9c6;
}

.panel-success .panel-heading {
  color: #468847;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}

.panel-warning {
  border-color: #fbeed5;
}

.panel-warning .panel-heading {
  color: #c09853;
  background-color: #fcf8e3;
  border-color: #fbeed5;
}

.panel-danger {
  border-color: #eed3d7;
}

.panel-danger .panel-heading {
  color: #b94a48;
  background-color: #f2dede;
  border-color: #eed3d7;
}

.panel-info {
  border-color: #bce8f1;
}

.panel-info .panel-heading {
  color: #3a87ad;
  background-color: #d9edf7;
  border-color: #bce8f1;
}
.scrollviews{
  height: 250px;
  overflow-y:scroll;
}
");
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(
	Yii::app()->clientScript->getCoreScriptUrl().
	'/jui/css/base/jquery-ui.css'
);
Yii::app()->clientScript->registerScript('master-js',"
disableInputs();
",CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('master-fxnlib-js',"
function disableInputs(){
$('#tar-form input, #tar-form select, #tar-form textarea').each(function(){
  $(this).attr('readonly','readonly');
  $(this).attr('disabled','disabled');
});
$('.datepicker').datepicker('destroy');
}
function enableInputs(){
$('#tar-form input, #tar-form select, #tar-form textarea').each(function(){
  $(this).removeAttr('readonly');
  $(this).removeAttr('disabled');
});
renderDatepickers();
}
function renderDatepickers(){
$('.datepicker').each(function(){
  $(this).datepicker({
    changeYear : true,
    changeMonth : true
  });
  $(this).attr('readonly','readonly');
});
}
",CClientScript::POS_HEAD);
?>