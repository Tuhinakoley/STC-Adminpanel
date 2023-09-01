var user_details=JSON.parse(sessionStorage.getItem("user_details"));

if(user_details==null){
	window.location="login.html";
}else{
	
	$(document).ready(function() {
		$(".se-pre-con").show();
		showUserAllDetails();	
	});
	
	function showUserAllDetails(){
		
		$("#first_name").html("");
		$("#last_name").html("");
		$("#state").html("");
		$("#city").html("");
		$("#pincode").html("");
		$("#company_name").html("");
		$("#company_address").html("");
		$("#profile_pic").html("");
		$("#company_pic").html("");
		$("#email").html("");
		$("#mobile").html("");
		
		$.ajax({
				url: serverURL + 'get_user_details_by_user_id',
				dataType: 'json',
				type: 'post',
				data:{
					user_id: user_details.id
				},
				success: function(data){
					if(data.error){
						$(".se-pre-con").hide();
						
					}else{
						
						//alert(data.profilePicture);
						//alert(data.company_logo);
						
						if(data.profilePicture == ""){
							var picture = "image/pro_pic.jpg";
						}else{
							var picture = imgURL+data.profilePicture;
						}
						if(data.company_logo == ""){
							var company = "image/file_demo.png";
						}else{
							var company = imgURL+data.company_logo;
						}
						
						$("#first_name").text(data.first_name);
						$("#last_name").text(data.last_name);
						$("#state").text(data.state_name);
						$("#city").text(data.city_name);
						$("#pincode").text(data.pin_code);
						$("#company_name").text(data.companyName);
						$("#company_address").html(data.office_address);
						$("#email").text(data.email_id);
						$("#mobile").text(data.mobile_number);
						$("#profile_pic").append('<img style="width: 100px;height: 100px;" src='+picture+' alt="Image Not Available">');
						$("#company_pic").append('<img style="width: 100px;height: 100px;" src='+company+' alt="Image Not Available">');
					}
				},error: function(a,b,c){
					$(".se-pre-con").hide();
					$.notify({
						   message: 'Please check your internet connection.'
						   },{
							type: 'danger',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
				},
				complete: function(){
					$(".se-pre-con").hide();
				}
			});
		
	}	
	
	
}

function updateMemberPersonalDetails(){
	$(".se-pre-con").show();
	$("#edit_f_name").html("");
		$("#edit_l_name").html("");
		$("#edit_email").html("");
		$("#edit_state").html("");
		$("#edit_city").html("");
		$("#edit_pincode").html("");
		$("#edit_company").html("");
		$("#edit_company_addr").html("");
		$("#edit_pp_div").html("");
		$("#edit_pp_div1").html("");
		$("#edit_cmpny_div").html("");
		$("#edit_cmpny_div1").html("");
		
		
		$.ajax({
				url: serverURL + 'get_user_details_by_user_id',
				dataType: 'json',
				type: 'post',
				data:{
					user_id: user_details.id
				},
				success: function(data){
					if(data.error){
						$(".se-pre-con").hide();
						
					}else{
						
						//alert(data.profilePicture);
						//alert(data.company_logo);
						
						if(data.profilePicture == ""){
							var picture = "image/pro_pic.jpg";
						}else{
							var picture = imgURL+data.profilePicture;
						}
						if(data.company_logo == ""){
							var company = "image/file_demo.png";
						}else{
							var company = imgURL+data.company_logo;
						}
						
						$("#edit_f_name").val(data.first_name);
						$("#edit_l_name").val(data.last_name);
						$("#edit_email").val(data.email_id);
						var state_ids = data.state_id;
						var cityid = data.city_id;
						$("#edit_pincode").val(data.pin_code);
						$("#edit_company").val(data.companyName);
						$("#edit_company_addr").val(data.office_address);
						
						
						$("#edit_pp_div").append('<img id="update_pp" style="width: 100px; height: 100px" src="'+picture+'" alt="Image Not Available">');
						$("#edit_pp_div1").append('<input type="file" onchange="image_add_for_update();" id="add_file_upload_update" style="width: 100%;">');
						
						$("#edit_cmpny_div").append('<img id="update_cmpny" style="width: 100px; height: 100px" src="'+company+'" alt="Image Not Available">');
						$("#edit_cmpny_div1").append('<input type="file" onchange="company_add_for_update();" id="add_cmpny_upload_update" style="width: 100%;">');
						
						$.ajax({
								url:serverURL + 'get_state_list',
								dataType: 'json',
								type: 'post',
								success: function(data){
									if(data.error){
										$("#edit_state").html('');
										$("#edit_state").append('<option value="">Select State</option>');
									}else{
										$("#edit_state").html('');
										
										
										$.map(data.state_list,function(item){
											
											if(item.id == state_ids){
												
												$("#edit_state").append('<option value="'+item.id+'" selected>'+item.state_name+'</option>');
											}else{
												
												$("#edit_state").append('<option value="'+item.id+'">'+item.state_name+'</option>');
											}	
										});
									}
								},
								complete: function(){
									$(".se-pre-con").hide();
								},error: function(){
									$(".se-pre-con").hide();
									//swal("Network Error!", "Please check your internet connection!", "error");
								}
							});

							$.ajax({
									url:serverURL + 'get_city_list_by_state_id',
									dataType: 'json',
									type: 'post',
									data:{
										state_id:state_ids
									},
									success: function(data){
										if(data.error){
											$("#edit_city").html('');
											$("#edit_city").append('<option value="">Select City</option>');
										}else{
											$("#edit_city").html('');				
											
											$.map(data.city_list,function(item){
												if(cityid == item.city_id){
													
													$("#edit_city").append('<option value="'+item.city_id+'" selected>'+item.city_name+'</option>');
												}
												else{
													
													$("#edit_city").append('<option value="'+item.city_id+'">'+item.city_name+'</option>');
												}	
											});
										}
									},
									complete: function(){
										$(".se-pre-con").hide();
									},error: function(){
										$(".se-pre-con").hide();
										//swal("Network Error!", "Please check your internet connection!", "error");
									}
								});	
					}
				},error: function(){
					$.notify({
						   message: 'Please check your internet connection.'
						   },{
							type: 'danger',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
				},
				complete: function(){
					$(".se-pre-con").hide();
				}
			});
						
	$("#update_member_personal_details_modal_footer").html("");				
	$("#update_member_personal_details_modal").modal('show');
	$("#update_member_personal_details_modal_footer").append('<button type="button" style="width: 15%;" class="btn btn-info" onclick="updateMemberPersonalDetailsData('+user_details.id+');">Submit</button><button type="button" class="btn btn-default" style="width: 15%;" data-dismiss="modal">Close</button>');
}	


function updateMemberPersonalDetailsData(user_id){
	$(".se-pre-con").show();
	
	if($("#edit_f_name").val() != "" && $("#edit_l_name").val() != "" && $("#edit_email").val() != "" && $("#edit_state").val() != "" && $("#edit_city").val() != "" && $("#edit_pincode").val() != "" && $("#edit_company").val() != "" && $("#edit_company_addr").val() != ""){
		
		
		if(document.getElementById('update_pp').getAttribute('src') == "image/pro_pic.jpg"){
			
			var profile_pic ="";
			
		}else{
			
			var profile_pic = document.getElementById('update_pp').getAttribute('src');
		
		}
		
		
		if(document.getElementById('update_cmpny').getAttribute('src') == "image/file_demo.png"){
			
			var company_pic = "";
			
		}else{
			
			var company_pic = document.getElementById('update_cmpny').getAttribute('src');
			
		}
		
		$.ajax({
				url: serverURL + 'update_profile_details_by_id_admin',
				dataType: 'json',
				type: 'post',
				data:{
					first_name: $("#edit_f_name").val(),
					last_name: $("#edit_l_name").val(), 
					companyName: $("#edit_company").val(),
					office_address: $("#edit_company_addr").val(),
					city_id: $("#edit_city").val(),
					state_id: $("#edit_state").val(),
					email_id: $("#edit_email").val(),
					pin_code: $("#edit_pincode").val(),
					profile_picture: profile_pic,
					company_logo: company_pic,
					modify_by_id: user_id,
					id: user_id 
				},
				success: function(data){
					if(data.error){
						$.notify({
						   message: 'Please check your internet connection.'
						   },{
							type: 'danger',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
						$(".se-pre-con").hide();
					}else{
						$.notify({
						   message: 'Data updated Successfully.'
						   },{
							type: 'success',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
						$(".se-pre-con").hide();
						$("#update_member_personal_details_modal").modal('hide');
						showUserAllDetails();
					}
				},error: function(){
					$.notify({
						   message: 'Please check your internet connection.'
						   },{
							type: 'danger',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
						$(".se-pre-con").hide();
				},
				complete: function(){
					$(".se-pre-con").hide();
					
				}
			});
		
		
	}else{
		$(".se-pre-con").hide();
		if($("#edit_f_name").val() == ""){
			$.notify({
				   message: 'Please enter first name.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}else if($("#edit_l_name").val() == ""){
			$.notify({
				   message: 'Please enter last name.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}else if($("#edit_email").val() == ""){
			$.notify({
				   message: 'Please enter email.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}else if($("#edit_state").val() == ""){
			$.notify({
				   message: 'Please enter state.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}else if($("#edit_city").val() == ""){
			$.notify({
				   message: 'Please enter city.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}else if($("#edit_pincode").val() == ""){
			$.notify({
				   message: 'Please enter pincode.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}else if($("#edit_company").val() == ""){
			$.notify({
				   message: 'Please enter company name.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}else if($("#edit_company_addr").val() == ""){
			$.notify({
				   message: 'Please enter company address.'
				   },{
					type: 'danger',
					z_index: 9999,
					delay: 1000,
					placement: {
						from: "bottom",
						align: "right"
					}
				});
		}
	}
}

function statelist(){
	
	$.ajax({
		url:serverURL + 'get_state_list',
		dataType: 'json',
		type: 'post',
		success: function(data){
			if(data.error){
				$("#edit_state").html('');
				$("#edit_state").append('<option value="">Select State</option>');
			}else{
				$("#edit_state").html('');
				$("#edit_state").append('<option value="">Select State</option>');
				
				$.map(data.state_list,function(item){
					$("#edit_state").append('<option value="'+item.id+'">'+item.state_name+'</option>');
				});
			}
		},
		complete: function(){
			$(".se-pre-con").hide();
		},error: function(){
			$(".se-pre-con").hide();
			//swal("Network Error!", "Please check your internet connection!", "error");
		}
	});
}

function citylist_stateid(){
	
	$(".se-pre-con").show();
	
	var stateid = $("#edit_state").val();
	
	$("#edit_city").html('');
	$("#edit_city").append('<option value="">Select City</option>');
	
		
	$.ajax({
		url:serverURL + 'get_city_list_by_state_id',
		dataType: 'json',
		type: 'post',
		data:{
			state_id:stateid
		},
		success: function(data){
			if(data.error){
				$("#edit_city").html('');
				$("#edit_city").append('<option value="">Select City</option>');
			}else{
								
				$.map(data.city_list,function(item){
					$("#edit_city").append('<option value="'+item.city_id+'">'+item.city_name+'</option>');
				});
			}
		},
		complete: function(){
			$(".se-pre-con").hide();
		},error: function(){
			$(".se-pre-con").hide();
			//swal("Network Error!", "Please check your internet connection!", "error");
		}
	});
}

function image_add_for_update() {
    var file=$("#add_file_upload_update")[0].files[0];
    var reader  = new FileReader();
    
    reader.onloadend = function () {
    
    //alert(reader.result);
        $('#update_pp').attr('src', reader.result);
    }
    if (file) {
      reader.readAsDataURL(file); //reads the data as a URL
      
    } else {
          //preview.src = "";
    }
}

function company_add_for_update() {
    var file=$("#add_cmpny_upload_update")[0].files[0];
    var reader  = new FileReader();
    
    reader.onloadend = function () {
    
    //alert(reader.result);
        $('#update_cmpny').attr('src', reader.result);
    }
    if (file) {
      reader.readAsDataURL(file); //reads the data as a URL
      
    } else {
          //preview.src = "";
    }
}

function openpasswordmodal(){
	$("#oldoldpass").val('');
	$("#oldpass").val('');
	$("#newpass").val('');
	$("#modalForEditPassword").modal('show');
}

function checkpassword(){
	
	//alert($("#oldoldpass").val());
	//alert($("#oldpass").val());
	//alert($("#newpass").val());
	
if($("#oldoldpass").val() == "" && $("#oldpass").val() == "" && $("#newpass").val() ==""){
	$.notify({
		   message: 'All fields are mandatory'
		   },{
			type: 'warning',
			z_index: 9999,
			delay: 1000,
			placement: {
				from: "bottom",
				align: "right"
			}
		});
}else{
	if($("#oldoldpass").val() == $("#oldpass").val()){
		$.notify({
			   message: 'Password same with old password. Please enter new password.'
			   },{
				type: 'danger',
				z_index: 9999,
				delay: 1000,
				placement: {
					from: "bottom",
					align: "right"
				}
			});
	}else if($("#oldpass").val()!= $("#newpass").val()){
		$.notify({
			   message: 'Password do not match'
			   },{
				type: 'danger',
				z_index: 9999,
				delay: 1000,
				placement: {
					from: "bottom",
					align: "right"
				}
			});
	}else{
		$.ajax({
				url: serverURL + 'update_password_by_user_id_admin',
				dataType: 'json',
				type: 'post',
				data:{
					new_password  : $("#oldpass").val(),
					retype_password  : $("#newpass").val(),
					old_password  : $("#oldoldpass").val(),
					modify_by_ip : '1.1.1.1',
					modify_by_id : user_details.id,
					user_id  : user_details.id,
					
				},
				success: function(data){
					if(data.error){
						$(".se-pre-con").hide();
						$.notify({
						   message: 'Data update failed.'
						   },{
							type: 'danger',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
					}else{
						$(".se-pre-con").hide();
						$.notify({
						   message: 'Data updated successfully.'
						   },{
							type: 'success',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
						//showMemberAllDetails();
						$("#modalForEditPassword").modal('hide');
						adminProfilePicture();
					}
				},error: function(a,b,c){
					$(".se-pre-con").hide();
					$.notify({
						   message: 'Please check your internet connection.'
						   },{
							type: 'danger',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
				},
				complete: function(){
					$(".se-pre-con").hide();
				}
			});
	}
}
}