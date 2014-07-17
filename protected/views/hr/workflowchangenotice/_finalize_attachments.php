<?php
//echo $notice->attachments; exit();
$aa = !empty($notice->docs) ? $notice->docs : unserialize($notice->attachments);
$aa = ($aa == false or empty($aa)) ? array() : $aa;
?>
<fieldset><legend>Attachments</legend>
<ol id="attach-more">
<?php
 foreach($aa as $name=>$file):
?>
<li>
 <a href="<?php echo Yii::app()->baseUrl; ?>/uploads/<?php echo $file;  ?>" target="_blank"><?php echo $name; ?></a>
 <?php echo $form->hiddenField($notice,"docs[$name]",array('value'=>$file));  ?>
</li>
<?php
endforeach;
?>
</ol>

<?php if($notice->notice_type == 'NEW_HIRE' and $notice->processing_group == 'CORP'): ?>
<div id="everify" class="well">
<?php echo $form->fileFieldRow($notice,"docs[E-Verify]",array('class'=>'span5','required'=>'required', 'readonly'=>'readonly'));  ?>
<a href="#" id="remove-everify">If E-Verify is not needed, click here.</a>
</div>
<?php endif; ?>

</fieldset>

<?php
Yii::app()->clientScript->registerScript('finalize-js',"
$('#remove-everify').on('click',function(){
  $('#everify').remove();
});
",CClientScript::POS_READY);
?>
