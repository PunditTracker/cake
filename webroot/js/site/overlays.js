$(function(){    

  function isMobile(selector) {    
    if ($(selector).attr('mobile') == '1') return true;  
  }//end isMobile()
  
  //below code for color box used for login box
  if (mobile) {
    $('.login').live('click', function() {
       window.location.href = '/users/login';
    }); 

    $('.signup').live('click', function() {
       window.location.href = '/users/signup';
    });    
  } else {
    $('.login').colorbox({
        inline:true
    });    

     //below code for color box used for signup box
    $(".signup").colorbox({
      inline:true
    });
  }
    
  
  //below code for color box used to add vote
  $("a.btn_vote_now").live("click", function() {

    if ($('.login').length) {
      $('.login').trigger('click');
      return false;
    }
    var callId = $(this).attr('callId');
    var contentUrl = base_url+'votes/add/' + callId;
    $.colorbox({
      iframe:true,
      width: "320px",
      height: "500px",
      href:contentUrl
    });
    return false;
  });

  //js to open a box for suggesting new pundit by logged in user
  $("#suggestPunditBox").click(function() {
    if (isMobile($(this))) return true;
       
    var contentUrl = this.href;//'suggested_pundits/add';
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"310px",
      href:contentUrl
    });   

    return false; 
    
  });
  
  
  //js to open a box for suggesting new pundit by logged in user 
  $("#suggestPunditBoxByAdmin").click(function() { 
    if (isMobile($(this))) return true;
    var contentUrl = this.href;//base_url+'admin/suggested_pundits/add'; 
    $.colorbox({ 
      iframe:true, 
      width:"676px", 
      height:"745px", 
      href:contentUrl 
    }); 
     return false; 
  }); 
  

  //js to open a box for suggesting new prediction/call by logged in user
  $("#suggestCallBox").live('click', function() {
    /*if ($('.login').length) {
      $('.login').trigger('click');
      return false;
    }*/

    if (isMobile($(this))) return true;

    var punditId = ''; 
    if(typeof($(this).attr('punditId')) != 'undefined') 
    { 
      punditId = $(this).attr('punditId'); 
    } 
    var contentUrl = base_url+'calls/add/'+punditId;
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"410px",
      href:contentUrl
    });
    return false;
  });


  //js to open a box for suggesting new prediction/call by admin
  $("#suggestCallBoxByAdmin").live('click', function() {
    
    if (isMobile($(this))) return true;

    var punditId = ''; 
    if(typeof($(this).attr('punditId')) != 'undefined') 
    { 
      punditId = $(this).attr('punditId'); 
    } 
    var contentUrl = base_url+'admin/calls/add/'+punditId; 
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"592px",
      href:contentUrl
    });
    return false;
  });

  //js for edit pundit suggestion by admin
  $("#editPunditSuggestionLinkId").live('click', function() {
    if (isMobile($(this))) return true;
    var url = this.href;
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"760px",
      href:url
    });
    return false;
  });

  //js for edit pundit prediction by admin
  $("#editCallSuggestionId").live('click', function() {

    if (isMobile($(this))) return true;
    var url = $(this).attr('href');
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"695px",
      href:url
    });
    return false;
  });

  //js for edit user profile info
  $("#editUserProfileInfoLink").live('click', function() {
    var url = base_url + 'users/edit_info';
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"620px",
      href:url
    });
    return false;
  });

  //js to change password
  $("#changeUserPasswordLink").live('click', function() {
    var url = base_url + 'users/reset_password';
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"389px",
      href:url
    });
    return false;
  });

  //js to open a popup for forgot password
  $("#forgotPassword").live('click', function() {

    if (isMobile($(this))) return true;

    var forgotPasswordUrl = base_url + 'users/forgot_password/';
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"232px",
      href:forgotPasswordUrl
    });
    return false;
  });

  //js for edit profile info by admin
  $("#editPunditProfileInfoLink").live('click', function() {
    if (isMobile($(this))) return true;
    var url = this.href;//base_url + 'admin/pundits/edit_info/'+userId;
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"636px",
      href:url
    });
    return false;
  });

  //js for edit user by admin
  $(".editUserByAdmin").live('click', function() {

    if (isMobile($(this))) return true;
    
    var url = $(this).attr('href');
    $.colorbox({
      iframe:true, 
      width:"676px", 
      height:"670px",     
      href:url     
    });  
    return false;
  });

  //js for view user by admin
  $(".viewUserByAdmin").live('click', function() {

    if (isMobile($(this))) return true;

    var url = $(this).attr('href');
    $.colorbox({
      iframe:true, 
      width:"500px", 
      height:"297px",     
      href:url     
    });  
    return false;
  });

  //below code used to edit vote
  $(".editVoteLink").live("click", function() {
    if ($('.login').length) {
      $('.login').trigger('click');
      return false;
    }
    var callId = $(this).attr('callId');
    var contentUrl = base_url+'votes/add/' + callId;    
    $.colorbox({
      iframe:true, 
      width: "320px", 
      height: "500px", 
      href:contentUrl     
    });
    return false;
  });
  
  
   //function used to approve prediction
  $('#SuggestedCallPtvariable, #SuggestedCallBoldness, #SuggestedCallOutcomeId, #SuggestedCallIsCalculated').live('keyup change', function() {
  
    var frm = $("#CallAdminEditForm");
    var data = frm.serialize();
    $.ajax({
      type: 'POST',
      url: frm.attr('action'),
      data: data,
      success: function(response) {
        var yield = '$'+response;
        $("#callYield").text(yield);         
      }
    });
    return false;
  });

  $('#admin-approve-call').live('click', function() {
    $('#call-action').val('approve');
  });

  $('#admin-edit-call').live('click', function() {
    $('#call-action').val('edit');
  });

});//end jquery main()