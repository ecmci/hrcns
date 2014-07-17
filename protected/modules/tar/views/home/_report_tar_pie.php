<fieldset><legend>TAR Status Overview - <select class="input-medium">
                                  <option>Jan 2014</option>
                                  <option>Feb 2014</option>
                                  <option>Mar 2014</option>
                                  <option>Apr 2014</option>
                                  <option>May 2014</option>
                                  <option>Jun 2014</option>
                                  <option selected>Jul 2014</option>
                                </select></legend>
  <div id="flot-tar-pie" style="width:800px%; height:600px;"></div>
  <div id="pieHover"></div>
</fieldset>
<?php
Yii::app()->clientScript->registerScript('report-tar-pie-ready-js',"
$.plot(('#flot-tar-pie'),data_pie,{
  series : {
    pie : {
      show : true,
      innerRadius: 0.3,
      label : {
        show : true,
      }
    }
  },
  legend: {
    labelBoxBorderColor: 'none'
 }
});
",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('report-tar-pie-head-js',"
var data_pie = [
    { label: 'Should be Applied',  data: 19.5, color: '#4572A7'},
    { label: 'Under Review',  data: 4.5, color: '#80699B'},
    { label: 'Denied/Deferred',  data: 36.6, color: '#AA4643'},
    { label: 'Approved/Modified',  data: 2.3, color: '#50B432'},
];
",CClientScript::POS_HEAD);
?>