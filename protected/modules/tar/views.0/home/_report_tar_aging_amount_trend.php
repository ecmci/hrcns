<fieldset><legend>TAR Unbilled Amount Trending <input class="datepicker input-small" value="01/01/2014" type="text"/> - <input class="datepicker input-small" value="07/16/2014" type="text"/></legend>
<div id="flot-tar-aging-amount-trending" style="width:800px%; height:400px;"></div>
</fieldset>
<?php
Yii::app()->clientScript->registerScript('report-tar-aging-trend-ready-js',"
$.plot($('#flot-tar-aging-amount-trending'), aging_dataset,{
  xaxis : {
    axisLabel: 'Month',
    mode: 'time',
    tickSize: [1, 'month'],
    monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  },
  yaxis : {
    axisLabel: 'Amount',
  },
  series: {
    lines: { 
      show: true,
      fill: true 
    },
    points: {
        radius: 3,
        show: true,
        fill: true
    },
  },
  grid: {
    hoverable: true,
    borderWidth: 1
  },
  legend: {
    labelBoxBorderColor: 'none',
    position: 'right'
  }  
});
",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('report-tar-aging-trend-head-js',"
var aging_data = [
  [gd(2014,0,1), 12345],[gd(2014,0,30), 647457],[gd(2014,1,30), 226457],[gd(2014,2,30), 45645],[gd(2014,3,30), 1324238],[gd(2014,4,30), 456],[gd(2014,5,30), 87978],[gd(2014,6,30), 234234]    
];
var aging_dataset = [
  {label: 'Aging Amount',  data: aging_data, points: { symbol: 'circle', fillColor: '#AA4643' }, color: '#AA4643'},
];
",CClientScript::POS_HEAD);
?>