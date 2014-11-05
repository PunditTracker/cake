$(function(){
  
  if (0 < $("#home").length) {
    //function used to add vote by user
    $('.input_vote_now').live('click', function() {
      if ($('.login').length) {
        $('.login').trigger('click');
        return false;
      }
      var callId = $(this).attr('callId');
      var current = $(this);
      $("ul.vote_choices #errorMessage").text("");  
      $.ajax({
        url: base_url + 'votes/add',
        data: $('#VoteAddForm'+callId).serialize(),
        type: 'POST',
        datatype: 'json',
        success: function(response){          
         
          if (!response.success) {
            var selector = "#VoteAddForm"+callId+" ul.vote_choices #errorMessage";
            $(selector).text("Please select one");
            $('#flashMessage').html(response.message);
            $('#flashMessage').attr("style", "display:block");
            setInterval(function () {
              $('#flashMessage').fadeOut(1000);
            }, 2000);          
            //below code for color box used for login box
            $('.login').trigger('click');
          }
        }
      });
      return false;
    });
  }

  /*
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
  */

  
});
