$(function(){function isMobile(selector){if($(selector).attr('mobile')=='1')return true;}
$('li:first-child').addClass('first-item');$('li:last-child').addClass('last-item');$('.slider').cycle({fx:'fade',speed:500,timeout:5000,pager:'.slider_control'});$('#why_vote').tooltip({track:true,delay:0,showURL:false,extraClass:"fancy",showBody:" - ",fade:250,top:20,left:-80});$('.ico_bubble').tooltip({track:true,delay:0,showURL:false,extraClass:"fancy",showBody:" - ",fade:250,top:25,left:-85});$('.ico_info, .show-tooltip').tooltip({track:true,delay:0,showURL:false,extraClass:"fancy",showBody:" - ",fade:250,top:20,left:-80});$('div#signin input[type=submit]').click(function(){$('div#signin #errorMessage, #errorMessageEmail, #errorMessagePassword').empty();var form=$(this).parents('form:first');var data=form.serialize();var action=form.attr('action');$.ajax({type:"POST",url:action,data:data,cache:true,dataType:"json",success:function(response){if(response.success=='true'){window.location.href=response.redirect;}else{$('div#signin #errorMessage').html(response.authFail);$('div#signin #errorMessageEmail').html(response.email);$('div#signin #errorMessagePassword').html(response.password);}}});return false;});$('div#signup input[type=submit]').click(function(){$('div#signup #errorFirstname, #errorLastname, #errorEmail, #errorPassword, #errorPassword2').empty();var form=$(this).parents('form:first');var data=form.serialize();var action=form.attr('action');$.ajax({type:"POST",url:action,data:data,cache:true,dataType:"json",success:function(response){if(response.success=='true'){window.location.href=base_url;}else{$('div#signup #errorMessageFirstName, div#signup #errorMessageLastName, div#signup #errorMessageEmail, div#signup #errorMessagePassword, div#signup #errorMessagePassword2').html("");if(typeof response.failure.first_name!=="undefined"){$('div#signup #errorMessageFirstName').html(response.failure.first_name[0]);}
if(typeof response.failure.last_name!=="undefined"){$('div#signup #errorMessageLastName').html(response.failure.last_name[0]);}
if(typeof response.failure.email!=="undefined"){$('div#signup #errorMessageEmail').html(response.failure.email[0]);}
if(typeof response.failure.password!=="undefined"){$('div#signup #errorMessagePassword').html(response.failure.password[0]);}
if(typeof response.failure.password2!=="undefined"){$('div#signup #errorMessagePassword2').html(response.failure.password2[0]);}}}});return false;});$(".pundit_profile").click(function(){if($('.login').length){$('.login').trigger('click');return false;}});$('a.suggest_call').live('click',function(){});$('.help_submit .btn_submit').live('click',function(){});$('#footer_submit').live('click',function(){if($('.login').length){$('.login').trigger('click');return false;}
var contentUrl=base_url+'suggested_pundits/add';$.colorbox({iframe:true,width:"676px",height:"310px",href:contentUrl});return false;});});$(document).ajaxStart(function(){$('#ajaxBusy').show();}).ajaxStop(function(){$('#ajaxBusy').hide();});$(function(){$("#changeAvatarLink").click(function(){$('#showChangeAvatarDiv').show();$('#changeAvtarSpan').hide();return false;});});function getvalue(subValue){$("#SuggestedCallCategoryId option").remove();$.ajax({url:base_url+"pundits/categoryList/"+subValue,dataType:"json",cache:true,success:function(data){var option='<option value="" selected="selected">-- Select --</option>';$(option).appendTo("#CallCategoryId");$('#uniform-SuggestedCallCategoryId span').html('-- Select --');$.each(data,function(key,data){option="<option value='"+key+"'>"+data+"</option>";$(option).appendTo("#SuggestedCallCategoryId");});}});}
function getPunditsList(subValue){$("#SuggestedCallUserId option").remove();$.ajax({url:base_url+"pundits/punditList/"+subValue,dataType:"json",cache:true,success:function(data){var option='<option value="" selected="selected">-- Select --</option>';$(option).appendTo("#CallUserId");$('#uniform-SuggestedCallUserId span').html('-- Select --');$.each(data,function(key,data){option="<option value='"+key+"'>"+data+"</option>";$(option).appendTo("#SuggestedCallUserId");});}});}
function getPunditsList(subValue){$("#CallUserId option").remove();$.ajax({url:base_url+"pundits/punditList/"+subValue,dataType:"json",cache:true,success:function(data){var option='<option value="" selected="selected">-- Select --</option>';$(option).appendTo("#CallUserId");$('#uniform-CallUserId span').html('-- Select --');$.each(data,function(key,data){option="<option value='"+key+"'>"+data+"</option>";$(option).appendTo("#CallUserId");});}});}$(function(){$('.approvePredictionButton').live('click',function(){var current=$(this);var predictionId=$(this).attr('id');$.ajax({url:base_url+'admin/suggested_calls/approve/'+predictionId,dataType:"json",success:function(response){if(response.success){current.parents('tr').remove();$('#flashMessage').html(response.message);$('#flashMessage').attr('style',"display:block");setInterval(function(){$('#flashMessage').fadeOut(4000);},4000);}else{if(response.empty){if(confirm(response.message)){current.siblings('#editCallSuggestionId').trigger('click');return false;}else{return false;}}else{$('#flashMessage').html(response.message);$('#flashMessage').attr('style',"display:block");setInterval(function(){$('#flashMessage').fadeOut(4000);},4000);}}}});return false;});$('#deletePredictionButton').live('click',function(){var current=$(this);var predictionId=$(this).attr('predictionId');if(confirm("Are you sure want to remove #"+predictionId+"?")){$.ajax({url:base_url+'admin/suggested_calls/delete/'+predictionId,dataType:"json",success:function(response){current.parents('tr').remove();$('#flashMessage').html(response.message);$('#flashMessage').attr('style',"display:block");setInterval(function(){$('#flashMessage').fadeOut(4000);},4000);}});}
return false;});$("#voteUntil").datepick({dateFormat:'mm/dd/yy'});$('#dateMade,#dateDue').datepick({onSelect:customRangeFirst,showTrigger:'#calImg',dateFormat:'mm/dd/yy'});function customRangeFirst(dates){findDateDiff();if(this.id=='dateMade'){var date=new Date(dates[0].getTime()+(24*60*60*1000));$('#dateDue').datepick('option','minDate',date||null);}else{var date=new Date(dates[0].getTime()-(24*60*60*1000));$('#dateMade').datepick('option','maxDate',date||null);}}
function getValidDate(selector){return $(selector).datepick('getDate')[0];}
function findDateDiff(){var dateDue='';var dateMadeAsString=$('#dateMade').val();var dateMade=getValidDate('#dateMade');if($('#dateDue').length>0){dateDue=getValidDate('#dateDue');}
if(typeof dateDue!='undefined')
{var oneDay=1000*60*60*24;var newDateMade=dateMade;var newDateDue=dateDue;var dateDiff=Math.ceil((newDateDue.getTime()-newDateMade.getTime())/(oneDay));var daysToAdd=Math.round(dateDiff/10);var daysToAddInMilisec=daysToAdd*oneDay;var actualDateInMilisec=newDateMade.getTime()+daysToAddInMilisec;var actualDate=new Date(actualDateInMilisec);var monthNum=actualDate.getMonth()+1;monthNumString=monthNum;if((monthNum.toString()).charAt(1)==''){monthNumString='0'+monthNum;}
var dateNum=actualDate.getDate();dateNumString=dateNum;if((dateNum.toString()).charAt(1)==''){dateNumString='0'+dateNum;}
var YearNum=actualDate.getFullYear();var voteUntillDate=monthNumString+'/'+dateNumString+'/'+YearNum.toString().slice(2);if(voteUntillDate==dateMadeAsString){var redate=actualDate;redate=new Date(redate.getTime()+(24*60*60*1000));var YearNum=redate.getFullYear();var monthNum=redate.getMonth()+1;monthNumString=monthNum;if((monthNum.toString()).charAt(1)==''){monthNumString='0'+monthNum;}
var dateNum=redate.getDate();dateNumString=dateNum;if((dateNum.toString()).charAt(1)==''){dateNumString='0'+dateNum;}
voteUntillDate=monthNumString+'/'+dateNumString+'/'+YearNum.toString().slice(2);}
$('#voteUntil').val(voteUntillDate);}}
$("#dateCreated").datepick({dateFormat:'mm/dd/yy'});$("a.uploadCsvLink").live("click",function(){parent.window.location=base_url+'admin/calls/upload_csv';setTimeout(parent.$.fn.colorbox.close,1000);return false;});});$(function(){$('#deleteSuggestionButton').live('click',function(){var current=$(this);var suggestionId=$(this).attr('suggestionId');var punditName=$(this).attr('punditName');if(confirm("Are you sure want to remove "+punditName+"?")){$.ajax({url:base_url+'admin/suggested_pundits/delete/'+suggestionId,dataType:"json",success:function(response){current.parents('tr').remove();$('#flashMessage').html(response.message);$('#flashMessage').show();setInterval(function(){$('#flashMessage').fadeOut(1000);},2000);}});}
return false;});$('#approveSuggestedButton').live('click',function(){var current=$(this);var suggestionId=$(this).attr('suggestionId');$.ajax({url:base_url+'admin/suggested_pundits/approve/'+suggestionId,dataType:"json",success:function(response){current.parents('tr').remove();$('#flashMessage').html(response.message);$('#flashMessage').show();setInterval(function(){$('#flashMessage').fadeOut(1000);},2000);}});return false;});});$(function(){if(0<$("#home").length){$('.input_vote_now').live('click',function(){if($('.login').length){$('.login').trigger('click');return false;}
var callId=$(this).attr('callId');var current=$(this);$("ul.vote_choices #errorMessage").text("");$.ajax({url:base_url+'votes/add',data:$('#VoteAddForm'+callId).serialize(),type:'POST',datatype:'json',success:function(response){if(!response.success){var selector="#VoteAddForm"+callId+" ul.vote_choices #errorMessage";$(selector).text("Please select one");$('#flashMessage').html(response.message);$('#flashMessage').attr("style","display:block");setInterval(function(){$('#flashMessage').fadeOut(1000);},2000);$('.login').trigger('click');}}});return false;});}});$(function(){$('#suggestedPunditTab').live('click',function(){$.ajax({url:base_url+'admin/suggested_pundits/index',success:function(response){$("#suggestedPunditsDiv").empty();$("#suggestedPunditsDiv").html(response);}});return false;});$('#suggestedPredictionTab').live('click',function(){$.ajax({url:base_url+'admin/suggested_calls/index',complete:loadTooltip,success:function(response){$("#suggestedPunditsDiv").empty();$("#suggestedPunditsDiv").html(response);}});return false;});$('#approvedPredictionTab').live('click',function(){$.ajax({url:base_url+'admin/calls/all',complete:loadTooltip,success:function(response){$("#suggestedPunditsDiv").empty();$("#suggestedPunditsDiv").html(response);}});return false;});$('#adminReviewAllUsersTab').live('click',function(){$.ajax({url:base_url+'admin/users/index',success:function(response){$("#suggestedPunditsDiv").empty();$("#suggestedPunditsDiv").html(response);}});return false;});$('#adminAllCategoriesTab').live('click',function(){$.ajax({url:base_url+'admin/categories/index',success:function(response){$("#suggestedPunditsDiv").empty();$("#suggestedPunditsDiv").html(response);}});return false;});$('#deleteUserByAdmin').live('click',function(){var current=$(this);var userId=$(this).attr('userId');var userName=$(this).attr('userName');if(confirm("Are you sure want to delete "+userName+"?")){$.ajax({url:base_url+'admin/users/delete/'+userId,dataType:"json",success:function(response){current.parents('tr').remove();$('#flashMessage').html(response.message);$('#flashMessage').show();setInterval(function(){$('#flashMessage').fadeOut(1000);},2000);}});}
return false;});});function loadTooltip()
{$('li:first-child').addClass('first-item');$('li:last-child').addClass('last-item');$('.ico_bubble').tooltip({track:true,delay:0,showURL:false,extraClass:"fancy",showBody:" - ",fade:250,top:25,left:-85});}
$(function(){function isMobile(selector){if($(selector).attr('mobile')=='1')return true;}
if(mobile){$('.login').live('click',function(){window.location.href='/users/login';});$('.signup').live('click',function(){window.location.href='/users/signup';});}else{$('.login').colorbox({inline:true});$(".signup").colorbox({inline:true});}
$("a.btn_vote_now").live("click",function(){if($('.login').length){$('.login').trigger('click');return false;}
var callId=$(this).attr('callId');var contentUrl=base_url+'votes/add/'+callId;$.colorbox({iframe:true,width:"320px",height:"500px",href:contentUrl});return false;});$("#suggestPunditBox").click(function(){if(isMobile($(this)))return true;var contentUrl=this.href;$.colorbox({iframe:true,width:"676px",height:"310px",href:contentUrl});return false;});$("#suggestPunditBoxByAdmin").click(function(){if(isMobile($(this)))return true;var contentUrl=this.href;$.colorbox({iframe:true,width:"676px",height:"745px",href:contentUrl});return false;});$("#suggestCallBox").live('click',function(){if(isMobile($(this)))return true;var punditId='';if(typeof($(this).attr('punditId'))!='undefined')
{punditId=$(this).attr('punditId');}
var contentUrl=base_url+'calls/add/'+punditId;$.colorbox({iframe:true,width:"676px",height:"410px",href:contentUrl});return false;});$("#suggestCallBoxByAdmin").live('click',function(){if(isMobile($(this)))return true;var punditId='';if(typeof($(this).attr('punditId'))!='undefined')
{punditId=$(this).attr('punditId');}
var contentUrl=base_url+'admin/calls/add/'+punditId;$.colorbox({iframe:true,width:"676px",height:"592px",href:contentUrl});return false;});$("#editPunditSuggestionLinkId").live('click',function(){if(isMobile($(this)))return true;var url=this.href;$.colorbox({iframe:true,width:"676px",height:"760px",href:url});return false;});$("#editCallSuggestionId").live('click',function(){if(isMobile($(this)))return true;var url=$(this).attr('href');$.colorbox({iframe:true,width:"676px",height:"695px",href:url});return false;});$("#editUserProfileInfoLink").live('click',function(){var url=base_url+'users/edit_info';$.colorbox({iframe:true,width:"676px",height:"620px",href:url});return false;});$("#changeUserPasswordLink").live('click',function(){var url=base_url+'users/reset_password';$.colorbox({iframe:true,width:"676px",height:"389px",href:url});return false;});$("#forgotPassword").live('click',function(){if(isMobile($(this)))return true;var forgotPasswordUrl=base_url+'users/forgot_password/';$.colorbox({iframe:true,width:"676px",height:"232px",href:forgotPasswordUrl});return false;});$("#editPunditProfileInfoLink").live('click',function(){if(isMobile($(this)))return true;var url=this.href;$.colorbox({iframe:true,width:"676px",height:"636px",href:url});return false;});$(".editUserByAdmin").live('click',function(){if(isMobile($(this)))return true;var url=$(this).attr('href');$.colorbox({iframe:true,width:"676px",height:"670px",href:url});return false;});$(".viewUserByAdmin").live('click',function(){if(isMobile($(this)))return true;var url=$(this).attr('href');$.colorbox({iframe:true,width:"500px",height:"297px",href:url});return false;});$(".editVoteLink").live("click",function(){if($('.login').length){$('.login').trigger('click');return false;}
var callId=$(this).attr('callId');var contentUrl=base_url+'votes/add/'+callId;$.colorbox({iframe:true,width:"320px",height:"500px",href:contentUrl});return false;});$('#SuggestedCallPtvariable, #SuggestedCallBoldness, #SuggestedCallOutcomeId, #SuggestedCallIsCalculated').live('keyup change',function(){var frm=$("#SuggestedcallAdminEditForm");var data=frm.serialize();$.ajax({type:'POST',url:frm.attr('action'),data:data,success:function(response){var yield='$'+response;$("#SuggestedcallYield").text(yield);}});return false;});$('#admin-approve-call').live('click',function(){$('#call-action').val('approve');});$('#admin-edit-call').live('click',function(){$('#call-action').val('edit');});});