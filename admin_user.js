/*if(user_details==null){
	window.location="login.html";
}else{*/
	
	$(document).ready(function(){
		
		$('#table_user').DataTable({
           "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
           responsive: true,
           "autoWidth": true
		});
	   showUserList();
		
	});
//}

function showUserList(){
		
		
		$.ajax({
				url: serverURL + 'get_all_user_list_by_user_role_id',
				dataType: 'json',
				type: 'post',
				data:{
					user_role_id: 1
				},
				success: function(data){
					if(data.error){
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
					}else{
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
						var status, btn_text, color_code, editButton, new_status;
						
						var i=1;
						$.map(data.user_list,function(item){
													
							if(item.is_active==1){
								status = "ACTIVE";
								btn_text = "DEACTIVATE";
								color_code = "btn-danger";
								new_status = 0;
							}else if(item.is_active==0){
								status = "DEACTIVE";
								btn_text = "ACTIVATE";
								color_code = "btn-success";
								new_status = 1;
							}
							
							editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfUser('+new_status+','+item.id+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';
							
							/*if(item.login_permission == 0){
								editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="" id="changeActionStatusBtn'+i+'" style="background-color: #8f8f8f !important;border-color: #8f8f8f !important;" disabled>'+btn_text+'</button>';
							}else if(item.login_permission == 1){
								editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfUser('+item.id+','+item.is_active+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';
							}*/
							
							table.row.add(['<a style="cursor: pointer;color: blue;" onclick="showUserDetails('+item.id+');">'+item.first_name1+' '+item.last_name+'</a>', item.mobile_number, item.email_id, item.city_name, status,editButton,'<button type="button" class="btn btn-info" data-tooltip="Edit" title="Edit" id="edit_member'+i+'" onclick="showeditUserDetails(\''+item.id+'\');"><i class="fa fa-edit" aria-hidden="true" style="zoom: 1.5;"></i></button>']).draw();
							
							
							i++;
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
	
}

function openModal(){
	
	$("#add_first_name").val('');
	$("#add_last_name").val('');
	$("#add_email").val('');
	$("#add_mobile").val('');
	$("#add_password").val('');
	$("#add_company").val('');
	$("#add_company_address").val('');
	$("#add_confirm_password").val('');
	$("#add_city").html('');
	$("#add_city").append('<option value="">Select City</option>');
	$("#add_state").html('');
	$("#add_state").append('<option value="">Select State</option>');
	$("#add_pincode").val('');
	$("#add_profile_pic").val('');
	$("#add_cmpny_pic").val('');
	
	$("#profile_pic").attr("src","image/img.png");
	$("#company_pic").attr("src","image/file_demo.png");
	
	$("#myModal").modal("show");
	statelist();
}

function showeditUserDetails(user_id){
	
		
	$.ajax({
				url: serverURL + 'get_user_details_by_user_id',
				dataType: 'json',
				type: 'post',
				data:{
					user_id: user_id
				},
				success: function(data){
					if(data.error){
						
					}else{
						
						var state_ids = data.state_id;
						var cityid = data.city_id;
						
						$("#edit_first_name").val(data.first_name);
						$("#edit_last_name").val(data.last_name);
						$("#edit_email").val(data.email_id);
						$("#edit_mobile").val(data.mobile_number);
						$("#edit_company").val(data.companyName);
						$("#edit_company_address").val(data.office_address);
						//$("#edit_state").val(data.state_name);
						//$("#view_city").val(data.city_name);
						$("#edit_pincode").val(data.pin_code);
						if(data.profilePicture !=""){
							//$("#editprofile_pic1").append('<img src="'+imgURL+data.profilePicture+'" style="width:100px;" />');
							document.getElementById("editprofile_pic1").src = imgURL+data.profilePicture;
						}
						else{
							//$("#editprofile_pic").append('<img src="image/pro_pic.jpg" style="width:100px;" />');
							document.getElementById("editprofile_pic1").src = "image/pro_pic.jpg";
						}
						if(data.company_logo !=""){
							
							//$("#editcompany_pic1").append('<img src="'+imgURL+data.company_logo+'" style="width:100px;" />');
							document.getElementById("editcompany_pic1").src = imgURL+data.profilePicture;
							
						}else{
							//$("#editcompany_pic1").append('<img src="image/file_demo.png" style="width:100px;" />');
							document.getElementById("editcompany_pic1").src = "image/file_demo.png";
						}

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
	
	$("#edit_footer").html('');
	$("#edit_footer").append('<button type="button" class="btn btn-info" onclick="editUserDetails('+user_id+');">Submit</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');	
	$("#edituserModal").modal("show");
}

/***************** show user details by user id ***************/

function showUserDetails(user_id){
	
	$("#view_first_name").text('');
	$("#view_last_name").text('');
	$("#view_email").text('');
	$("#view_mobile").text('');
	$("#view_company").text('');
	$("#view_company_address").text('');
	$("#view_state").text('');
	$("#view_city").text('');
	$("#view_pincode").text('');
	$("#view_pro_pic").text('');
	$("#view_company_logo").text('');
	
	$.ajax({
				url: serverURL + 'get_user_details_by_user_id',
				dataType: 'json',
				type: 'post',
				data:{
					user_id: user_id
				},
				success: function(data){
					if(data.error){
						
					}else{
						
						$("#view_first_name").text(data.first_name);
						$("#view_last_name").text(data.last_name);
						$("#view_email").text(data.email_id);
						$("#view_mobile").text(data.mobile_number);
						$("#view_company").text(data.companyName);
						$("#view_company_address").text(data.office_address);
						$("#view_state").text(data.state_name);
						$("#view_city").text(data.city_name);
						$("#view_pincode").text(data.pin_code);
						if(data.profilePicture !=""){
							$("#view_pro_pic").append('<img src="'+imgURL+data.profilePicture+'" style="width:150px;" />');
						}
						else{
							$("#view_pro_pic").text('');
						}
						if(data.company_logo !=""){
							$("#view_company_logo").append('<img src="'+imgURL+data.company_logo+'" style="width:150px;" />');
						}else{
							$("#view_company_logo").text('');
						}	
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
	$("#viewdetails").modal("show");
}	

function changeActiveStatusOfUser(newstatus,user_id){
	$.ajax({
				url: serverURL + 'update_is_active_by_user_id',
				dataType: 'json',
				type: 'post',
				data:{
					status: newstatus,
					user_id: user_id
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
					}else{
						$.notify({
						   message: 'Data updated successfully'
						   },{
							type: 'success',
							z_index: 9999,
							delay: 1000,
							placement: {
								from: "bottom",
								align: "right"
							}
						});
						showUserList();
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
}

function addUserDetails(){
	$(".se-pre-con").show();
	var email = $('#add_email').val();
	
	 if($("#add_first_name").val()!="" && $("#add_last_name").val()!="" && $("#add_email").val()!="" && $("#add_mobile").val()!="" && $("#add_password").val()!="" && $("#add_confirm_password").val()!="" && $("#add_city").val()!="" && $("#add_state").val()!="" && $("#add_pincode").val()!="" && $("#add_profile_pic").val()!=""){
		
		
		if($("#add_password").val().length < 6){
			$.notify({
					   message: 'You have to enter at least 6 digit!'
					   },{
						type: 'warning',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					$(".se-pre-con").hide();
		}else if($("#add_password").val() != $("#add_confirm_password").val()){
			$.notify({
					   message: 'Password do not match!'
					   },{
						type: 'warning',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					$(".se-pre-con").hide();
		}else if(IsEmail(email)==false){
			$.notify({
					   message: 'Please enter correct email format'
					   },{
						type: 'warning',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					$(".se-pre-con").hide();
		}else if($("#add_mobile").val().length < 10){
			$.notify({
					   message: 'Please enter 10 digit mobile number'
					   },{
						type: 'warning',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					$(".se-pre-con").hide();
		}else{

		var profile_pic = document.getElementById('profile_pic').getAttribute('src');
		
		
		if(document.getElementById('company_pic').getAttribute('src') == "image/file_demo.png"){
			
			var company_pic = "";
			
		}else{
			
			var company_pic = document.getElementById('company_pic').getAttribute('src');
			
		}		
			
			$.ajax({
						url: serverURL + 'insert_user_details',
						dataType: 'json',
						type: 'post',
						data:{
							first_name: $("#add_first_name").val(),
							last_name: $("#add_last_name").val(), 
							companyName: $("#add_company").val(),
							profilePicture: profile_pic,
							company_logo: company_pic,
							email_id: $("#add_email").val(),
							mobile_number: $("#add_mobile").val(),
							password: $("#add_password").val(),
							office_address: $("#add_company_address").val(),
							city_id: $("#add_city").val(),
							state_id: $("#add_state").val(),
							pin_code: $("#add_pincode").val(),
							user_role_id: 1,
							parent_user_id: 1,
							created_by_id: 1
						},
						success: function(data){
							if(data.error){
								$.notify({
								   message: data.msg
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
								   message: 'Data Added Successfully.'
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
								$("#myModal").modal("hide");
								showUserList();
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
		}			
	}else{
		if($("#add_first_name").val() ==""){
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
				$(".se-pre-con").hide();
				
		}else if($("#add_last_name").val() ==""){
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
				$(".se-pre-con").hide();
				
		}else if($("#add_email").val() ==""){
			$.notify({
				   message: 'Please enter email id.'
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
				
		}else if($("#add_mobile").val() ==""){
			$.notify({
				   message: 'Please enter mobile number.'
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
				
		}else if($("#add_state").val() ==""){
			$.notify({
				   message: 'Please select state.'
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
				
		}else if($("#add_city").val() ==""){
			$.notify({
				   message: 'Please select city'
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
				
		}else if($("#add_pincode").val() ==""){
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
				$(".se-pre-con").hide();
				
		}else if($("#add_password").val() ==""){
			$.notify({
				   message: 'Please enter password.'
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
				
		}else if($("#add_confirm_password").val() ==""){
			$.notify({
				   message: 'Please enter confirm password.'
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
		}else if($("#add_profile_pic").val() ==""){
			$.notify({
				   message: 'Please add profile image.'
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
		}else if(document.getElementById('profile_pic').getAttribute('src') == "image/pro_pic.jpg"){
			
			$.notify({
				   message: 'Please add profile image'
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
		}	
	}	
}

/*************edit user details ********************/

function editUserDetails(userid){
	$(".se-pre-con").show();
	var email = $('#edit_email').val();
	

	if($("#edit_first_name").val()!="" && $("#edit_last_name").val()!="" && $("#edit_email").val()!="" && $("#edit_mobile").val()!="" && $("#edit_city").val()!="" && $("#edit_state").val()!="" && $("#edit_pincode").val()!=""){
		
		
		if(IsEmail(email)==false){
			$.notify({
					   message: 'Please enter correct email format'
					   },{
						type: 'warning',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					$(".se-pre-con").hide();
		}else if($("#edit_mobile").val().length < 10){
			$.notify({
					   message: 'Please enter 10 digit mobile number'
					   },{
						type: 'warning',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					$(".se-pre-con").hide();
		}else{

		var profile_pic = document.getElementById('editprofile_pic1').getAttribute('src');
		
		
		if(document.getElementById('editcompany_pic1').getAttribute('src') == "image/file_demo.png"){
			
			var company_pic = "";
			
		}else{
			
			var company_pic = document.getElementById('editcompany_pic1').getAttribute('src');
			
		}		
			
			$.ajax({
						url: serverURL + 'update_profile_details_by_id_admin',
						dataType: 'json',
						type: 'post',
						data:{
							first_name: $("#edit_first_name").val(),
							last_name: $("#edit_last_name").val(), 
							companyName: $("#edit_company").val(),
							office_address: $("#edit_company_address").val(),
							city_id: $("#edit_city").val(),
							state_id: $("#edit_state").val(),
							email_id: $("#edit_email").val(),
							pin_code: $("#edit_pincode").val(),
							profile_picture: profile_pic,
							company_logo: company_pic,
							modify_by_id: userid,
							id: userid 
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
								$("#edituserModal").modal("hide");	
								showUserList();
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
		}			
	}else{
		if($("#edit_first_name").val() ==""){
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
				$(".se-pre-con").hide();
				
		}else if($("#edit_last_name").val() ==""){
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
				$(".se-pre-con").hide();
				
		}else if($("#edit_state").val() ==""){
			$.notify({
				   message: 'Please select state.'
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
				
		}else if($("#edit_city").val() ==""){
			$.notify({
				   message: 'Please select city'
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
				
		}else if($("#edit_email").val() ==""){
			$.notify({
				   message: 'Please enter email'
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
				
		}else if($("#edit_mobile").val() ==""){
			$.notify({
				   message: 'Please enter mobile no.'
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
				
		}else if($("#edit_pincode").val() ==""){
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
				$(".se-pre-con").hide();
				
		}	
	}

}

/************* email*************/

 function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}

/************** number only ******************/

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function statelist(){
	
	$.ajax({
		url:serverURL + 'get_state_list',
		dataType: 'json',
		type: 'post',
		success: function(data){
			if(data.error){
				$("#add_state").html('');
				$("#add_state").append('<option value="">Select State</option>');
			}else{
				$("#add_state").html('');
				$("#add_state").append('<option value="">Select State</option>');
				
				$.map(data.state_list,function(item){
					$("#add_state").append('<option value="'+item.id+'">'+item.state_name+'</option>');
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
	
	var stateid = $("#add_state").val();
	
	$("#add_city").html('');
	$("#add_city").append('<option value="">Select City</option>');
	
		
	$.ajax({
		url:serverURL + 'get_city_list_by_state_id',
		dataType: 'json',
		type: 'post',
		data:{
			state_id:stateid
		},
		success: function(data){
			if(data.error){
				$("#add_city").html('');
				$("#add_city").append('<option value="">Select City</option>');
			}else{
								
				$.map(data.city_list,function(item){
					$("#add_city").append('<option value="'+item.city_id+'">'+item.city_name+'</option>');
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

function editcitylist_stateid(){
	
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

function upload_profile(){
	
	var file=$("#add_profile_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#profile_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

function upload_company(){
	
	var file=$("#add_cmpny_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#company_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

function edit_upload_profile(){
	
	var file=$("#edit_profile_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#editprofile_pic1').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

function edit_upload_company(){
	
	var file=$("#edit_cmpny_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#editcompany_pic1').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}