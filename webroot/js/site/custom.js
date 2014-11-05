$(function(){

  function isMobile(selector) {  
    if ($(selector).attr('mobile') == '1') return true;  
  }//end isMobile()
  
  // Setup the ajax indicator
  //$('body').append('<div id="ajaxBusy"><p><img src="img/loading-icon-trans.gif"></p></div>');
   
   
  $('li:first-child').addClass('first-item'); $('li:last-child').addClass('last-item');

  $('.slider').cycle({
    fx: 'fade',
    speed: 500,
    timeout: 5000,
    pager: '.slider_control'
  });


  $('#why_vote').tooltip({
    track: true,
    delay: 0,
    showURL: false,
    extraClass: "fancy",
    showBody: " - ",
    fade: 250,
    top:20,
    left:-80
  });

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

  //tooltip
  $('.ico_info, .show-tooltip').tooltip({
    track: true,
    delay: 0,
    showURL: false,
    extraClass: "fancy",
    showBody: " - ",
    fade: 250,
    top:20,
    left:-80
  });

  
//login form submit by ajax
$('div#signin input[type=submit]').click(function() { 

  $('div#signin #errorMessage, #errorMessageEmail, #errorMessagePassword').empty();

    var form = $(this).parents('form:first');
    var data = form.serialize();
    var action = form.attr('action');

    $.ajax({
      type: "POST",
      url: action,
      data: data,
      cache: true,
      dataType: "json",
      success: function(response) {      

        if (response.success == 'true') {       
          window.location.href = response.redirect;
        } else {
          $('div#signin #errorMessage').html(response.authFail);
          $('div#signin #errorMessageEmail').html(response.email);
          $('div#signin #errorMessagePassword').html(response.password);
        }

      }
    });

    return false;
  });




//login form submit by ajax
$('div#signup input[type=submit]').click(function() {

  $('div#signup #errorFirstname, #errorLastname, #errorEmail, #errorPassword, #errorPassword2').empty();

    var form = $(this).parents('form:first');
    var data = form.serialize();
    var action = form.attr('action');

    $.ajax({
      type: "POST",
      url: action,
      data: data,
      cache: true,
      dataType: "json",
      success: function(response) {
        if (response.success == 'true') {
          // Commeneted 'users/home' because it doesn't work in mobile browser. 
          window.location.href = base_url;//+'users/home';
        } else {
          $('div#signup #errorMessageFirstName, div#signup #errorMessageLastName, div#signup #errorMessageEmail, div#signup #errorMessagePassword, div#signup #errorMessagePassword2').html("");
           
          if (typeof response.failure.first_name !== "undefined") {
            $('div#signup #errorMessageFirstName').html(response.failure.first_name[0]);
          }
          if (typeof response.failure.last_name !== "undefined") {
            $('div#signup #errorMessageLastName').html(response.failure.last_name[0]);
          }
          if (typeof response.failure.email !== "undefined") {
            $('div#signup #errorMessageEmail').html(response.failure.email[0]);
          }
          if (typeof response.failure.password !== "undefined") {
            $('div#signup #errorMessagePassword').html(response.failure.password[0]);
          }
          if (typeof response.failure.password2 !== "undefined") {
            $('div#signup #errorMessagePassword2').html(response.failure.password2[0]);
          }

        }

      }
    });

    return false;
  });

  $(".pundit_profile").click(function() {
    if ($('.login').length) {
      $('.login').trigger('click');
      return false;
    }
  });

  //Get In Touch
  $('a.suggest_call').live('click', function() {
   /* if ($('.login').length) {
      $('.login').trigger('click');
    }*/
  });

  //function used to add new prediction by user #Help Us Track
  $('.help_submit .btn_submit').live('click', function() {
    /*if ($('.login').length) {
      $('.login').trigger('click');
      return false;
    }*/
  });

  //function used to add new prediction by user #Help Us Track
  $('#footer_submit').live('click', function() {
    if ($('.login').length) {
      $('.login').trigger('click');
      return false;
    }
    var contentUrl = base_url+'suggested_pundits/add';
    $.colorbox({
      iframe:true,
      width:"676px",
      height:"310px",
      href:contentUrl
    });
    return false;
  });
  
  




});//jquery ready end


  // Ajax activity indicator bound to ajax start/stop document events
  $(document).ajaxStart(function(){ 
     
    $('#ajaxBusy').show(); 
  }).ajaxStop(function(){ 
    $('#ajaxBusy').hide();
  });
