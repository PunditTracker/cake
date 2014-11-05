$(function(){ 
  
  //function used to delete suggested pundit
  $('#deleteSuggestionButton').live('click', function() {
    var current = $(this);
    var suggestionId = $(this).attr('suggestionId'); 
    var punditName   = $(this).attr('punditName'); 
    if (confirm("Are you sure want to remove "+punditName+"?")) {
      $.ajax({
        url: base_url + 'admin/suggested_pundits/delete/' + suggestionId,
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
  
  
  //function used to approve suggested pundit
  $('#approveSuggestedButton').live('click', function() {
    var current = $(this);
    var suggestionId = $(this).attr('suggestionId');
    $.ajax({
      url: base_url + 'admin/suggested_pundits/approve/' + suggestionId,
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
    return false;
  });

});
