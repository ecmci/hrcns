<section id="async">
    <div id="procedures-checklist">
        <h5>APPLY <small>Produce all the documents below, make some calls and emails and apply for TAR in Medi-Cal's website.</small></h5>
        <section>
          <p><strong>Checklist (check the ones that are completed)</strong></p>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" checked disabled> Get document x. <small class="muted">(7/2/2014 By Person A)</small>                    
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" checked disabled> Get document y. <small class="muted">(7/2/2014 By Person AB)</small>                    
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" class=""> Mix x and y. Eat and be merry!                    
            </div>
          </div>
        </section>

        <h5>FOLLOW UP <small>Make it fast and be persistent. Don't worry if they get pissed already. We're just making money, duh.</small></h5>
        <section>
          <p><strong>Checklist (check the ones that are completed)</strong></p>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" class=""> Pissed payor.                    
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" class=""> Pissed biller.                    
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" class=""> Pissed the person next to me.                     
            </div>
          </div> 
        </section>

        <h5>BILL, COLLECT and CLOSE <small>Get the money into the company's pocket. Dont forget to pop a bottle of champagne.</small></h5>
        <section>
          <p><strong>Checklist (check the ones that are completed)</strong></p>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" class=""> Bring breakfast for the pissed payor.                    
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" class=""> Bring a freshly brewed coffee for the Pissed biller.                    
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="checkbox" class=""> Hug the person next to you.                     
            </div>
          </div> 
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