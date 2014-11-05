$(function(){   
  

  $('#punditProfileLiveButton').live('click', function() {
    var current = $(this);
    var punditId = $(this).attr('punditId');
    $.ajax({
      url: base_url + 'pundits/live_call/' + punditId,      
      success: function(response) {
        $("#CallTable").empty();  
        $("#CallTable").html(response);   
        
      }
    });
    //return false;
  });


  $('#punditProfileArchieveButton').live('click', function() {    

    var current = $(this);
    var punditId = $(this).attr('punditId');
    $.ajax({
      url: base_url + 'pundits/archive_call/' + punditId,      
      success: function(response) {
        $("#CallTable").empty();  
        $("#CallTable").html(response);   
        
      }
    });
    //return false;
  });
  

});
