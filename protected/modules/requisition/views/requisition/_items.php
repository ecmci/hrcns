<script>
var tbl = null;
var rowId = null;
$(document).ready(function(){
	tbl = document.getElementById('items');
	rowId = tbl.rows.length;
	getValues(0);
});


function addRowPurchaseItems() {
	 
	var table = document.getElementById('items');

	var rowIdx = table.rows.length;
	var row = table.insertRow(rowIdx);
	rowIdx -= 1;
	row.id = rowId;
	
	//item_num cell
	var cell = row.insertCell(0);
	var element = document.createElement("input");
  element.value = rowIdx + 1;
	element.type = "text";
	element.id="ReqItemsPurchase_item_num";
	element.name = "ReqItemsPurchase["+rowIdx+"][item_num]";
	element.size = "5";
	element.setAttribute('required', 'required');
  element.style.width='50px';
	cell.appendChild(element);
	
	//qty cell
	var cell = row.insertCell(1);
	var element = document.createElement("input");
	element.type = "text";
	element.id = "itemQty["+rowIdx+"]";
	element.name = "ReqItemsPurchase["+rowIdx+"][quantity]";
	element.size = "5";
  element.style.width='50px';
	element.setAttribute('onkeyup', 'getValues('+rowIdx+')');
	element.setAttribute('required', 'required');
	cell.appendChild(element);
	
	//unit cell
	var cell = row.insertCell(2);
	var element = document.createElement("select");
	var option = document.createElement("option");
	option.text = "-";
	option.value = "";	
	element.add(option);
	option = document.createElement("option");
	option.text = "pcs";
	option.value = "pcs";	
	element.add(option);
	option = document.createElement("option");
	option.text = "doz";
	option.value = "doz";	
	element.add(option);	
	option = document.createElement("option");
	option.text = "bxs";
	option.value = "bxs";	
	element.add(option);	
	option = document.createElement("option");
	option.text = "cs";
	option.value = "cs";	
	element.add(option);	
	option = document.createElement("option");
	option.text = "other";
	option.value = "other";	
	element.add(option);
	element.id="ReqItemsPurchase_item_name_detail";
	element.name = "ReqItemsPurchase["+rowIdx+"][unit]";	
	element.setAttribute('required', 'required');
  element.style.width='75px';
	cell.appendChild(element);
	
	//item_name cell
	var cell = row.insertCell(3);
	var element = document.createElement("input");
	element.type = "text";
	element.id="ReqItemsPurchase_item_name_detail";
	element.name = "ReqItemsPurchase["+rowIdx+"][item_name]";
	/*element.size = "15";*/	
	element.setAttribute('required', 'required'); 
  element.style.width='250px'; 	
	cell.appendChild(element);
	
	//specs cell
	var cell = row.insertCell(4);
	var element = document.createElement("input");
	element.type = "text";
	element.id="ReqItemsPurchase_item_name_detail";
	element.name = "ReqItemsPurchase["+rowIdx+"][specification]";
	element.size = "30";
	element.setAttribute('required', 'required');	
  element.style.width='250px';
	cell.appendChild(element);
	
	//est_price cell
	var cell = row.insertCell(5);
	var element = document.createElement("input");
	element.type = "text";
	element.id = "itemCost["+rowIdx+"]";
	element.name = "ReqItemsPurchase["+rowIdx+"][price_estimate]";
	element.size = "5";		
	element.setAttribute('onkeyup', 'getValues('+rowIdx+')');
	element.setAttribute('required', 'required');
  element.style.width='50px';
	cell.appendChild(element);
	
	//reason cell
	var cell = row.insertCell(6);
	var element = document.createElement("input");
	element.type = "text";
	element.id="ReqItemsPurchase_item_name_detail";
	element.name = "ReqItemsPurchase["+rowIdx+"][reason]";
	element.size = "30";
  element.style.width='250px';	
	cell.appendChild(element);
	
	//sub_total cell
	var cell = row.insertCell(7);
	var element = document.createElement("input");
	element.type = "text";	
	element.size = "10";	
	element.id = "itemTotal["+rowIdx+"]";
	element.disabled="disabled";
  element.style.width='50px';
	cell.appendChild(element);
	
	//sub_total cell
	var cell = row.insertCell(8);
	var element = document.createElement("a");
	var txt = document.createTextNode("Remove");
	element.id='rem-lnk';
	element.href='#';
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

function getValues(idx){
	total = 0;
	$("#items tbody tr").each(function(i,e){
		var qty = document.getElementById('itemQty['+i+']').value;
		var cost = document.getElementById('itemCost['+i+']').value;		
		var result = qty * cost;
		total += result;
		document.getElementById('itemTotal['+i+']').value = result.toFixed(2);		
	});
	document.getElementById("total").value = total.toFixed(2);
}

	
var qty=0, cost=0, total=0;
function getValues2(idx)
{	
	total = 0;	
	$("#items tbody tr td input").each(function(i,e){
		var name = $(this).attr("name");		
		if(name=="ReqItemsPurchase["+idx+"][quantity]"){
			qty = $(this).val();			
		}
		if(name=="ReqItemsPurchase["+idx+"][price_estimate]"){
			cost = $(this).val();			
		}
		if(name=="itemTotal["+idx+"]"){
			$(this).val((qty * cost) * 1);
			qty = 0; cost=0;						
		}
		if($(this).attr("id")=="subtotal"){
			total += ($(this).val() * 1);
		}
	});
	document.getElementById("total").value = total*1;
}
</script>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<style type="text/css">
#items td{padding:2px;}
#items thead tr td{text-align:left;font-weight:bold;}
#rem-lnk{font-size:10px;}
</style>
	<div class="row-fluid">
		<?php echo $form->errorSummary($items); ?>
		<table id="items" class="table table-condensed">
			<thead><tr><td>Item#</td><td>Qty</td><td>Unit</td><td>Item Name</td><td>Specification</td><td>Unit Cost</td><td>Reason</td><td>Total Price</td><td></td></tr></thead>
			<tbody>
				<?php 
					$units = array(
						''=>'-',
						'pcs'=>'pcs',
						'doz'=>'doz',
						'bxs'=>'bxs',
						'cs'=>'cs',
						'other'=>'other'
					);
				?>
				<?php foreach($items as $i=>$item): ?>
				<tr id="<?=$i?>">
					<td><?php echo $form->textField($item,"[$i]item_num",array('style'=>'width:50px;','required'=>'required','value'=>(!empty($item->item_num)) ? $item->item_num : '1')); ?></td>
					<td><?php echo $form->textField($item,"[$i]quantity",array('style'=>'width:50px;','onkeyup'=>'getValues(0)','id'=>'itemQty['.$i.']','required'=>'required')); ?></td>
					<td><?php echo $form->dropDownList($item,"[$i]unit",$units,array('style'=>'width:75px;','required'=>'required')); ?></td>
					<td><?php echo $form->textField($item,"[$i]item_name",array('style'=>'width:250px;','size'=>'','required'=>'required')); ?></td>
					<td><?php echo $form->textField($item,"[$i]specification",array('style'=>'width:250px;','required'=>'required')); ?></td>
					<td><?php echo $form->textField($item,"[$i]price_estimate",array('style'=>'width:50px;','onkeyup'=>'getValues(0)','id'=>'itemCost['.$i.']','required'=>'required')); ?></td>
					<td><?php echo $form->textField($item,"[$i]reason",array('style'=>'width:250px;')); ?></td>
					<td><input name="subtotal" value="" id="itemTotal[<?=$i?>]" size="" type="text" style='width:50px;' disabled="disabled" /></td>
					<td><?php if($i>0):?><a id="rem-lnk" href="#" onclick="deleteRow(<?=$i?>)">Remove</a><?php endif; ?></td>
				</tr>
				<?php endforeach; ?>				
			</tbody>
		</table>
    <p><input class="btn" type="button" value="Add Item" onclick="addRowPurchaseItems()" /></p>
		<p class="hint muted"><b>Item#(REQUIRED)</b> - any code or ID that an item is identified(ex. 10122-M, 20212-XL). Otherwise, enumerate as 1,2,3 etc....</p>
		<p class="hint muted"><b>Item Name(REQUIRED)</b> - general or common name for this item(ex. Diaper, Tissue, etc...)</p>
		<p class="hint muted"><b>Specification(REQUIRED)</b> - details about the item(ex. Medium, Powder-Free, Vinyl, Latex, 23"x36", etc...)</p>
		<p class="hint muted"><b>Reason(OPTIONAL)</b> - optional; Provide a reason why there is a need to acquire this item.</p>


	</div>
	<div class="">
		<p>Total: <input type="text"  id="total" name="total" style="width:80px;" value="0.00" disabled="disabled"></p>
	</div>



