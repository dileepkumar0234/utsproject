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

function loginChecking(jForm){ 
	var d 		= new Date();
	var time 	= d.getTime();
	$("#loginForm").formValidation().on('success.form.fv', function(e) {
		var u_email    = $("#u_email").val();
		var u_password = $("#u_password").val();
		e.stopImmediatePropagation();
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
					window.location = adminBaseUrl+'/change-password';
				}
			}
		});
		e.preventDefault();
	});
}
// Add Video 
function addvideoMode(type){
	var d 		= new Date();
	var time 	= d.getTime();
	$("#videoaddForm").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation(); 
		var channelid       = $("#channelid").val();
		var videotitle      = $("#videotitle").val();
		var videolink       = $("#videolink").val();
		var videodecrpt     = $("#videodecrpt").val();
		$("#errormsg").html("");
		$.ajax({
			type:'POST',
			url:  adminBaseUrl+'/add-video?sRch='+time,
			data:{videoid:'',channelid:channelid,videotitle:videotitle,videolink:videolink,videodecrpt:videodecrpt},
			success: function(data){
				if(data.output=='fail'){
					if(data.status=="alreadyexsists"){
						$("#errormsg").html("You have already added this video link");
					}else{
						$("#errormsg").html("Server Problem.");
					}					
				}else{
					window.location=adminBaseUrl+"/videos-list";
				}				
			}
		});
		 e.preventDefault();	
	}); 
}

function updatevideoMode(type){
	var d 		= new Date();
	var time 	= d.getTime();
	$("#videoupdateForm").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation(); 
		var channelid       = $("#channelid").val();
		var videotitle      = $("#videotitle").val();
		var videolink       = $("#videolink").val();
		var videodecrpt     = $("#videodecrpt").val();
		var videoid         = $("#videoid").val();
		$("#errormsg").html("");
		$.ajax({
			type:'POST',
			url:  adminBaseUrl+'/add-video?sRch='+time,
			data:{videoid:videoid,channelid:channelid,videotitle:videotitle,videolink:videolink,videodecrpt:videodecrpt},
			success: function(data){
				if(data.output=='fail'){
					if(data.status=="alreadyexsists"){
						$("#errormsg").html("You have already added this video link");
					}else{
						$("#errormsg").html("Server Problem.");
					}					
				}else{
					window.location=adminBaseUrl+"/videos-list";
				}				
			}
		});
		 e.preventDefault();	
	}); 
}

function viewVideo(catid,catname){
	$("#update_category").modal('hide');	
	$("#qc_cat_namee").val(catname);
	$("#view_category").modal('show');	
}
function updateVideo(){	
	var d 		= new Date();
	var time 	= d.getTime();
	$("#updateCate").formValidation().on('success.form.fv', function(e) {
		e.stopImmediatePropagation();
			$("#catLoader").show();
			$("#title-message").html("");
			$("#alert-message").html("");
			var qc_cat_id   = $("#qc_cat_id").val();
			var qc_cat_name = $("#qc_cat_name").val();
			$.ajax({
				type:'POST',
				url:  adminBaseUrl+'/update-category?sRch='+time,
				data:{qc_cat_name:qc_cat_name,qc_cat_id:qc_cat_id},
				success: function(data){
					$("#catLoader").hide();
					if(data.output=='alreadyexists'){
						$("#title-message").html("Category Confirmation");
						$("#alert-message").html("The Category is already added.");
						$("#hidden_common").modal('show');	
					}else if(data.output=='success'){
						$("#hidden_common").modal('hide');	
						window.location=adminBaseUrl+"/category-management";
					}				
				}
			});
		e.preventDefault();	
	});
}
function hideVideo(videoid,statusMode){
	$("#status-alert-message").html("");
	$("#hid_videoid").val(videoid);
	$("#hid_status").val(statusMode);
	if(statusMode==0){
		$("#status-alert-message").html("Are you sure, you want to the status to deactive?");
	}else{
		$("#status-alert-message").html("Are you sure, you want to the status to active?");
	}	
	$("#status_common").modal('show');
}
function deletevideo(videoid,statusMode){
	$("#hid_d_videoid").val(videoid);		
	$("#status_del").modal('show');
}
function deleVideo(){	
	var d 		= new Date();
	var time 	= d.getTime();
	var videoid = $("#hid_d_videoid").val();
	$.ajax({
		type:'POST',
		url:  adminBaseUrl+'/update-video-status?sRch='+time,
		data:{status:'2',videoid:videoid},
		success: function(data){
			$("#status_del").modal('hide');
			if(data.output=='fail'){
				$("#title-message").html("Status Confirmation");
				$("#alert-message").html("Server problem.");
				$("#hidden_common").modal('show');	
			}else if(data.output=='success'){
				$("#hidden_common").modal('hide');	
				window.location=adminBaseUrl+"/videos-list";
			}				
		}
	});
}
function hidevideoMode(){
	var d 		  = new Date();
	var time 	  = d.getTime();
	var videoid   = $("#hid_videoid").val();
	var status    = $("#hid_status").val();
	$.ajax({
		type:'POST',
		url:  adminBaseUrl+'/update-video-status?sRch='+time,
		data:{status:status,videoid:videoid},
		success: function(data){
			$("#status_common").modal('hide');
			if(data.output=='fail'){
				$("#title-message").html("Status Confirmation");
				$("#alert-message").html("Server problem.");
				$("#hidden_common").modal('show');	
			}else if(data.output=='success'){
				$("#hidden_common").modal('hide');	
				window.location=adminBaseUrl+"/videos-list";
			}				
		}
	});
}


