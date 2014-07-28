/**********
 * This JS library contains all functions for TAR alerts template management.
 * Version: 1
 * Last Updated: 7/21/2014
 * Last Updated By: Steven   
 **********/

  
/* functions */
function addAlert(){
  var tpl = "<tr>"+
      "<td><select id='TarAlertsTemplate_data_struct_"+counter_alert+"_age' name='TarLog[data_struct_alerts]["+counter_alert+"][age]'' class='span6 datepicker'>"+
          "<option value='1'>1</option>"+
          "<option value='2'>2</option>"+
          "<option value='3'>3</option>"+
          "<option value='4'>4</option>"+
          "<option value='5'>5</option>"+
          "<option value='6'>6</option>"+
          "<option value='7'>7</option>"+
          "<option value='8'>8</option>"+
          "<option value='9'>9</option>"+
          "<option value='1'>10</option>"+
          "<option value='11'>11</option>"+
          "<option value='12'>12</option>"+
          "<option value='13'>13</option>"+
          "<option value='14'>14</option>"+
          "<option value='15'>15</option>"+
          "<option value='16'>16</option>"+
          "<option value='17'>17</option>"+
          "<option value='18'>18</option>"+
          "<option value='19'>19</option>"+
          "<option value='20'>20</option>"+
          "<option value='21'>21</option>"+
          "<option value='22'>22</option>"+
          "<option value='23'>23</option>"+
          "<option value='24'>24</option>"+
          "<option value='25'>25</option>"+
          "<option value='26'>26</option>"+
          "<option value='27'>27</option>"+
          "<option value='28'>28</option>"+
          "<option value='29'>29</option>"+
          "<option value='30'>30</option>"+
          "<option value='31'>31</option>"+
          "<option value='32'>32</option>"+
          "<option value='33'>33</option>"+
          "<option value='34'>34</option>"+
          "<option value='35'>35</option>"+
          "<option value='36'>36</option>"+
          "<option value='37'>37</option>"+
          "<option value='38'>38</option>"+
          "<option value='39'>39</option>"+
          "<option value='40'>40</option>"+
          "<option value='41'>41</option>"+
          "<option value='42'>42</option>"+
          "<option value='43'>43</option>"+
          "<option value='44'>44</option>"+
          "<option value='45'>45</option>"+
          "</select> day(s) old or more</td>"+
      "<td><select id='TarAlertsTemplate_data_struct_0_status' name='TarLog[data_struct_alerts]["+counter_alert+"][status]'' class='span12'>"+
        "<option value='1'>Should be applied</option>"+
        "<option value='2'>Under Review</option>"+
        "<option value='3'>Deferred</option>"+
        "<option value='4'>Denied/Rejected</option>"+
        "<option value='5'>Approved</option>"+
        "</select></td>"+
      "<td>"+
        "<ul id='data_struct_"+counter_alert+"_emails'>"+
          "<li><input type='text' class='span10' name='TarLog[data_struct_alerts]["+counter_alert+"][email][]'><a class='btn btn-danger btn-mini' href='#'' onclick='$(this).closest(\"li\").remove();'><span class='icon-remove'></span></a></li>"+
        "</ul>"+
        "<p><a class='btn btn-info btn-mini' href='#'' onclick='addEmail("+counter_alert+");'><span class='icon-plus'></span> Add Email</a></p>"+
      "</td>"+
      "<td><a class='btn btn-danger btn-mini' href='#'' onclick='$(this).closest(\"tr\").remove();'><span class='icon-remove'></span> Remove Alert</a></td>"+
    "</tr>";
  $('#table-alert').append(tpl);
  counter_alert++;
}

function addEmail(alert_idx){
  var tpl = "<li><input name='TarLog[data_struct_alerts]["+alert_idx+"][email][]'' type='text' class='span10'><a onclick='$(this).closest(\"li\").remove();'' href='#' class='btn btn-danger btn-mini'><span class='icon-remove'></span></a></li>";
  $("ul#data_struct_"+alert_idx+"_emails").append(tpl);
}