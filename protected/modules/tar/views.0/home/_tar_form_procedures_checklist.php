<section id="async">
    <div id="procedures-checklist">
        <h5> 0 - 21 Days </h5>
        <section>
          <p><strong>Checklist (check the ones that are completed)</strong></p>
          <table class="table table-condensed">
           <tr>
            <th>If Patient is still in the facility</th>
            <th>If Patient is discharged</th>
            <th>If Patient is expired</th>
           </tr>
           <tr>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send X document. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send Y, Z document. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send A document. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
           </tr>
          </table>
        </section>
        
        <h5> 22 - 45 Days </h5>
        <section>
          <p><strong>Checklist (check the ones that are completed)</strong></p>
          <table class="table table-condensed">
           <tr>
            <th>If Patient is still in the facility</th>
            <th>If Patient is discharged</th>
            <th>If Patient is expired</th>
           </tr>
           <tr>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send 1st collection letter. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send 1st collection letter. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send 1st collection letter. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
           </tr>
          </table>
        </section>

        <h5> 46 Days and More </h5>
        <section>
          <p><strong>Checklist (check the ones that are completed)</strong></p>
          <table class="table table-condensed">
           <tr>
            <th>If Patient is still in the facility</th>
            <th>If Patient is discharged</th>
            <th>If Patient is expired</th>
           </tr>
           <tr>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send 1st collection letter. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send 1st collection letter. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
            <td> 
              <div class="control-group">
                <div class="controls">
                   <input type="checkbox" checked disabled> Send 1st collection letter. <small class="muted">(7/2/2014 By Person A)</small>                    
                </div>
              </div>
            </td>
           </tr>
          </table>
        </section>
        
    </div>
</section>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.steps.css');
Yii::app()->clientScript->registerCss('steps-css',"

");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.steps.min.js');
Yii::app()->clientScript->registerScript('steps-js',"
$('#procedures-checklist').steps({
    headerTag: 'h5',
    bodyTag: 'section',
    transitionEffect: 'slide'
});
",CClientScript::POS_READY);
?>