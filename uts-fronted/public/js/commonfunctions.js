function adminLogout(){
	$.ajax({
		type:'POST',
		url:  adminBaseUrl+'/admin-logout',
		data:{logout:'adminsession'},
		success: function(data){
			$('#hidden_logout').modal('hide');
			if(data.output=='1'){				
				window.location = adminBaseUrl;
			}
		}
	});
}

function logoutUser(usermode){
	if(usermode=='admin'){
		$('#hidden_logout').modal('show');	
	}
}
function editClient(id, firstName, lastName, mobile, userStatus){
	$('#editClientModal').modal('show');	
	$("#clientId").val(id);
	$("#editFirstName").val(firstName);
	$("#editLastName").val(lastName);
	$("#edit_user_status").val(userStatus);
	$("#editMobileNumber").val(mobile);
}
function editAd(adId, clientId, adName, adStatus, adImage){
	$('#editClientModal').modal('show');	
	$("#editAdClientId").val(clientId);
	$("#editAdName").val(adName);
	$("#editAdStatus").val(adStatus);
	$("#hidHideImage").val(adImage);
	$("#adId").val(adId);
	if(adImage!=""){
		$("#hidImage").html('<img src="'+adminBasePath+'/uploads/'+adImage+'" height="40px;" width="40px;">');
	}
	
}

function loginChecking(jForm){ 
	var d 		= new Date();
	var time 	= d.getTime();
	$("#loginForm").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation();

		var u_email    = $("#u_email").val();
		var u_password = $("#u_password").val();
		$.ajax({
			type:'POST',
			url:  adminBaseUrl+'/checking-login?sRch='+time,
			data:{u_email:u_email,u_password:u_password},
			success: function(data){
				$("#errorLogin").html('');
				if(data.output == "emailnotinrecord"){
					$("#errorLogin").html('Entered email is not in records');
				}else if(data.output == "fail"){	
					$("#errorLogin").html('Please email is requried');						
				}else if(data.output == "wrongdeatils"){
					$("#errorLogin").html('Entered email or password are wrong');	
				}else if(data.output == "success"){
					window.location = adminBaseUrl+'/ad-management';
				}
			}
		});
		e.preventDefault();	
	});	
}

function hideAuthorMode(){
	var d 		= new Date();
	var time 	= d.getTime();
	var au_id = $("#hid_au_id").val();
	var status = $("#hid_status").val();
	$.ajax({
		type:'POST',
		url:  adminBaseUrl+'/update-author-status?sRch='+time,
		data:{status:status,au_id:au_id},
		success: function(data){
			$("#status_common").modal('hide');
			if(data.output=='fail'){
				$("#title-message").html("Status Confirmation");
				$("#alert-message").html("Server problem.");
				$("#hidden_common").modal('show');	
			}else if(data.output=='success'){
				$("#hidden_common").modal('hide');	
				window.location=adminBaseUrl+"/author-management";
			}				
		}
	});
}

