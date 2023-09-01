/*if(user_details==null){
	window.location="login.html";
}else{*/
	
	$(document).ready(function(){
		$(".se-pre-con").show();
		//var flag = 0;
		$('#table_user').DataTable({
           "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
           responsive: true,
           "autoWidth": true
		});
	   getcustomisecatlogmaster();
		
	});
//}

function getcustomisecatlogmaster(){
	
	$.ajax({
			url:serverURL + 'get_customise_stock_catlog_master_details',
			dataType: 'json',
			type: 'get',
			
			success: function(data){
				if(data.error){
					$("#catlog_master").html('');
					$("#catlog_master").append('<option value="">Select Catalog Master</option>');
				}else{
					$("#catlog_master").html('');
					$("#catlog_master").append('<option value="">Select Catalog Master</option>');
					$("#catlog_master").append('<option value="0">All</option>');
					$.map(data.csutomise_stock_catalog,function(item){
													
						$("#catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
						
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

function getcustomisestockdetails(customise_stock_catlog_master_id){
		$(".se-pre-con").show();
		
			
		$.ajax({
				url: serverURL + 'get_customises_stock_catlog_details_by_master_id',
				dataType: 'json',
				type: 'post',
				data:{
					customise_stock_catlog_master_id: customise_stock_catlog_master_id
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
						$.map(data.stock_catalog,function(item){
													
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
							
							table.row.add([item.pattern_no,item.customise_catlog_sub_category_name, '<a target="_blank" href="'+imgURL1+item.sub_category_img_url+'"><img src="'+imgURL1+item.sub_category_img_url+'" style="width:100px;height:100px;" /><a/>', item.catlog_name,status,editButton,'<button type="button" class="btn btn-info" data-tooltip="Edit" title="Edit" id="edit_member'+i+'" onclick="showeditStockCatlog(\''+item.id+'\');"><i class="fa fa-edit" aria-hidden="true" style="zoom: 1.5;"></i></button>']).draw();
							
							
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


function showeditStockCatlog(customise_stock_catlog_id){
	
		
	$.ajax({
				url: serverURL + 'get_customise_stock_catlog_details_by_id',
				dataType: 'json',
				type: 'post',
				data:{
					customise_stock_catlog_id: customise_stock_catlog_id
				},
				success: function(data){
					if(data.error){
						
					}else{
						
						//alert(imgURL1+data.sub_category_img_url);
						
						$("#edit_catlog_name").val(data.customise_catlog_sub_category_name);
						$("#edit_pattern_no").val(data.pattern_no);
						var customise_catlog_master_id = data.customise_catlog_master_id;
						
						if(data.sub_category_img_url !=""){
							
							document.getElementById("editcatlog_pic1").src = imgURL1+data.sub_category_img_url;
						}
						else{
							//$("#editprofile_pic").append('<img src="image/pro_pic.jpg" style="width:100px;" />');
							document.getElementById("editcatlog_pic1").src = "image/img.png";
						}
						
						
						$.ajax({
								url:serverURL + 'get_customise_stock_catlog_master_details',
								dataType: 'json',
								type: 'get',
								
								success: function(data){
									if(data.error){
										$("#edit_catlog_master").html('');
										$("#edit_catlog_master").append('<option value="">Select Catalog Master</option>');
									}else{
										$("#edit_catlog_master").html('');
																				
										$.map(data.csutomise_stock_catalog,function(item){
																						
											if(customise_catlog_master_id == item.id){
												
												$("#edit_catlog_master").append('<option value="'+item.id+'" selected>'+item.catlog_name+'</option>');
											}else{
												$("#edit_catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
												
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
	//onclick="editUserDetails('+user_id+');"
	$("#edit_footer").append('<button type="button" class="btn btn-info" onclick="editStockDetails('+customise_stock_catlog_id+');" >Submit</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');	
	$("#edituserModal").modal("show");
}




function changeActiveStatusOfStockCatlog(newstatus,customise_stock_catlog_id){
	$.ajax({
				url: serverURL + 'update_is_active_by_customise_stock_catlog_id',
				dataType: 'json',
				type: 'post',
				data:{
					status: newstatus,
					customise_stock_catlog_id: customise_stock_catlog_id
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
						getcustomisestockdetails($("#catlog_master").val());
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
	getcustomcatlogmasterlist();
}

function getcustomcatlogmasterlist(){

	$.ajax({
			url:serverURL + 'get_customise_stock_catlog_master_details',
			dataType: 'json',
			type: 'get',
			
			success: function(data){
				if(data.error){
					$("#add_catlog_master").html('');
					$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
				}else{
					$("#add_catlog_master").html('');
					$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
					
					$.map(data.csutomise_stock_catalog,function(item){
													
						$("#add_catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
						
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

function addcatlogDetails(){
	$(".se-pre-con").show();
		

	if($("#add_catlog_master").val()!="" && $("#add_catlog_name").val()!="" && $("#add_pattern_no").val()!=""){
		
		
				
		if(document.getElementById('catlog_pic').getAttribute('src') == "image/img.png"){
			
			$.notify({
					   message: 'Please add catlog image'
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
						url: serverURL + 'insert_customise_stock_catlog_details',
						dataType: 'json',
						type: 'post',
						data:{
							catlog_master_name: $("#add_catlog_master option:selected").text(),
							customise_catlog_master_id: $("#add_catlog_master").val(), 
							customise_catlog_sub_category_name: $("#add_catlog_name").val(),
							sub_category_img_url: catlog_pic,
							pattern_no: $("#add_pattern_no").val(),
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
		if($("#add_catlog_master").val() ==""){
			$.notify({
				   message: 'Please select catalog master.'
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
				
		}else if($("#add_catlog_name").val() ==""){
			$.notify({
				   message: 'Please select catalog name.'
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
				
		}else if($("#add_pattern_no").val() ==""){
			$.notify({
				   message: 'Please enter pattern number.'
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

function editStockDetails(customise_stock_catlog_id){
	$(".se-pre-con").show();
		

	if($("#edit_catlog_master").val()!="" && $("#edit_catlog_name").val()!="" && $("#edit_pattern_no").val()!=""){
		
				
		
		if(document.getElementById('editcatlog_pic1').getAttribute('src') == "image/img.png"){
			
			$.notify({
				   message: 'Please select catalog image.'
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
			
			var catlog_pic = document.getElementById('editcatlog_pic1').getAttribute('src');
			
			
			
			$.ajax({
						url: serverURL + 'update_customise_stock_catlog_details_by_stock_catlog_id',
						dataType: 'json',
						type: 'post',
						data:{
							catlog_master_name: $("#edit_catlog_master option:selected").text(),
							customise_catlog_master_id: $("#edit_catlog_master").val(), 
							customise_catlog_sub_category_name: $("#edit_catlog_name").val(),
							sub_category_img_url: catlog_pic,
							pattern_no: $("#edit_pattern_no").val(),
							created_by_id: 1,
							customise_stock_catlog_id: customise_stock_catlog_id 
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
								getcustomisestockdetails($("#edit_catlog_master").val());
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
		if($("#edit_catlog_master").val() ==""){
			$.notify({
				   message: 'Please select catlog master.'
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
				
		}else if($("#edit_catlog_name").val() ==""){
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
				
		}else if($("#edit_pattern_no").val() ==""){
			$.notify({
				   message: 'Please enter pattern no.'
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
	
	var file=$("#add_catlog_pic")[0].files[0]; //sames as here
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
	
	var file=$("#edit_catlog_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#editcatlog_pic1').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}