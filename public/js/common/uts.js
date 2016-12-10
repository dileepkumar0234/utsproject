var dRam = new Date();
function loginBtnV(jForm){ 
	$("#landeApp").html('');
	$("#adminLogin").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation();
		var u_email    = $("#u_email").val();
		var u_password = $("#u_password").val();
		$.ajax({
			type:'POST',
			url:  baseUrl+'/check-logins-mode',
			data:{userEmail :u_email,pwd:u_password},
			success: function(data){
				if(data.output == "success"){
					window.location = baseUrl+"/all-users";
				}else if(data.output == "fail"){	
					$("#errorMsg").html('Entered inputs are wrong.');
				}
			}
		});
		e.preventDefault();	
	});
}
function tabsUserInfo(userId,processStatus,tabType){
	$('#basicInfoTab').html('<i>Loading...</i>');
	$.ajax({
		type	: 'POST',
		url		: baseUrl+'/tabs-user-info',
		data	: {userId:userId,processStatus:processStatus,tabType:tabType},
		success: function(resHtml){
			if(tabType == 1){
				$('#basicInfoTab').html(resHtml);
			}else if(tabType == 2){
				$('#otherInfoTab').html(resHtml);
			}else if(tabType == 3){
				$('#scheduleTab').html(resHtml);
			}else if(tabType == 4){
				$('#downloadTab').html(resHtml);
			}else if(tabType == 5){
				$('#uploadTab').html(resHtml);
			}else if(tabType == 6){
				$('#fileTab').html(resHtml);
			}else if(tabType == 7){
				$('#paymentTab').html(resHtml);
			}
		}
	});
}
