$(function(){

  //function used to approve prediction
  $('.approvePredictionButton').live('click', function() {
    var current = $(this);
    var predictionId = $(this).attr('id');
    
    $.ajax({
      url: base_url + 'admin/suggested_calls/approve/' + predictionId,
      dataType: "json",
      success: function(response) {
        if (response.success) {
          current.parents('tr').remove();
          $('#flashMessage').html(response.message); 
          $('#flashMessage').attr('style', "display:block");   
          setInterval(function () {
            $('#flashMessage').fadeOut(4000);
          }, 4000);

        } else {
          if (response.empty) {
            if (confirm(response.message)) {
              current.siblings('#editCallSuggestionId').trigger('click');
              return false;
            } else {
              return false;
            }
          } else {
            $('#flashMessage').html(response.message); 
            $('#flashMessage').attr('style', "display:block");   
            setInterval(function () {
              $('#flashMessage').fadeOut(4000);
            }, 4000);
          }
        }
      }
    });
    return false;
  });
  
  
  //function used to delete prediction
  $('#deletePredictionButton').live('click', function() {
    var current = $(this);
    var predictionId = $(this).attr('predictionId');   

    if (confirm("Are you sure want to remove #"+predictionId+"?")) {
      $.ajax({
        url: base_url + 'admin/suggested_calls/delete/' + predictionId,
        dataType: "json",
        success: function(response) {
          current.parents('tr').remove();
          $('#flashMessage').html(response.message); 
          $('#flashMessage').attr('style', "display:block");      
          setInterval(function () {
            $('#flashMessage').fadeOut(4000);
          }, 4000);
        }
      });
    }
    return false;
  });


  $("#voteUntil").datepick({dateFormat: 'mm/dd/yy'});
  
  $('#dateMade,#dateDue').datepick({ 
    onSelect: customRangeFirst, showTrigger: '#calImg', dateFormat: 'mm/dd/yy'}); 
     
  function customRangeFirst(dates) {  
    findDateDiff();
    if (this.id == 'dateMade') { 
      var date = new Date(dates[0].getTime() + (24 * 60 * 60 * 1000));
      $('#dateDue').datepick('option', 'minDate', date || null);      
    }  else {
      var date = new Date(dates[0].getTime() - (24 * 60 * 60 * 1000));
      $('#dateMade').datepick('option', 'maxDate', date || null);  
    }    
  }
     
  //$("#voteUntil").datepick({onSelect: findDateDiff});

  /*$('#voteUntil').focusin(function() {
    var dateMade = getValidDate('#dateMade');
    if (typeof dateMade != 'undefined') {        
      findDateDiff();
      dateMade = new Date(dateMade.getTime() + (24 * 60 * 60 * 1000));
      var dateDue = getValidDate('#dateDue');

      $('#voteUntil').datepick('option', 'minDate', dateMade);
      $('#voteUntil').datepick('option', 'maxDate', dateDue);    
    }
  });*/
  
  
  function getValidDate(selector) {
    
    return $(selector).datepick('getDate')[0];
  }

  /*$('#voteUntil, #dateDue').datepick({ 
    //onSelect: findDateDiff});
    onSelect: customRange, showTrigger: '#calImg'}); 
     

  function customRange(dates) {
    console.log(dates[0]);
    if (this.id == 'dateDue') { 
      //findDateDiff();
      $('#voteUntil').datepick('option', 'maxDate', dates[0] || null); 
    } 
    else { 
        //$('#dateDue').datepick('option', 'minDate', dates[0] || null); 
    } 
  }*/

  // function used to find vote untill date
  function findDateDiff() {
    var dateDue = '';
    var dateMadeAsString = $('#dateMade').val();
    //console.log(dateMadeAsString);
    var dateMade = getValidDate('#dateMade');
    
    if($('#dateDue').length > 0) {
      dateDue = getValidDate('#dateDue');
      //dateDue = $('#dateDue').val();
    }
   
    if (typeof dateDue != 'undefined')
    {
      //var dateMadeSplit = dateMade.split("/"); 
      //var dateDueSplit = dateDue.split("/"); 

      //Total time for one day
      var oneDay = 1000*60*60*24; 
      var newDateMade = dateMade;
      var newDateDue = dateDue;
      //date format(Fullyear,month,date) 
      //so we have to covert date in this format
      //var newDateMade = new Date(dateMadeSplit[2],dateMadeSplit[0]-1,dateMadeSplit[1]);
      //var newDateDue = new Date(dateDueSplit[2],dateDueSplit[0]-1,dateDueSplit[1]);
//console.log(newDateMade);
      //Calculate difference between the two dates, and convert to days
      var dateDiff = Math.ceil((newDateDue.getTime() - newDateMade.getTime())/(oneDay)); 
      
      //calculate 1/10th of day diff
      var daysToAdd = Math.round(dateDiff/10);
      var daysToAddInMilisec = daysToAdd * oneDay;
      //getting date
      var actualDateInMilisec = newDateMade.getTime() + daysToAddInMilisec;
      var actualDate = new Date(actualDateInMilisec);

      //creating valid month
      var monthNum = actualDate.getMonth() + 1;
      monthNumString = monthNum;
      if ((monthNum.toString()).charAt(1) == '') {
        monthNumString = '0' + monthNum;
      }
      //creating valid date
      var dateNum = actualDate.getDate();
      dateNumString = dateNum;
      if ((dateNum.toString()).charAt(1) == '') {
        dateNumString = '0' + dateNum;
      }
      //creating valid year
      var YearNum = actualDate.getFullYear();
      var voteUntillDate = monthNumString +'/'+ dateNumString +'/'+ YearNum.toString().slice(2);
      
      if (voteUntillDate == dateMadeAsString) {
        var redate = actualDate;
        redate = new Date(redate.getTime() + (24 * 60 * 60 * 1000));

        var YearNum=redate.getFullYear();
        //var themonth=(redate.getMonth() + 1);
        //var thetoday=redate.getDate();
        
        var monthNum = redate.getMonth() + 1;
        monthNumString = monthNum;
        if ((monthNum.toString()).charAt(1) == '') {
          monthNumString = '0' + monthNum;
        }
        //creating valid date
        var dateNum = redate.getDate();
        dateNumString = dateNum;
        if ((dateNum.toString()).charAt(1) == '') {
          dateNumString = '0' + dateNum;
        }
        voteUntillDate = monthNumString +'/'+ dateNumString +'/'+ YearNum.toString().slice(2);    
      }
      //append vote untill date in DOM
      
      $('#voteUntil').val(voteUntillDate);
    }
  }

  //datepic for normal user created date while adding prediction
  $("#dateCreated").datepick({dateFormat: 'mm/dd/yy'});


    //below code for add calls via csv
  $("a.uploadCsvLink").live("click", function() {
    
    parent.window.location = base_url+'admin/calls/upload_csv';        
   
    setTimeout(parent.$.fn.colorbox.close, 1000);  
   
    return false;
  });


});