function addClient(){
	var d 		= new Date();
	var time 	= d.getTime();
	var d 		= new Date();
	var time 	= d.getTime();
	 $("#addClientForm").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation(); 
		$("#emailExist").html("");

		var firstName       = $("#firstName").val();
		var lastName        = $("#lastName").val();
		var email           = $("#email").val();
		var mobileNumber    = $("#mobileNumber").val();
		var pwd             = $("#password").val();
		var cpwd            = $("#confirmPassword").val();
		var user_status     = $("#user_status").val();
		$.ajax({
			type:'POST',
			url:  adminBaseUrl+'/add-client?sRch='+time,
			data:{user_first_name:firstName,user_last_name:lastName,user_email:email,user_password:pwd,user_status:user_status,user_mobile_number:mobileNumber},
			success: function(data){
				if(data.output=='fail'){
					$("#emailExist").html("Server Problem.");
				}else if(data.output=='NotFound'){
					$("#emailExist").html("Email Exist.");
				}else if(data.output=='success'){
					$("#firstName").val('');
					$("#lastName").val('');
					$("#email").val('');
					$("#password").val('');
					$("#confirmPassword").val('');
					$("#user_status").val('');
					$("#mobileNumber").val('');

					$("#emailExist").html("");
					window.location=adminBaseUrl+"/client-management";
				}				
			}
		});
		 e.preventDefault();	
	}); 
}
function updateClient(formid){
	var d 		= new Date();
	var time 	= d.getTime();
	var d 		= new Date();
	var time 	= d.getTime();
	 $("#editClientForm").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation(); 
		var firstName       = $("#editFirstName").val();
		var lastName        = $("#editLastName").val();
		var mobileNumber    = $("#editMobileNumber").val();
		var user_status     = $("#edit_user_status").val();
		var clientId        = $("#clientId").val();
		$.ajax({
			type:'POST',
			url:  adminBaseUrl+'/add-client?sRch='+time,
			data:{user_first_name:firstName,user_last_name:lastName,user_status:user_status,user_mobile_number:mobileNumber,clientId:clientId},
			success: function(data){
				if(data.output=='fail'){
					$("#emailExist").html("Server Problem.");
				}else if(data.output=='NotFound'){
					$("#emailExist").html("Email Exist.");
				}else if(data.output=='success'){
					$("#clientId").val('');
					$("#editFirstName").val('');
					$("#editLastName").val('');
					$("#edit_user_status").val('');
					$("#editMobileNumber").val('');
					window.location=adminBaseUrl+"/client-management";
				}				
			}
		});
		 e.preventDefault();	
	}); 
}

function updateClientStatus(clientId, status, userType){
	var d 		= new Date();
	var time 	= d.getTime();
	var clientId   = clientId;
	var status = status;
	$.ajax({
		type:'POST',
		url:  adminBaseUrl+'/update-user-status?sRch='+time,
		data:{status:status,clientId:clientId},
		success: function(data){
			$("#status_common").modal('hide');
			if(data.output=='fail'){
				$("#title-message").html("Status Confirmation");
				$("#alert-message").html("Server problem.");
				$("#hidden_common").modal('show');	
			}else if(data.output=='success'){
				$("#hidden_common").modal('hide');	
				if(userType==2){
					window.location=adminBaseUrl+"/client-management";
				}else if(userType==3){
					window.location=adminBaseUrl+"/user-management";
				}
			}				
		}
	});
}

function addAd(){
	var d 		= new Date();
	var time 	= d.getTime();
	var d 		= new Date();
	var time 	= d.getTime();
	$("#errorMsg").html("");
	 $("#addAdForm").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation(); 
		var adName       = $("#adName").val();
		var adStatus     = $("#adStatus").val();
		var adClientId   = $("#adClientId").val();
		var advalidDate  = $("#advalidDate").val();
		var file_data    = $('#image').prop('files')[0];
		var form_data    = new FormData();
		form_data.append('adName', adName);
		form_data.append('image', file_data);
		form_data.append('adStatus', adStatus);
		form_data.append('clientId', adClientId);
		form_data.append('advalidDate', advalidDate);
		
		$.ajax({
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data, 
			type:'POST',
			url:  adminBaseUrl+'/add-ad?sRch='+time,
			success: function(data){
				if(data.output=='fail'){
					$("#errorMsg").html("Some thing is wrong.");
				}else if(data.output=='success'){
					$("#adName").val('');
					$("#adStatus").val('');
					$("#adImage").val('');
					$("#adClientId").val('');
					$("#advalidDate").val('');
					$("#errorMsg").html("");
					window.location=adminBaseUrl+"/ad-management";
				}				
			}
		});
		e.preventDefault();	
	}); 
}

