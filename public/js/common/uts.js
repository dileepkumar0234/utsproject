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
