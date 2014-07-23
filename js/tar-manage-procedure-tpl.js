/**********
 * This JS library contains all functions for TAR procedure template management.
 * Version: 1
 * Last Updated: 7/18/2014
 * Last Updated By: Steven   
 **********/

/* vars */ 
var counter_procedure = 1;
   
/* functions */
function addProcedure(){
  var tpl = "<tr id='proc"+counter_procedure+"'>"+
      "<td><input type='text' name='TarProcedureTemplate[data_struct]["+counter_procedure+"][name]' class='span12'></td>"+
      "<td><textarea name='TarProcedureTemplate[data_struct]["+counter_procedure+"][instruction]'' class='span12'></textarea></td>"+
      "<td id='checklist"+counter_procedure+"'>"+
        "<small>Define the things to be done for this procedure.</small><br><br>"+
        "<ol id='data_struct_"+counter_procedure+"_checklist'>"+                  
          "<li><input type='text' class='span10' name='TarProcedureTemplate[data_struct]["+counter_procedure+"][checklists][]'><a onclick='$(this).closest(\"li\").remove();' href='#' class='btn btn-danger btn-mini'><span class='icon-remove'></span></a></li></ol>"+
        "<a class='btn btn-mini btn-info' href='#' onclick='addChecklist("+counter_procedure+");'><span class='icon-plus'></span> Add Checklist</a>"+
      "</td>"+
      "<td><a onclick='$(this).closest(\"tr\").remove();' href='#' class='btn btn-danger btn-mini'><span class='icon-remove'></span> Remove Procedure</a></td>"+
    "</tr>"; 
  $('#table-procedure').append(tpl);
  counter_procedure++;
}

function addChecklist(proc_idx){
  var tpl = "<li><input name='TarProcedureTemplate[data_struct]["+proc_idx+"][checklists][]' class='span10' type='text'><a class='btn btn-danger btn-mini' href='#' onclick='$(this).closest(\"li\").remove();'><span class='icon-remove'></span></a></li>";
  $("ol#data_struct_"+proc_idx+"_checklist").append(tpl);
}

