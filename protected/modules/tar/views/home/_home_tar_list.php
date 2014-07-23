<?php
$model = new TarLog; 
?>
<div class="panel">
<!--   <div class="panel-heading">Treatment Authorization Requests <span class="label">16 Open Cases</span></div> -->
  <div class="panel-heading">
    <div class="row-fluid">
     <div class="span7">
      Treatment Authorization Requests <small><span class="label">16 Open Cases</small></span> 
      </div>
      <div class="span5">
        <!-- <div class="input-append">
          <input class="input-xlarge" id="appendedInputButtons" type="text" placeholder="Case#,TAR#,Resident">
          <button class="btn" type="button"><span class="icon-search"></span></button>
        </div> --> 
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="row-fluid">
      <div class="span12">
        <table class="table table-condensed table-hover table-striped" id="tbl-active-tar">
          <thead>
        	  <tr> <!--Header double-click sort list/records-->
        		 <th>Case #</th>
        		 <th>Resident</th>
        		 <th>Control #</th>
        		 <th>Status</th>
        		 <th>Age</th>
        		 <th>Requested DOS From</th>
        		 <th>Actions</th>
        	  </tr>
        	</thead>
          <tbody>
            <?php foreach($model->search()->getData() as $d): ?>
            <tr> <!--Header double-click sort list/records-->
              <td><?php echo $d['case_id']; ?></td>
              <td><?php echo $d['resident']; ?></td>
              <td><?php echo $d['control_num']; ?></td>
              <td><?php echo TarStatus::model()->findByPk($d['status_id'])->name; ?></td>
              <td><?php echo $d['age_in_days']; ?></td>
              <td><?php echo $d['requested_dos_date_from']; ?></td>
              <td><a href="#" class="btn" title="View" alt="View"><span class="icon-eye-open"></span></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php /* $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'tar-log-grid',
            'ajaxUrl'=>array('/tar/log'),
            'ajaxVar'=>'tar-home-yiilist',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'selectionChanged'=>'function(id){ loadTarLog($.fn.yiiGridView.getSelection(id));}',
            'itemsCssClass'=>'table table-hover',
            'columns'=>array(
                'case_id',
                'resident',
                'control_num',
                array(
                  'name'=>'status_id',
                  'value'=>'$data->status->name'
                ),
                'requested_dos_date_from',
                array(
                  'name'=>'age_in_days',
                  'filter'=>false,
                ),
                array(
                  'name'=>'last_activity',
                  'filter'=>false,
                ),
            ),
        )); */?>
      </div>
    </div>
  </div>
</div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->getModule('v2')->assetsPath.'/css/DT_bootstrap.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/jquery.dataTables.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('v2')->assetsPath.'/js/DT_bootstrap.js');
Yii::app()->clientScript->registerScript('DT_bootstrap-active-tar-js',"
$('#tbl-active-tar').dataTable( {
	\"sDom\": \"<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>\"
} );
$.extend( $.fn.dataTableExt.oStdClasses, {
    \"sWrapper\": \"dataTables_wrapper form-inline\"
} );
",CClientScript::POS_READY);
Yii::app()->clientScript->registerCss('_active-css',"
.dataTables_wrapper .row{
	padding-left:30px;
}
table.tbl-active-tar tr:hover {
  cursor: pointer !important;
}
");
?>