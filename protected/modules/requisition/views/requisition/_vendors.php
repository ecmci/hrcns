<script>
var tbl = null;
var rowId = null;
$(document).ready(function(){
	tbl = document.getElementById('items');
	rowId = tbl.rows.length;
});


function addRowServiceItems() {
	 
	var table = document.getElementById('items');

	var rowIdx = table.rows.length;
	var row = table.insertRow(rowIdx);
	rowIdx -= 1;
	row.id = rowId;
	
	//item_num cell
	var cell = row.insertCell(0);
	var element = document.createElement("input");
	element.type = "text";
	element.name = "ReqItemsService["+rowIdx+"][vendor]";
	element.size = "50";
	element.setAttribute('required', 'required');
	cell.appendChild(element);
	
	//qty cell
	var cell = row.insertCell(1);
	var element = document.createElement("input");
	element.type = "text";
	element.name = "ReqItemsService["+rowIdx+"][qoutation]";
	element.size = "20";
	element.setAttribute('required', 'required');
	cell.appendChild(element);
	
	//delete cell
	var cell = row.insertCell(2);
	var element = document.createElement("a");
	var txt = document.createTextNode("Remove");
	element.id='rem-lnk';
	element.href='#items';
	element.appendChild(txt);	
	element.setAttribute('onclick', 'deleteRow('+rowId+')');
	cell.appendChild(element);
	
	rowId++;
}

function deleteRow(id) {
	try {
		$('#'+id).remove();
	}catch(e) {
		console.log(e);
	}
}
</script>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<style type="text/css">
table#items{width:500px;margin-left:150px;}
#items td{padding:2px;}
/*#items td{border:1px solid black;}*/
#items thead tr td{text-align:left;font-weight:bold;}
#rem-lnk{font-size:10px;}
</style>
	<div class="">
		<?php echo $form->errorSummary($vendors); ?>
		<label>Proposed Vendors</label><span class="required">*</span>
		<table id="items" class="table table-condensed">
			<thead><tr><td>Vendor</td><td>Quoted Amount</td><td></td></tr></thead>
			<tbody>
				<?php foreach($vendors as $i=>$item): ?>
				<tr id="<?=$i?>">
					<td><?php echo $form->textField($item,"[$i]vendor",array('size'=>'50','required'=>'required')); ?></td>
					<td><?php echo $form->textField($item,"[$i]qoutation",array('size'=>'20','required'=>'required')); ?></td>
					<td><?php if($i>1):?><a id="rem-lnk" href="#" onclick="deleteRow(<?=$i?>)">Remove</a><?php endif; ?></td>
				</tr>
				<?php endforeach; ?>				
			</tbody>
		</table>
		<p class="muted">Provide at least two (2) service providers.</p>
		<p><input class="btn" type="button" value="Add Vendor" onclick="addRowServiceItems()" /></p>
	</div>