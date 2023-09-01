/*if(user_details==null){
	window.location="login.html";
}else{*/
	
	$(document).ready(function(){
		$(".se-pre-con").show();
		var flag = 0;
		$('#table_user').DataTable({
           "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
           responsive: true,
           "autoWidth": true
		});
	   stocklistwallpapertype(flag);
		
	});
//}

function stocklistwallpapertype(flag){
		$(".se-pre-con").show();
		
			
		$.ajax({
				url: serverURL + 'get_stock_details_all_wallpaper',
				dataType: 'json',
				type: 'post',
				data:{
					flag: flag
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
						$.map(data.stock_catlog_list,function(item){
													
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
							
							
							
							editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfStockCatlog('+new_status+','+item.id+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';
							
							table.row.add([item.catlog_name, '<a target="_blank" href="'+imgURL1+item.catlog_image+'"><img src="'+imgURL1+item.catlog_image+'" style="width:100px;height:100px;" /><a/>', item.wallpaper_type,status,editButton,'<button type="button" class="btn btn-info" data-tooltip="Edit" title="Edit" id="edit_member'+i+'" onclick="showeditStockCatlogMasterDetails(\''+item.id+'\');"><i class="fa fa-edit" aria-hidden="true" style="zoom: 1.5;"></i></button>']).draw();
							
							
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
				url: serverURL + 'get_dealer_user_details_by_user_id',
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
						$("#view_distributer").text(data.parent_first_name+' '+data.parent_last_name);
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

function showeditStockCatlogMasterDetails(catlog_master_id){
	
		
	$.ajax({
				url: serverURL + 'get_stock_catlog_master_details_by_id',
				dataType: 'json',
				type: 'post',
				data:{
					catlog_master_id: catlog_master_id
				},
				success: function(data){
					if(data.error){
						
					}else{
						
												
						$("#edit_catlog_name").val(data.catlog_name);
						
						if(data.catlog_image !=""){
							document.getElementById("edit_catlog_pic").src = imgURL1+data.catlog_image;
						}
						else{
							document.getElementById("edit_catlog_pic").src = "image/file_demo.png";
						}
						if(data.wallpaper_type=="Platinum"){
							
							$("#edit_wallpaper").append('<option value="Platinum" selected>Platinum</option><option value="Economical">Economical</option>');
							
						}else if(data.wallpaper_type=="Economical"){
							
							$("#edit_wallpaper").append('<option value="Economical" selected>Economical</option><option value="Platinum">Platinum</option>');
							
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
												
	$("#edit_footer").html('');
	$("#edit_footer").append('<button type="button" class="btn btn-info" onclick="editCatlogDetails('+catlog_master_id+');" >Submit</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');	
	$("#edituserModal").modal("show");
}




function changeActiveStatusOfStockCatlog(newstatus,stock_catlog_master_id){
	$.ajax({
				url: serverURL + 'update_is_active_by_stock_catlog_master_id',
				dataType: 'json',
				type: 'post',
				data:{
					status: newstatus,
					stock_catlog_master_id: stock_catlog_master_id
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
						stocklistwallpapertype($("#stocklist").val());
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
	$("#myModal").modal("show");
	$("#add_catlog_name").val('');
	$("#add_catlog").val('');
	
	$("#add_wallpaper").html('');
	$("#add_wallpaper").append('<option value="">Select Wallpaper Type</option><option value="Platinum">Platinum</option><option value="Economical">Economical</option>');
	
	document.getElementById('catlog_pic').getAttribute('src') == "image/file_demo.png";
	
}

function addCatlogMasterDetails(){
	$(".se-pre-con").show();
	

	if($("#add_catlog_name").val()!="" && $("#add_wallpaper").val()!="" ){
		
			
		
		if(document.getElementById('catlog_pic').getAttribute('src') == "image/file_demo.png"){
			
			//var catlog_pic = "";
			$.notify({
			   message: 'Please enter catlog image.'
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
			
			var catlog_pic = document.getElementById('catlog_pic').getAttribute('src');
			
				
			
			$.ajax({
						url: serverURL + 'insert_stock_catlog_master_details',
						dataType: 'json',
						type: 'post',
						data:{
							catalog_name: $("#add_catlog_name").val(),
							catalog_image: catlog_pic, 
							wallpaper_type: $("#add_wallpaper").val(),
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
								stocklistwallpapertype(0);
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
		if($("#add_catlog_name").val() ==""){
			$.notify({
				   message: 'Please enter catlog name.'
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
				
		}else if($("#add_wallpaper").val() ==""){
			$.notify({
				   message: 'Please select wallpaper type.'
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

function editCatlogDetails(catlog_master_id){
	$(".se-pre-con").show();
		

	if($("#edit_catlog_name").val()!="" && $("#edit_wallpaper").val()!="" ){
		
	
		if(document.getElementById('edit_catlog_pic').getAttribute('src') == "image/file_demo.png"){
			
			$.notify({
				   message: 'Please enter catlog image.'
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
			
			var catlog_pic = document.getElementById('edit_catlog_pic').getAttribute('src');
			
				
			
			$.ajax({
						url: serverURL + 'update_stock_catlog_master_details',
						dataType: 'json',
						type: 'post',
						data:{
							catalog_name: $("#edit_catlog_name").val(),
							catalog_image: catlog_pic, 
							wallpaper_type: $("#edit_wallpaper").val(),
							stock_catlog_master_id: catlog_master_id
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
								stocklistwallpapertype(0);
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
		if($("#edit_catlog_name").val() ==""){
			$.notify({
				   message: 'Please enter catlog name.'
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
				
		}else if($("#edit_wallpaper").val() ==""){
			$.notify({
				   message: 'Please select wallpaper type.'
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




function upload_catlog(){
	
	var file=$("#add_catlog")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#catlog_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}


function edit_upload_catlog(){
	
	var file=$("#edit_catlog")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#edit_catlog_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

