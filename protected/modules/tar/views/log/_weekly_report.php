<style type="text/css">
<!--
 .le-table {
  border-collapse: collapse;
 }
 .le-table th, .le-table td {
  border: 1px solid #000;
  padding:5px;
 }
//-->
</style>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
      	'id'=>'tar-log-grid',
        'summaryText'=>'{count} Open Cases',
        'emptyText'=>'Good news! You have no open cases.',
      	'dataProvider'=>$dataProvider,
        'enableSorting'=>false,
        'itemsCssClass'=>'le-table',
      	'columns'=>array(
          'case_id',
          'resident',
          'control_num',
          'status.name',
          'requested_dos_date_from',
          'age_in_days',
          'condition',
      	),
      )); ?>