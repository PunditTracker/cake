$(function(){
  
  //js used to change the avatar
  $("#changeAvatarLink").click(function() {
    $('#showChangeAvatarDiv').show();
    $('#changeAvtarSpan').hide();
    return false;
  });

  
});//end jquery ready



 //function used by pundit onchange event while prediction suggestion
function getvalue(subValue) {
  $("#SuggestedCallCategoryId option").remove();
  $.ajax({
  //type: "POST",
    url: base_url + "pundits/categoryList/" + subValue,
    dataType: "json",
    cache: true,
    success: function(data) {
      // The following three lines are to reset Uniform so that it displays correctly if select is dynamically updated
      var option = '<option value="" selected="selected">-- Select --</option>';
      $(option).appendTo("#CallCategoryId");
      $('#uniform-SuggestedCallCategoryId span').html('-- Select --');
      $.each(data, function(key,data) {
        option = "<option value='"+key+"'>"+data+"</option>";
        $(option).appendTo("#SuggestedCallCategoryId");
      });
    }
  });
}


//function used to return pundit list on category change
function getPunditsList(subValue) {
  $("#SuggestedCallUserId option").remove();
  $.ajax({
    url: base_url + "pundits/punditList/" + subValue,
    dataType: "json",
    cache: true,
    success: function(data) {
      // The following three lines are to reset Uniform so that it displays correctly if select is dynamically updated
      var option = '<option value="" selected="selected">-- Select --</option>';
      $(option).appendTo("#CallUserId");
      $('#uniform-SuggestedCallUserId span').html('-- Select --');
      $.each(data, function(key,data) {
        option = "<option value='"+key+"'>"+data+"</option>";
        $(option).appendTo("#SuggestedCallUserId");
      });
    }
  });
}

//function used to return admin pundit list on category change
function getPunditsList(subValue) {
  $("#CallUserId option").remove();
  $.ajax({
    url: base_url + "pundits/punditList/" + subValue,
    dataType: "json",
    cache: true,
    success: function(data) {
      // The following three lines are to reset Uniform so that it displays correctly if select is dynamically updated
      var option = '<option value="" selected="selected">-- Select --</option>';
      $(option).appendTo("#CallUserId");
      $('#uniform-CallUserId span').html('-- Select --');
      $.each(data, function(key,data) {
        option = "<option value='"+key+"'>"+data+"</option>";
        $(option).appendTo("#CallUserId");
      });
    }
  });
}