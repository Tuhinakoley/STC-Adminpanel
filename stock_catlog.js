var user_details=JSON.parse(sessionStorage.getItem("user_details"));

if(user_details==null){
	window.location="login.html";
}else{
	
	$(document).ready(function(){
		//$(".se-pre-con").show();
		var flag = 0;
		$('#table_user').DataTable({
           "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
           responsive: true,
		   "autoWidth": true,
		   fixedHeader: true
		});
		
	   //stocklistwallpapertype(flag);
		
	});
//}

function getcatloglist(flag){
	if($("#wallpaper_type").val==""){
		
		$("#catlog_master").html('');
		$("#catlog_master").append('<option value="">Select Catalog Master</option>');
		
		$("#city_list").html('');
		$("#city_list").append('<option value="">Select City</option>');
		
	}else{	
		
		if(user_details.user_role_name =="Admin"){
		
			$.ajax({
					url: serverURL + 'get_stock_details_all_wallpaper',
					dataType: 'json',
					type: 'post',
					data:{
						flag: flag
					},	
					
					success: function(data){
						if(data.error){
							$("#catlog_master").html('');
							$("#catlog_master").append('<option value="">Select Catalog Master</option>');
							
							$("#city_list").html('');
							$("#city_list").append('<option value="">Select City</option>');
							
						}else{
							$("#catlog_master").html('');
							$("#catlog_master").append('<option value="">Select Catalog Master</option>');
							
							$("#city_list").html('');
							$("#city_list").append('<option value="">Select City</option>');
																						
							$.map(data.stock_catlog_list,function(item){
								
								$("#catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
									
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
		}else if(user_details.user_role_name =="Distributor"){
		
			$.ajax({
					url: serverURL + 'get_stock_details_all_wallpaper_by_distributer',
					dataType: 'json',
					type: 'post',
					data:{
						flag: flag,
						city_id: user_details.city_id
					},	
					
					success: function(data){
						if(data.error){
							$("#catlog_master").html('');
							$("#catlog_master").append('<option value="">Select Catalog Master</option>');
							
							$("#city_list").html('');
							$("#city_list").append('<option value="">Select City</option>');
							
						}else{
							$("#catlog_master").html('');
							$("#catlog_master").append('<option value="">Select Catalog Master</option>');
							
							$("#city_list").html('');
							$("#city_list").append('<option value="">Select City</option>');
																						
							$.map(data.stock_catlog_list,function(item){
								
								$("#catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
									
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
	}
}	


function citylist(){
	
		
	if(user_details.user_role_name =="Admin"){
	
		$.ajax({
				url: serverURL + 'get_all_stock_city_list',
				dataType: 'json',
				type: 'get',
								
				success: function(data){
					if(data.error){
						$("#city_list").html('');
						$("#city_list").append('<option value="">Select City</option>');
					}else{
						$("#city_list").html('');
						$("#city_list").append('<option value="">Select City</option>');
						$("#city_list").append('<option value="0">All City</option>');
																					
						$.map(data.stock_city_list,function(item){
							
							$("#city_list").append('<option value="'+item.id+'">'+item.city_name+'</option>');
								
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
	}else if(user_details.user_role_name =="Distributor"){
	
		$.ajax({
				url: serverURL + 'get_stock_city_list',
				dataType: 'json',
				type: 'post',
				data:{
					user_id: user_details.id
				},
				
				success: function(data){
					if(data.error){
						$("#city_list").html('');
						$("#city_list").append('<option value="">Select City</option>');
					}else{
						$("#city_list").html('');
						$("#city_list").append('<option value="">Select City</option>');
																											
						$.map(data.stock_city_list,function(item){
							
							$("#city_list").append('<option value="'+item.id+'">'+item.city_name+'</option>');
								
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
	
}	



function catlogdetailslist(){
		$(".se-pre-con").show();
		
		var stock_catlog_master_id = $("#catlog_master").val();
		var city_id = $("#city_list").val();
			
		$.ajax({
				url: serverURL + 'get_stock_catlog_details_by_stock_catlog_master_id',
				dataType: 'json',
				type: 'post',
				data:{
					stock_catlog_master_id: stock_catlog_master_id,
					city_id: city_id
				},	
				
				success: function(data){
					if(data.error){
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
					}else{
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
						var status, btn_text, color_code, editButton, new_status, stock_status;
						
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
							
							if(item.stock_status == "Continued"){
								
								stock_status ="<p style='background-color:#01a101;color:#fff;padding:10px;text-align: center; font-weight: 600;'>"+item.stock_status+"</p>";
								
							}else if(item.stock_status == "Discontinued"){
								
								stock_status ="<p style='background-color:#d9464c;color:#fff;padding:10px;text-align: center; font-weight: 600;'>"+item.stock_status+"</p>";
								
							}	
							
							
							
							editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfStockCatlog('+new_status+','+item.id+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';
							
							table.row.add(['<a style="cursor: pointer;color: blue;" onclick="showCatlogDetails('+item.id+');">'+item.pattern_no+'</a>', item.pattern, item.roll_size, item.latest_qty, '<a target="_blank" href="'+imgURL1+item.image_url+'"><img src="'+imgURL1+item.image_url+'" style="width:100px;height:100px;" /><a/>', item.city_name, stock_status,status,editButton,'<button type="button" class="btn btn-info" data-tooltip="Edit" title="Edit" id="edit_member'+i+'" onclick="showeditStockCatlogDetails(\''+item.id+'\');"><i class="fa fa-edit" aria-hidden="true" style="zoom: 1.5;"></i></button>']).draw();
							
							
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

/*********************************/


function add_catlog_masterlist(flag){
	if($("#add_wallpepr_type").val==""){
		
		$("#add_catlog_master").html('');
		$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
		
	}else{	
		
				
		if(user_details.user_role_name == "Admin"){	
			
			$.ajax({
					url: serverURL + 'get_stock_details_all_wallpaper',
					dataType: 'json',
					type: 'post',
					data:{
						flag: flag
					},	
					
					success: function(data){
						if(data.error){
							$("#add_catlog_master").html('');
							$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
						}else{
							$("#add_catlog_master").html('');
							$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
																						
							$.map(data.stock_catlog_list,function(item){
								
								$("#add_catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
									
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
		}else if(user_details.user_role_name == "Distributor"){
			
				$.ajax({
					url: serverURL + 'get_stock_details_all_wallpaper_by_distributer',
					dataType: 'json',
					type: 'post',
					data:{
						flag: flag,
						city_id: user_details.city_id
					},	
					
					success: function(data){
						if(data.error){
							$("#add_catlog_master").html('');
							$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
						}else{
							$("#add_catlog_master").html('');
							$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
																						
							$.map(data.stock_catlog_list,function(item){
								
								$("#add_catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
									
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
	}
}	


function get_stock_city_list(){
	
		$.ajax({
				url: serverURL + 'get_stock_city_list',
				dataType: 'json',
				type: 'post',
				data:{
					user_id: user_details.id
				},
				
				success: function(data){
					if(data.error){
						$("#add_city").html('');
						$("#add_city").append('<option value="">Select City</option>');
					}else{
						$("#add_city").html('');
						$("#add_city").append('<option value="">Select City</option>');
																					
						$.map(data.stock_city_list,function(item){
							
							$("#add_city").append('<option value="'+item.id+'">'+item.city_name+'</option>');
								
						});
					}
				},error: function(){
					$.notify({
						   message: 'Please check your internet connection1.'
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

function get_media_list(){
	
		$.ajax({
				url: serverURL + 'get_media_list',
				dataType: 'json',
				type: 'get',
				
				success: function(data){
					if(data.error){
						$("#add_media").html('');
						$("#add_media").append('<option value="">Select Media</option>');
					}else{
						$("#add_media").html('');
						$("#add_media").append('<option value="">Select Media</option>');
																					
						$.map(data.media_list,function(item){
							
							$("#add_media").append('<option value="'+item.id+'">'+item.sheet_name+'</option>');
								
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

function getpaperlist(media_sheet_type_id){
	
	if($("#add_media").val==""){
		
		$("#add_paper_type").html('');
		$("#add_paper_type").append('<option value="">Select Paper Type</option>');
		
	}else{	
		$.ajax({
				url: serverURL + 'get_paper_list_by_media_id',
				dataType: 'json',
				type: 'post',
				data:{
					media_sheet_type_id: media_sheet_type_id
				},	
				
				success: function(data){
					if(data.error){
						$("#add_paper_type").html('');
						$("#add_paper_type").append('<option value="">Select Paper Type</option>');
					}else{
						$("#add_paper_type").html('');
						$("#add_paper_type").append('<option value="">Select Paper Type</option>');
																					
						$.map(data.paper_list,function(item){
							
							$("#add_paper_type").append('<option value="'+item.id+'">'+item.paper_type_name+'</option>');
								
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
}	


function geteditpaperlist(media_sheet_type_id){
	
	if($("#edit_media").val==""){
		
		$("#edit_paper_type").html('');
		$("#edit_paper_type").append('<option value="">Select Paper Type</option>');
		
	}else{	
		$.ajax({
				url: serverURL + 'get_paper_list_by_media_id',
				dataType: 'json',
				type: 'post',
				data:{
					media_sheet_type_id: media_sheet_type_id
				},	
				
				success: function(data){
					if(data.error){
						$("#edit_paper_type").html('');
						$("#edit_paper_type").append('<option value="">Select Paper Type</option>');
					}else{
						$("#edit_paper_type").html('');
						$("#edit_paper_type").append('<option value="">Select Paper Type</option>');
																					
						$.map(data.paper_list,function(item){
							
							$("#edit_paper_type").append('<option value="'+item.id+'">'+item.paper_type_name+'</option>');
								
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
}

/***************** show catlog details by id ***************/

function showCatlogDetails(catlog_id){
	
	$("#view_catlog_master").text('');
	$("#view_pattern_no").text('');
	$("#view_pattern").text('');
	$("#view_media_paper").text('');
	$("#view_roll").text('');
	$("#view_total_size").text('');
	$("#view_color").text('');
	$("#view_quantity").text('');
	$("#view_country").text('');
	$("#view_stock").text('');
	$("#view_thumb_pic").text('');
	$("#view_mock_pic").text('');
	
	$.ajax({
				url: serverURL + 'get_stock_catlog_by_id',
				dataType: 'json',
				type: 'post',
				data:{
					id: catlog_id
				},
				success: function(data){
					if(data.error){
						
					}else{
						
						var stock_status;
						
						/*if(data.stock_status == "Continued"){
								
								stock_status ="<p style='background-color:#01a101;color:#fff;padding:10px;text-align: center; font-weight: 600;'>"+data.stock_status+"</p>";
								
							}else if(data.stock_status == "Discontinued"){
								
								stock_status ="<p style='background-color:#d9464c;color:#fff;padding:10px;text-align: center; font-weight: 600;'>"+data.stock_status+"</p>";
								
							}	*/
						
						$("#view_catlog_master").text(data.catalog_name);
						$("#view_pattern_no").text(data.pattern_no);
						$("#view_pattern").text(data.pattern);
						$("#view_media_paper").text(data.sheet_name+" - "+data.paper_type_name);
						$("#view_roll").text(data.roll_size);
						$("#view_total_size").text(data.total_sq_ft);
						$("#view_color").text(data.color);
						$("#view_quantity").text(data.latest_qty);
						$("#view_country").text(data.country_of_origin);
						$("#view_stock").text(data.stock_status);
						
						if(data.image_url !=""){
							
							$("#view_thumbs_pic").text('');
							$("#view_thumbs_pic").append('<img src="'+data.image_url+'" style="width:150px;" />');
						}
						else{
							$("#view_thumbs_pic").text('');
						}
						if(data.mock_image_url !=""){
							
							$("#view_mocks_pic").text('');
							$("#view_mocks_pic").append('<img src="'+data.mock_image_url+'" style="width:150px;" />');
							
						}else{
							$("#view_mocks_pic").text('');
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

function showeditStockCatlogDetails(catlog_id){
	
		
	$.ajax({
				url: serverURL + 'get_stock_catlog_by_id',
				dataType: 'json',
				type: 'post',
				data:{
					id: catlog_id
				},
				success: function(data){
					if(data.error){
						
					}else{
						
						if(data.wallpaper_type == "Platinum"){
							
							$("#edit_wallpepr_type").append('<option value="1" selected>Platinum</option>');
							$("#edit_wallpepr_type").append('<option value="2">Economical</option>');
						}
						else if(data.wallpaper_type == "Economical"){
							
							$("#edit_wallpepr_type").append('<option value="2" selected>Economical</option>');
							$("#edit_wallpepr_type").append('<option value="1">Platinum</option>');
						}

						if(data.stock_status == "Continued"){
							
							$("#edit_stock").append('<option value="Continued" selected>Continued</option>');
							$("#edit_stock").append('<option value="Discontinued">Discontinued</option>');
						}
						else if(data.stock_status == "Discontinued"){
							
							$("#edit_stock").append('<option value="Discontinued" selected>Discontinued</option>');
							$("#edit_stock").append('<option value="Continued">Continued</option>');
						}						
												
						$("#edit_pattern_no").val(data.pattern_no);
						$("#edit_pattern").val(data.pattern);
						$("#edit_roll").val(data.roll_size);
						$("#edit_total_roll").val(data.total_sq_ft);
						$("#edit_color").val(data.color);
						$("#edit_quantity").val(data.latest_qty);
						$("#edit_country").val(data.country_of_origin);
						
						var city_id = data.city_id;
						
												
						if(data.image_url !=""){
							
							document.getElementById("editthumb_pic").src = data.image_url;
						}
						else{
							
							document.getElementById("editthumb_pic").src = "image/img.png";
						}
						if(data.mock_image_url !=""){
							
							document.getElementById("editmock_pic").src = data.mock_image_url;
							
						}else{
							//$("#editcompany_pic1").append('<img src="image/file_demo.png" style="width:100px;" />');
							document.getElementById("editmock_pic").src = "image/img.png";
						}
						$.ajax({
								url: serverURL + 'get_stock_details_all_wallpaper',
								dataType: 'json',
								type: 'post',
								data:{
									flag: $("#edit_wallpepr_type").val()
								},	
								
								success: function(data){
									if(data.error){
										$("#edit_catlog_master").html('');
										$("#edit_catlog_master").append('<option value="">Select Catalog Master</option>');
									}else{
										$("#edit_catlog_master").html('');
																																			
										$.map(data.stock_catlog_list,function(item){
											
											if(data.catalog_name == item.catlog_name){
											
												$("#edit_catlog_master").append('<option value="'+item.id+'" selected>'+item.catlog_name+'</option>');
												
											}else{
												$("#edit_catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
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

							$.ajax({
									url: serverURL + 'get_stock_city_list',
									dataType: 'json',
									type: 'post',
									data:{
										user_id: user_details.id
									},
									
									success: function(data){
										if(data.error){
											$("#edit_city").html('');
											$("#edit_city").append('<option value="">Select City</option>');
										}else{
											$("#edit_city").html('');
																																					
											$.map(data.stock_city_list,function(item){
												
												if(city_id == item.id){
													$("#edit_city").append('<option value="'+item.id+'" selected>'+item.city_name+'</option>');
												}else{
													$("#edit_city").append('<option value="'+item.id+'">'+item.city_name+'</option>');
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

						/*$.ajax({
								url: serverURL + 'get_media_list',
								dataType: 'json',
								type: 'get',
								
								success: function(data){
									if(data.error){
										$("#edit_media").html('');
										$("#edit_media").append('<option value="">Select Media</option>');
									}else{
										$("#edit_media").html('');
										
																									
										$.map(data.media_list,function(item){
											
											if(data.sheet_name == item.sheet_name){
												$("#edit_media").append('<option value="'+item.id+'" selected>'+item.sheet_name+'</option>');
											}else{
												$("#edit_media").append('<option value="'+item.id+'">'+item.sheet_name+'</option>');
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
						
						$.ajax({
								url: serverURL + 'get_paper_list_by_media_id',
								dataType: 'json',
								type: 'post',
								data:{
									media_sheet_type_id: data.media_id
								},	
								
								success: function(data){
									if(data.error){
										$("#edit_paper_type").html('');
										$("#edit_paper_type").append('<option value="">Select Paper Type</option>');
										
									}else{
										$("#edit_paper_type").html('');
																																			
										$.map(data.paper_list,function(item){
											
											if(data.paper_type_id = item.id){
												
												$("#edit_paper_type").append('<option value="'+item.id+'" selected>'+item.paper_type_name+'</option>');
											
											}else{
											
												$("#edit_paper_type").append('<option value="'+item.id+'">'+item.paper_type_name+'</option>');	
												
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
							});	*/		
						
						
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
	$("#edit_footer").append('<button type="button" class="btn btn-info" onclick="editStockDetails('+catlog_id+');" >Submit</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');	
	$("#edituserModal").modal("show");
}

function geteditcatlogmasterlist(flag){
	if($("#edit_wallpepr_type").val==""){
		
		$("#edit_catlog_master").html('');
		$("#edit_catlog_master").append('<option value="">Select Catalog Master</option>');
		
	}else{

		if(user_details.user_role_name == "Admin"){	
		
			$.ajax({
					url: serverURL + 'get_stock_details_all_wallpaper',
					dataType: 'json',
					type: 'post',
					data:{
						flag: flag
					},	
					
					success: function(data){
						if(data.error){
							$("#edit_catlog_master").html('');
							$("#edit_catlog_master").append('<option value="">Select Catalog Master</option>');
						}else{
							$("#edit_catlog_master").html('');
							$("#edit_catlog_master").append('<option value="">Select Catalog Master</option>');
																						
							$.map(data.stock_catlog_list,function(item){
								
								$("#edit_catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
									
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
				
		}else if(user_details.user_role_name == "Distributor"){
			
			$.ajax({
				url: serverURL + 'get_stock_details_all_wallpaper_by_distributer',
				dataType: 'json',
				type: 'post',
				data:{
					flag: flag,
					city_id: user_details.city_id
				},	
				
				success: function(data){
					if(data.error){
						$("#edit_catlog_master").html('');
						$("#edit_catlog_master").append('<option value="">Select Catalog Master</option>');
					}else{
						$("#edit_catlog_master").html('');
						$("#edit_catlog_master").append('<option value="">Select Catalog Master</option>');
																					
						$.map(data.stock_catlog_list,function(item){
							
							$("#edit_catlog_master").append('<option value="'+item.id+'">'+item.catlog_name+'</option>');
								
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
	}
}


function changeActiveStatusOfStockCatlog(newstatus,stock_catlog_id){
	$.ajax({
				url: serverURL + 'update_is_active_by_stock_catlog_id',
				dataType: 'json',
				type: 'post',
				data:{
					status: newstatus,
					stock_catlog_id: stock_catlog_id
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
						catlogdetailslist($("#catlog_master").val());
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
	$("#add_wallpepr_type").html('');
	$("#add_wallpepr_type").append('<option value="">Select Wallpaper Type </option><option value="1">Platinum</option><option value="2">Economical</option>');
	
	$("#add_catlog_master").html('');
	$("#add_catlog_master").append('<option value="">Select Catalog Master</option>');
	
	$("#add_pattern_no").val('');
	$("#add_pattern").val('');
	$("#add_roll").val('');
	$("#add_total_roll").val('');
	$("#add_color").val('');
	$("#add_quantity").val('');
	$("#add_country").val('');
	$("#add_thumb_pic").val('');
	$("#add_mock_pic").val('');
	
	$("#add_stock").html('');
	$("#add_stock").append('<option value="">Select Stock Status</option><option value="Continued">Continued</option><option value="Discontinued">Discontinued</option>');
	
	$("#thumb_pic").attr("src","image/img.png");
	$("#mock_pic").attr("src","image/img.png");
	
	$("#myModal").modal("show");
	get_stock_city_list();
	get_media_list();
	
}

function addStockCatlogDetails(){
	$(".se-pre-con").show();
	//alert($( "#add_catlog_master option:selected" ).text());
	

	if($("#add_wallpepr_type").val()!="" && $("#add_catlog_master").val()!="" && $("#add_city").val()!="" && $("#add_pattern_no").val()!="" && $("#add_pattern").val()!="" && $("#add_roll").val()!="" && $("#add_total_roll").val()!="" && $("#add_color").val()!="" && $("#add_quantity").val()!="" && $("#add_country").val()!="" && $("#add_stock").val()!=""){
		
		
		

		if(document.getElementById('thumb_pic').getAttribute('src') == "image/img.png"){
			
			$.notify({
				   message: 'Please add thumbnail image'
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
		else{
			
			var thumb_pic = document.getElementById('thumb_pic').getAttribute('src');
			var mock_pic = document.getElementById('mock_pic').getAttribute('src');
			
			if(document.getElementById('mock_pic').getAttribute('src') == "image/img.png"){
				
				var mock_pic = "";
				
			}else{
				
				
				var mock_pic = document.getElementById('mock_pic').getAttribute('src');
				
			}		
			var catlog_text = $( "#add_catlog_master option:selected" ).text();
				
			
			$.ajax({
						url: serverURL + 'insert_stock_catlog_details',
						dataType: 'json',
						type: 'post',
						data:{
							stock_catalog_master_id: $("#add_catlog_master").val(),
							stock_catalog_master_name: catlog_text, 
							city_id: $("#add_city").val(),
							pattern_no: $("#add_pattern_no").val(),
							pattern: $("#add_pattern").val(),
							paper_type_id: 1,
							roll_size: $("#add_roll").val()+'ft.',
							total_sq_ft: $("#add_total_roll").val()+'sq.ft.',
							color: $("#add_color").val(),
							latest_qty: $("#add_quantity").val()+' Rolls',
							image_url: thumb_pic,
							mock_image_url: mock_pic,
							country_of_origin: $("#add_country").val(),
							stock_status: $("#add_stock").val(),
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
		if($("#add_wallpepr_type").val() ==""){
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
				
		}else if($("#add_catlog_master").val() ==""){
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
				
		}else if($("#add_city").val() ==""){
			$.notify({
				   message: 'Please select city.'
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
				
		}else if($("#add_pattern").val() ==""){
			$.notify({
				   message: 'Please enter pattern.'
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
				
		}else if($("#add_media").val() ==""){
			$.notify({
				   message: 'Please select media.'
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
				
		}else if($("#add_roll").val() ==""){
			$.notify({
				   message: 'Please enter roll size'
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
				
		}else if($("#add_total_roll").val() ==""){
			$.notify({
				   message: 'Please enter total size.'
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
				
		}else if($("#add_color").val() ==""){
			$.notify({
				   message: 'Please enter color.'
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
				
		}else if($("#add_quantity").val() ==""){
			$.notify({
				   message: 'Please enter quantity.'
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
		}else if($("#add_country").val() ==""){
			$.notify({
				   message: 'Please enter country of origin.'
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
		}else if($("#add_stock").val() ==""){
			$.notify({
				   message: 'Please select stock status.'
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

/*************edit stock details ********************/

function editStockDetails(stockid){
	$(".se-pre-con").show();
		

	if($("#edit_wallpepr_type").val()!="" && $("#edit_catlog_master").val()!="" && $("#edit_city").val()!="" && $("#edit_pattern_no").val()!="" && $("#edit_pattern").val()!="" && $("#edit_roll").val()!="" && $("#edit_total_roll").val()!="" && $("#edit_color").val()!="" && $("#edit_quantity").val()!="" && $("#edit_country").val()!="" && $("#edit_stock").val()!=""){
		
		
			
		
		if(document.getElementById('editthumb_pic').getAttribute('src') == "image/img.png"){
			
			$.notify({
					   message: 'Please enter thumbnail picture.'
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
			
			var thumb_pic = document.getElementById('editthumb_pic').getAttribute('src');

		}		
		
		
		if(document.getElementById('editmock_pic').getAttribute('src') == "image/img.png"){
			
			var mock_pic = "";
			
		}else{
			
			var mock_pic = document.getElementById('editmock_pic').getAttribute('src');
			
		}	

		var catlog_text = $( "#edit_catlog_master option:selected" ).text();	
			
			$.ajax({
						url: serverURL + 'update_stock_catlog_details_by_id',
						dataType: 'json',
						type: 'post',
						data:{
							stock_catalog_master_id: $("#edit_catlog_master").val(),
							stock_catalog_master_name: catlog_text, 
							city_id: $("#edit_city").val(),
							pattern_no: $("#edit_pattern_no").val(),
							pattern: $("#edit_pattern").val(),
							paper_type_id: 1,
							roll_size: $("#edit_roll").val(),
							total_sq_ft: $("#edit_total_roll").val(),
							color: $("#edit_color").val(),
							latest_qty: $("#edit_quantity").val(),
							image_url: thumb_pic,
							mock_image_url: mock_pic,
							country_of_origin: $("#edit_country").val(),
							stock_status: $("#edit_stock").val(),
							created_by_id: 1,
							stock_catlog_id: stockid 
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
								catlogdetailslist($("#catlog_master").val());
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
		if($("#edit_wallpepr_type").val() ==""){
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
				
		}else if($("#edit_catlog_master").val() ==""){
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
				
		}else if($("#edit_city").val() ==""){
			$.notify({
				   message: 'Please select city.'
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
				
		}else if($("#edit_pattern").val() ==""){
			$.notify({
				   message: 'Please enter pattern'
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
				
		}else if($("#edit_media").val() ==""){
			$.notify({
				   message: 'Please select media.'
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
				
		}else if($("#edit_roll").val() ==""){
			$.notify({
				   message: 'Please enter roll size'
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
				
		}else if($("#edit_total_roll").val() ==""){
			$.notify({
				   message: 'Please enter total size.'
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
				
		}else if($("#edit_color").val() ==""){
			$.notify({
				   message: 'Please enter color.'
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
				
		}else if($("#edit_quantity").val() ==""){
			$.notify({
				   message: 'Please enter quantity.'
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
		}else if($("#edit_country").val() ==""){
			$.notify({
				   message: 'Please enter country of origin.'
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
		}else if($("#edit_stock").val() ==""){
			$.notify({
				   message: 'Please select stock status.'
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




function upload_thumb(){
	
	var file=$("#add_thumb_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#thumb_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

function upload_mock(){
	
	var file=$("#add_mock_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#mock_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

function edit_upload_thumb(){
	
	var file=$("#edit_thumb_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#editthumb_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

function edit_upload_mock(){
	
	var file=$("#edit_mock_pic")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#editmock_pic').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

}