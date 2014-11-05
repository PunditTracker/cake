$(function(){   
  /*
  $('#userProfileLiveButton').live('click', function() {
    var userId = $(this).attr('userId');
    $.ajax({
      url: base_url + 'users/live_call/' + userId,      
      success: function(response) {
        $("#CallTable").empty();  
        $("#CallTable").html(response);        
      }
    });
    //return false;
  });


  $('#userProfileArchieveButton').live('click', function() {   
    var userId = $(this).attr('userId');
    $.ajax({
      url: base_url + 'users/archive_call/' + userId,      
      success: function(response) {
        $("#CallTable").empty();  
        $("#CallTable").html(response);       
      }
    });
    //return false;
  });
  */
  
  $('#suggestedPunditTab').live('click', function() {
    $.ajax({
      url: base_url + 'admin/suggested_pundits/index',      
      success: function(response) {
        $("#suggestedPunditsDiv").empty();  
        $("#suggestedPunditsDiv").html(response);   
      }
    });
    return false;
  });


  $('#suggestedPredictionTab').live('click', function() {  
    $.ajax({
      url: base_url + 'admin/suggested_calls/index', 
      complete: loadTooltip,
      success: function(response) {
        $("#suggestedPunditsDiv").empty();  
        $("#suggestedPunditsDiv").html(response);   
      }
    });
    return false;
  });
  
  $('#approvedPredictionTab').live('click', function() {   
    $.ajax({
      url: base_url + 'admin/calls/all',
      complete: loadTooltip,      
      success: function(response) {
        $("#suggestedPunditsDiv").empty();  
        $("#suggestedPunditsDiv").html(response);   
      }
    });
    return false;
  });

  $('#adminReviewAllUsersTab').live('click', function() {   
    $.ajax({
      url: base_url + 'admin/users/index',      
      success: function(response) {
        $("#suggestedPunditsDiv").empty();  
        $("#suggestedPunditsDiv").html(response);   
      }
    });
    return false;
  });

  $('#adminAllCategoriesTab').live('click', function() {   
    $.ajax({
      url: base_url + 'admin/categories/index',      
      success: function(response) {
        $("#suggestedPunditsDiv").empty();  
        $("#suggestedPunditsDiv").html(response);   
      }
    });
    return false;
  });


  //function used to delete user by admin
  $('#deleteUserByAdmin').live('click', function() {
    var current = $(this);
    var userId = $(this).attr('userId'); 
    var userName = $(this).attr('userName'); 
    if (confirm("Are you sure want to delete "+userName+"?")) {
      $.ajax({
        url: base_url + 'admin/users/delete/' + userId,
        dataType: "json",
        success: function(response) {
          current.parents('tr').remove();
          $('#flashMessage').html(response.message); 
          $('#flashMessage').show();   
          setInterval(function () {
            $('#flashMessage').fadeOut(1000);
          }, 2000);
        }
      });
    }
    return false;
  });

  /*
  //js for edit user by admin
  $(".editUserByAdmin").live('click', function() {
   var url = $(this).attr('href');
      $.colorbox({
        iframe:true, 
        width:"700px", 
        height:"680px",     
        href:url     
      });  
     return false;
  });


  //js for view user by admin
  $(".viewUserByAdmin").live('click', function() {
   var url = $(this).attr('href');
      $.colorbox({
        iframe:true, 
        width:"500px", 
        height:"500px",     
        href:url     
      });  
     return false;
  });
  */
  

});

function loadTooltip() 
{
  $('li:first-child').addClass('first-item'); $('li:last-child').addClass('last-item');
  
  $('.ico_bubble').tooltip({
    track: true,
    delay: 0,
    showURL: false,
    extraClass: "fancy",
    showBody: " - ",
    fade: 250,
    top:25,
    left:-85
  });
}
