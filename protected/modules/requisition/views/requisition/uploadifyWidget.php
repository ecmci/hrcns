<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.uploadify-3.1.min.js'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/uploadify.css'); ?>
<?php $uploadifyPath = Yii::app()->baseURL.'/js'; ?>
<script type="text/javascript">
	var fileCount = 0;
	$(document).ready(function(){
		$('#file_upload').uploadify({
			'swf'      : '<?=$uploadifyPath?>/uploadify.swf',
			'uploader' : '<?=$uploadifyPath?>/uploadify.php',				
			// Put your options here
			'auto' : true,
			//'checkExisting' : '<?=$uploadifyPath?>/check-exists.php',
			'buttonText': 'Attach Files',
			'multi' : true,
			'onUploadSuccess' : function(file, data, response) {
									//alert('The file was saved to: ' + data);
									var fid = 'upload'+fileCount;
									var rem = "$('#"+fid+"').remove();";
									fileCount++;
									$('#uploads_container').append("<div id='"+fid+"'><a onclick=\"$('#"+fid+"').fadeOut('slow',function(){$.post('<?=Yii::app()->baseUrl.'/uploads_requisition/delete-file.php?f='?>"+data+"&p=<?=Yii::app()->baseUrl.'/uploads_requisition'?>');$('#"+fid+"').remove();});\" href='#upload_container'><img width='17' height='17' src='<?=Yii::app()->baseUrl.'/js/uploadify-cancel.png'?>' /></a>"+data.substr(0,50)+"&hellip;<input value='"+data+"' name='uploads[]' type='hidden' size='50' /></div>");
								}, 
			'onComplete' : function(event, queueID, fileObj, response, data){
								//$('#uploads_container').append("<input value='"+fileObj.name+"' id='file-"+fileCount+"' name='uploads[]' type='text' />");
								//fileCount++;alert(fileCount);
							},
			//'fileTypeExts' : '*.gif; *.jpg, *.jpeg, *.png,*.GIF, *.JPG, *.JPEG, *.PNG, *.pdf, *.PDF, *.doc, *.DOC,*.docx, *.DOCX, *.xls, *.xls, *.xlsx, *.XLSX',
			//'fileTypeDesc' : 'Pictures and Documents',
			'fileSizeLimit' : '5MB',
			'onQueueComplete' : function(){alert('Upload Complete.');},
			'formData' : {'baseurl':'<?=Yii::app()->baseURL?>'},
			'removeCompleted' : true,
			'onError': function (a, b, c, d) {
				if (d.status == 404)
					alert('Could not find upload script. Use a path relative');
				else if (d.type === "HTTP")
				   alert('error '+d.type+": "+d.status);
				else if (d.type ==="File Size")
				   alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
				else
				   alert('error '+d.type+": "+d.text);
			},
		});
	});
</script>
<input type="file" name="file_upload" id="file_upload" />
<p class="hint">Upload relevant files here. Word, PDF, Excel, Pictures and any other files are accepted. Limit is 5MB per file.</p>
<!--<a href="#uploads_container" onclick="javascript:$('#file_upload').uploadify('upload','*')">Upload Files</a>-->

<div id="uploads_container">
	<h5>Attachments</h5>	
	<?php 
		if(isset($_REQUEST['uploads'])) { 
			foreach($_REQUEST['uploads'] as $i=>$file){ $fid = "file".$i; ?>
				<div id="<?=$fid?>">
					<a onclick="$('#<?=$fid?>').fadeOut('slow',function(){$.post('<?=Yii::app()->baseUrl."/uploads_requisition/delete-file.php?f=$file"?>&p=<?=Yii::app()->baseUrl.'/uploads_requisition'?>');$('#<?=$fid?>').remove();});" href='#upload_container'><img width='17' height='17' src='<?=Yii::app()->baseUrl.'/js/uploadify-cancel.png'?>' /></a>
					<?=substr($file, 0, 50)?>&hellip;<input value='<?=$file?>' name='uploads[]' type='hidden' size='50' />
				</div>
			<?php }				
		}		
	?>
</div>
