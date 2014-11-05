$(function(){  


  $('#verticalLiveButton').live('click', function() {
    var current = $(this);
    var categoryId = $(this).attr('categoryId');
    $.ajax({
      url: base_url + 'categories/live_call/' + categoryId,      
      success: function(response) {
        $("#CallTable").empty();  
        $("#CallTable").html(response);   
        
      }
    });
    //return false;
  });


  $('#verticalArchieveButton').live('click', function() {    

    var current = $(this);
    var categoryId = $(this).attr('categoryId');
    $.ajax({
      url: base_url + 'categories/archive_call/' + categoryId,      
      success: function(response) {
        $("#CallTable").empty();  
        $("#CallTable").html(response);   
        
      }
    });
    //return false;
  });
 
});