function updateAd(){
	var d 		= new Date();
	var time 	= d.getTime();
	var d 		= new Date();
	var time 	= d.getTime();
	$("#editAdForm").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation(); 

		var adId            = $("#adId").val();
		var adStatus        = $("#editAdStatus").val();
		var adName          = $("#editAdName").val();
		var adClientId      = $("#editAdClientId").val();
		var advalidDate     = $("#editAdvalidDate").val();
		var hidHideImage    = $("#hidHideImage").val();
		var file_data       = $('#editImage').prop('files')[0];
		var form_data       = new FormData();
		form_data.append('adName', adName);
		form_data.append('image', file_data);
		form_data.append('adStatus', adStatus);
		form_data.append('clientId', adClientId);
		form_data.append('adId', adId);
		form_data.append('hidImage', hidHideImage);
		form_data.append('advalidDate', advalidDate);

		
		$.ajax({
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data, 
			type:'POST',
			url:  adminBaseUrl+'/add-ad?sRch='+time,
			success: function(data){
				if(data.output=='fail'){
					$("#errorMsg1").html("Some thing is wrong.");
				}else if(data.output=='success'){
					$("#adName").val('');
					$("#adStatus").val('');
					$("#adImage").val('');
					$("#adClientId").val('');
					$("#editAdvalidDate").val('');
					$("#errorMsg").html("");
					window.location=adminBaseUrl+"/ad-management";
				}				
			}
		});
		 e.preventDefault();	
	}); 
}

function updateAdStatus(adId, status){
	var d 		= new Date();
	var time 	= d.getTime();
	var adId   = adId;
	var status = status;
	$.ajax({
		type:'POST',
		url:  adminBaseUrl+'/update-ad-status?sRch='+time,
		data:{status:status,adId:adId},
		success: function(data){
			$("#status_common").modal('hide');
			if(data.output=='fail'){
				$("#title-message").html("Status Confirmation");
				$("#alert-message").html("Server problem.");
				$("#hidden_common").modal('show');	
			}else if(data.output=='success'){
				$("#hidden_common").modal('hide');	
				window.location=adminBaseUrl+"/ad-management";				
			}				
		}
	});
}

function forgotPassword(){ 
	var d 		= new Date();
	var time 	= d.getTime();
	$("#errorLogin").html('');
	$("#sucessMsg").html('');	
	var u_email    = $("#u_email").val();
	$.ajax({
		type:'POST',
		url:  adminBaseUrl+'/forgot-password?sRch='+time,
		data:{u_email:u_email},
		success: function(data){
			$("#errorLogin").html('');
			if(data.output == "fail"){	
				$("#errorLogin").html('Entered email is not in records');						
			}else if(data.output == "success"){
				$("#sucessMsg").html('Successfully sending the mail.');
			}else if(data.output == "Not Found"){
				$("#errorLogin").html('Somthing is happen.');
			}
		}
	});
}


function getGraphReport(){
	var fromGraphDate 	= $('#fromGraphDate').val();
	var toGraphDate 	= $('#toGraphDate').val();
	if(fromGraphDate != "" && toGraphDate != ""){
		totalTimeSpenGraph(fromGraphDate,toGraphDate);
	}else{
		$('#fromTodateErrorMessage').modal('show');
	}
}
function totalTimeSpenGraph(fromGraphDate,toGraphDate){
	$('#container').html('<center><span><i class="fa fa-circle-o-notch fa-spin" style="font-size:35px;color:#0092d2;margin-top:17%;"></i></span>​</center>');
	var id =    $('#hidAdId').val();
	var d 		= new Date();
	var time 	= d.getTime();
	$.ajax({
		type		:	'GET',
		url			: 	adminBaseUrl+'/date-wise-ads-reports?sRch='+time+'&id='+id+'&from='+fromGraphDate+'&to='+toGraphDate,
		success		: function(result){
			var newdata = result.dateWiseReports;	
			Highcharts.chart('container', {
				chart: {
					zoomType: 'x'
				},
				title: {
					text: 'Ads performance'
				},
				subtitle: {
					text: document.ontouchstart === undefined ?
							'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
				},
				xAxis: {
					type: 'datetime'
				},
				yAxis: {
					title: {
						text: 'Exchange rate'
					}
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					area: {
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'USD to EUR',
					data: newdata
				}]
			});
		}
	});
}

