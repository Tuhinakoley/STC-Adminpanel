var user_details=JSON.parse(sessionStorage.getItem("user_details"));

if(user_details==null){
	window.location="login.html";
}else{
	
	$(document).ready(function(){
		
		$('#table_user').DataTable({
           "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
           responsive: true,
		   "order": [0,'desc'],
           "autoWidth": true
		});
		if(user_details.user_role_name =="Admin"){
		
			showOrderList();
			
		}else if(user_details.user_role_name =="Distributor"){	
			
			showOrderListDistributer();
			
		}
		
	});
//}

function showOrderList(){
		
		
		$.ajax({
				url: serverURL + 'get_all_job_by_admin',
				dataType: 'json',
				type: 'get',
				
				success: function(data){
					if(data.error){
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
					}else{
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
						var status, btn_text, color_code, editButton, new_status, support_button, pattern_no, status_datetime, viewapprove, audio, viewremarks;
						
						var i=1;
						$.map(data.order_details,function(item){
													
							/*if(item.is_active==1){
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
							
							
							editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfUser('+new_status+','+item.id+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';*/
							
							/*if(item.login_permission == 0){
								editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="" id="changeActionStatusBtn'+i+'" style="background-color: #8f8f8f !important;border-color: #8f8f8f !important;" disabled>'+btn_text+'</button>';
							}else if(item.login_permission == 1){
								editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfUser('+item.id+','+item.is_active+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';
							}*/
							
							//editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Approved Preview" title="Approved Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							
							/*
							
							if(item.order_status_id == 2){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Approved Preview" title="Approved Preview" onclick="updateapprovedpreview('+item.id+');" id="changeActionStatusBtn'+i+'">Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}else 
							
							*/
							
							if(item.status_date_time != null){
								
								status_datetime = item.status_date_time;
								
							}else{
								
								status_datetime = item.created_date_time;
								
							}	
							
							if(item.approve_distributer == "false"){
								
							viewapprove = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="View Preview" title="View Preview" onclick="show_previewimage('+item.id+');" id="View_Preview'+i+'">View Preview</button>';
							
							}else if(item.approve_distributer == "true"){
								
							viewapprove = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="View Preview" title="View Preview" onclick="show_previewimage('+item.id+');" id="View_Preview'+i+'">View Preview</button>';
							
							}else{
								
								viewapprove = "";
								
							}
							
							viewremarks ='<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Dealer/Distributor Remarks" title="Dealer/Distributor Remarks" onclick="show_remarks('+item.id+');" id="View_reamrks'+i+'">Dealer/Distributor Remarks</button>';
							
							editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button>'+viewapprove+'<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							
							if(item.order_status_id == 2){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" onclick="updateuploadpreview('+item.id+');" id="changeActionStatusBtn'+i+'">Upload Preview</button>'+viewapprove+'<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}else if(item.order_status_id == 9){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" onclick="updateuploadpreview('+item.id+');" id="changeActionStatusBtn'+i+'">Upload Preview</button>'+viewapprove+'<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'" disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}else if(item.order_status_id == 8){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" disabled id="changeActionStatusBtn'+i+'">Upload Preview</button>'+viewapprove+viewremarks+'<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Sent Printing" title="Sent Printing" onclick="updatesentprint('+item.id+');" id="changeActionStatusBtn'+i+'" >Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}else if(item.order_status_id == 5){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" disabled id="changeActionStatusBtn'+i+'">Upload Preview</button>'+viewapprove+viewremarks+'<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-info" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="updatepackeddispatch('+item.id+');" id="changeActionStatusBtn'+i+'">Packed & Dispatched</button>';
							}else if(item.order_status_id == 7){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" onclick="" disabled id="changeActionStatusBtn'+i+'">Upload Preview</button>'+viewapprove+viewremarks+'<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-info" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'" disabled>Packed & Dispatched</button>';
							}else if(item.order_status_id == 12){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" onclick="updateuploadpreview('+item.id+');" id="changeActionStatusBtn'+i+'">Upload Preview</button>'+viewapprove+viewremarks+'<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}
							else if(item.order_status_id == 11){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" onclick="updateuploadpreview('+item.id+');" id="changeActionStatusBtn'+i+'">Upload Preview</button>'+viewapprove+viewremarks+'<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}
							
							if(item.support_image_show == "Yes"){
							
								support_button = '<a style="color:#0190da;cursor:pointer;" data-tooltip="Support Image" title="Supported Image" onclick="show_supportimage('+item.id+');" id="ShowSupportImageBtn'+i+'" >Click here for supported image</a>';
							}else{
								support_button = "";
							}	
							
							if(item.audio_url !=""){
								audio = '<a target="_blank" href="'+imgURL+item.audio_url+'"><img style="width: 25px;" src="'+imgURL+'admin/image/audio.png"></a><audio id="myAudio'+i+'"><source src="'+imgURL+item.audio_url+'" ><source src="'+imgURL+item.audio_url+'"></audio>';
							}else{
								audio="";
							}
							
							if(item.pattern_no !=""){
								pattern_no = "<p style='margin-bottom:0px;'>Pattern no.: "+item.pattern_no+"</p>";
							}else{
								pattern_no = "";
							}
							
														
							table.row.add([item.order_id, pattern_no+'<br><a href="'+item.pattern_image_url+'" target="_blank"><img src="'+item.pattern_image_url+'" style="width:100px;margin-bottom:10px;" /></a>'+support_button+'<br>'+audio, item.description, 'Qty: '+item.quantity+'<br>Wall size: '+item.wall_size, item.media,item.first_name+' '+item.last_name+'<br> ('+item.user_role_name+')', item.date_time,item.status_name+'<br>'+status_datetime,editButton]).draw();
							
							
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

function playAudio(i) { 
	
		//var aa = 
  var x = document.getElementById('myAudio'+i); 
  x.play(); 
} 

function updateapprovedpreview(order_id){
	
	$.ajax({
			url: serverURL + 'order_preview_approved_status_by_order_id',
			dataType: 'json',
			type: 'post',
			data:{
				order_id: order_id,
				user_id: user_details.id,
				created_by_ip: '1.1.1.1',
				
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
					   message: 'Data Updated Successfully.'
					   },{
						type: 'success',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					if(user_details.user_role_name =="Admin"){
		
						showOrderList();
						
					}else if(user_details.user_role_name =="Distributer"){	
						
						showOrderListDistributer();
						
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
}


function updateuploadpreview(order_id){
	
	$("#edit_footer").html("");
	
	$("#edit_footer").append('<button type="button" class="btn btn-info amibtn" onclick="updateuploadpreviews('+order_id+');" >Submit</button><button type="button" class="btn btn-default amibtn" data-dismiss="modal">Close</button>');
	
	$("#upload_preview_image").modal('show');
}

function upload_preview(){
	
	var file=$("#add_preview_img")[0].files[0]; //sames as here
	var reader  = new FileReader();

	reader.onloadend = function () { 
		$('#preview_img').attr('src', reader.result);
	}

	if (file) {
		reader.readAsDataURL(file); //reads the data as a URL
	} else {
		preview.src = "";
	}
}

function updateuploadpreviews(order_id){
	
	if(document.getElementById('preview_img').getAttribute('src') == "image/img.png"){
			
			$.notify({
					   message: 'Please select preview image'
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
			
			var preview_pic = document.getElementById('preview_img').getAttribute('src');
			
			
	
	
	$.ajax({
			url: serverURL + 'insert_order_approve_by_order_id',
			dataType: 'json',
			type: 'post',
			data:{
				post_job_order_id: order_id,
				upload_image_url: preview_pic,
				description: $("#approve_desc").val(),
				created_by_id: user_details.id,
				
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
					$.ajax({
							url: serverURL + 'order_preview_upload_status_by_order_id',
							dataType: 'json',
							type: 'post',
							data:{
								order_id: order_id,
								user_id: user_details.id,
								created_by_ip: '1.1.1.1',
								
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
									   message: 'Data Updated Successfully.'
									   },{
										type: 'success',
										z_index: 9999,
										delay: 1000,
										placement: {
											from: "bottom",
											align: "right"
										}
									});
									if(user_details.user_role_name =="Admin"){
						
										showOrderList();
										
									}else if(user_details.user_role_name =="Distributer"){	
										
										showOrderListDistributer();
										
									}
									$("#upload_preview_image").modal('hide');
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
					$("#upload_preview_image").modal('hide');
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

function updatesentprint(order_id){
	
	$.ajax({
			url: serverURL + 'order_sent_printing_status_by_order_id',
			dataType: 'json',
			type: 'post',
			data:{
				order_id: order_id,
				user_id: user_details.id,
				created_by_ip: '1.1.1.1',
				
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
					   message: 'Data Updated Successfully.'
					   },{
						type: 'success',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					if(user_details.user_role_name =="Admin"){
		
						showOrderList();
						
					}else if(user_details.user_role_name =="Distributer"){	
						
						showOrderListDistributer();
						
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
}

function updatepackeddispatch(order_id){
	
	$.ajax({
			url: serverURL + 'order_packed_status_by_order_id',
			dataType: 'json',
			type: 'post',
			data:{
				order_id: order_id,
				user_id: user_details.id,
				created_by_ip: '1.1.1.1',
				
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
					   message: 'Data Updated Successfully.'
					   },{
						type: 'success',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					if(user_details.user_role_name =="Admin"){
		
						showOrderList();
						
					}else if(user_details.user_role_name =="Distributor"){	
						
						showOrderListDistributer();
						
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
}

function showOrderListDistributer(){
		
		
		$.ajax({
				url: serverURL + 'get_all_job_distributer',
				dataType: 'json',
				type: 'post',
				data:{
					user_id: user_details.id
				},
				success: function(data){
					if(data.error){
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
					}else{
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
						var status, btn_text, color_code, editButton, new_status, support_button, audio;
						
						var i=1;
						$.map(data.order_details,function(item){
													
							/*if(item.is_active==1){
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
							
							
							editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfUser('+new_status+','+item.id+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';*/
							
							/*if(item.login_permission == 0){
								editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="" id="changeActionStatusBtn'+i+'" style="background-color: #8f8f8f !important;border-color: #8f8f8f !important;" disabled>'+btn_text+'</button>';
							}else if(item.login_permission == 1){
								editButton = '<button type="button" class="btn '+color_code+'" data-tooltip="'+btn_text+'" title="'+btn_text+'" onclick="changeActiveStatusOfUser('+item.id+','+item.is_active+');" id="changeActionStatusBtn'+i+'">'+btn_text+'</button>';
							}*/
							
							/*editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Approved Preview" title="Approved Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-info" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							
							if(item.order_status_id == 4){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Approved Preview" title="Approved Preview" onclick="" id="changeActionStatusBtn'+i+'">Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}
							
							if(item.support_image_show == "Yes"){
							
								support_button = '<button type="button" class="btn btn-info" data-tooltip="Support Image" title="Supported Image" onclick="show_supportimage('+item.id+');" id="ShowSupportImageBtn'+i+'" >Supported Image</button>';
							}else{
								support_button = "";
							}	
														
							table.row.add([item.order_id, '<a href="'+item.pattern_image_url+'" target="_blank"><img src="'+item.pattern_image_url+'" style="width:100px;" /></a>', item.pattern_no, item.description, item.wall_size, item.quantity, item.media,item.date_time,item.first_name+' '+item.last_name+'<br>'+item.user_role_name,item.status_name,support_button,editButton]).draw();*/
							
							editButton ="";
							
							if(item.support_image_show == "Yes"){
							
								support_button = '<a style="color:#0190da;cursor:pointer;" data-tooltip="Support Image" title="Supported Image" onclick="show_supportimage('+item.id+');" id="ShowSupportImageBtn'+i+'" >Click here for supported image</a>';
							}else{
								support_button = "";
							}	
							
							if(item.pattern_no !=""){
								pattern_no = "<p style='margin-bottom:0px;'>Pattern no.: "+item.pattern_no+"</p>";
							}else{
								pattern_no = "";
							}
							
							if(item.audio_url !=""){
								audio = '<a target="_blank" href="'+imgURL+item.audio_url+'"><img style="width: 25px;" src="'+imgURL+'admin/image/audio.png"></a><audio id="myAudio"><source src="'+imgURL+item.audio_url+'" ><source src="'+imgURL+item.audio_url+'"></audio>';
							}else{
								audio="";
							}
							
														
							table.row.add([item.order_id, pattern_no+'<br><a href="'+item.pattern_image_url+'" target="_blank"><img src="'+item.pattern_image_url+'" style="width:100px;margin-bottom:10px;" /></a>'+support_button+'<br>'+audio, item.description, 'Qty: '+item.quantity+'<br>Wall size: '+item.wall_size, item.media,item.first_name+' '+item.last_name+'<br> ('+item.user_role_name+')', item.date_time,item.status_name,editButton]).draw();
							
							
							
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

function show_supportimage(ordersid){
	$.ajax({
				url: serverURL + 'get_supported_image_by_id',
				dataType: 'json',
				type: 'post',
				data:{
					order_id: ordersid
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
						$("#support_image_list").html('');
						$.map(data.image_details,function(item){
													
																					
							$("#support_image_list").append('<a href="'+imgURL+item.image_url+'" target="_blank"><img src="'+imgURL+item.image_url+'" style="width:30%;margin-right: 15px;" /></a>');
							
							
							
						});
						$("#supported_image_modal").modal('show');
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

function show_previewimage(ordersid){
	$.ajax({
				url: serverURL + 'get_approve_image_by_order_id',
				dataType: 'json',
				type: 'post',
				data:{
					post_job_order_id: ordersid
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
						$("#preview_image_list").html('');
						$("#view_desc").html('');
												
																					
							$("#preview_image_list").append('<a href="'+imgURL1+data.upload_image_url+'" target="_blank"><img src="'+imgURL1+data.upload_image_url+'" style="width:40%;margin-right: 15px;" /></a>');
							
							$("#view_desc").text(data.description);
							
						
						$("#preview_image_modal").modal('show');
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

function show_remarks(ordersid){
	$.ajax({
				url: serverURL + 'get_preview_remarks_by_order_id',
				dataType: 'json',
				type: 'post',
				data:{
					post_job_order_id: ordersid
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
						$("#distributor_remarks").html('');
						$("#view_distributer_desc").html('');
						$("#dealer_remarks").html('');
						$("#view_dealer_desc").html('');
												
							if(data.distributor_preview_description !=""){		
							
								$("#distributor_remarks").text("Distributor Remarks :");
								$("#view_distributer_desc").text(data.distributor_preview_description);
								
							}else if(data.dealer_preview_description !=""){
								
								$("#dealer_remarks").text("Dealer Remarks :");
								$("#view_dealer_desc").text(data.dealer_preview_description);
								
							}	
							
						
						$("#preview_remarks_modal").modal('show');
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