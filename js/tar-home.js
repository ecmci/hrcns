function onPageLoad(){
  bindHomeControls();
  renderDatepickers();
}

function bindHomeControls(){
  $('#btnSave').on('click',function(){
    switch(form_ops){
      case 'new':
        submitTarLog();
      break;
    }        
  });
  $('#btnNew, #btnNewToo').on('click',function(){
    addMode();
    resetTarForm();
    form_ops = 'new';    
  });
  $('#btnCancel').on('click',function(){
    if(confirm('Sure?')){
      viewMode();
    }    
  });
}

function loadTarLog(id){
  alert(id);  
}

function submitTarLog(){  
  var form = $('form#tar-log-form');
  var settings = form.data('settings');
  settings.submitting = true;
  $.fn.yiiactiveform.validate(form, function (data) {
      var hasError = false;
      $.each(settings.attributes, function () {
        hasError = $.fn.yiiactiveform.updateInput(this, data, form) || hasError;
      });
      $.fn.yiiactiveform.updateSummary(form, data);
      settings.submitting = false;
      if (hasError) {
        alert('Please correct the errors being highlighted in red.');
      } else {
        showPageLoader();
        restConduit('POST',rest_url,form.serialize(),
          function(data, textStatus, jqXHR){
            var id = data;
            if(textStatus === 'success'){
              hidePageLoader();
              alert('Saved.');
              location.reload();
            }  
          },
          function(jqXHR, textStatus, errorThrown){
            hidePageLoader();
            alert('Error ' + jqXHR.status + ': ' + errorThrown + '. ' + jqXHR.responseText); 
          });  
      }
  });
}

function resetTarForm(){
  $(':input','#tar-log-form')
  .not(':button, :submit, :reset, :hidden')
  .val('')
  .removeAttr('checked')
  .removeAttr('selected');
  $('#proc-alert-activity-panel').html('');
}

function viewMode(){
  showList();
  showUpdateButtons();
  hideNewButtons();
  $('#operation').html('View');
}

function addMode(){
  hideList();
  hideUpdateButtons();
  showNewButtons();
  $('#operation').html('New');
}

function hideNewButtons(){
  $('#new-buttons').hide();
}

function showNewButtons(){
  $('#new-buttons').show();
}

function hideUpdateButtons(){
  $('#update-buttons').hide();   
}

function showUpdateButtons(){
  $('#update-buttons').show();    
}

function hideList(){
  $('#home_tar_list').hide();
}

function showList(){
  $('#home_tar_list').show();
}

function renderDatepickers(){
  $('.datepicker').datepicker({
    changeMonth:true,
    changeYear:true
  });
}

function showPageLoader(){
  $('#page-loader').modal('show');
}

function hidePageLoader(){
  $('#page-loader').modal('hide');
}