<fieldset><legend>TAR Status Trending <input class="datepicker input-small" value="01/01/2014" type="text"/> - <input class="datepicker input-small" value="07/16/2014" type="text"/></legend>
  
  <div id="flot-tar-trending" style="width:800px%; height:600px;"></div>
</fieldset>
<?php
Yii::app()->clientScript->registerScript('report-tar-trend-ready-js',"
$.plot($('#flot-tar-trending'), trend_dataset,{
  xaxis : {
    axisLabel: 'Month',
    mode: 'time',
    tickSize: [1, 'month'],
    monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  },
  yaxis : {
    axisLabel: 'Cases',
  },
  series: {
    lines: { show: true },
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
Yii::app()->clientScript->registerScript('report-tar-trend-head-js',"
//vars
var d1 = [
  [gd(2014,0,1), 0],[gd(2014,0,30), 20],[gd(2014,1,30), 24],[gd(2014,2,30), 61],[gd(2014,3,30), 18],[gd(2014,4,30), 100],[gd(2014,5,30), 121],[gd(2014,6,30), 14]    
];

var d2 = [
  [gd(2014,0,1), 0],[gd(2014,0,30), 50],[gd(2014,1,30), 29],[gd(2014,2,30), 67],[gd(2014,3,30), 89],[gd(2014,4,30), 30],[gd(2014,5,30), 32],[gd(2014,6,30), 45]    
];

var d3 = [
  [gd(2014,0,1), 0],[gd(2014,0,30), 31],[gd(2014,1,30), 89],[gd(2014,2,30), 45],[gd(2014,3,30), 56],[gd(2014,4,30), 3],[gd(2014,5,30), 22],[gd(2014,6,30), 67]    
];

var d4 = [
  [gd(2014,0,1), 0],[gd(2014,0,56), 2],[gd(2014,1,30), 34],[gd(2014,2,30), 2],[gd(2014,3,30), 45],[gd(2014,4,30), 22],[gd(2014,5,30), 55],[gd(2014,6,30), 9]    
];

var trend_dataset = [
  {label: 'Should Be Applied...',  data: d1, points: { symbol: 'circle', fillColor: '#4572A7' }, color: '#4572A7'},
  {label: 'Under Review',  data: d2, points: { symbol: 'circle', fillColor: '#80699B' }, color: '#80699B'},
  {label: 'Denied/Deferred',  data: d3, points: { symbol: 'circle', fillColor: '#AA4643' }, color: '#AA4643'},
  {label: 'Approved/Modified',  data: d4, points: { symbol: 'circle', fillColor: '#50B432' }, color: '#50B432'}  
];

//fxns
function gd(year, month, day) {
    return new Date(year, month, day).getTime();
}
",CClientScript::POS_HEAD);    
?>