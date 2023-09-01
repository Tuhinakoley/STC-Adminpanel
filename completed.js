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
				url: serverURL + 'get_completed_job_by_admin',
				dataType: 'json',
				type: 'get',
				
				success: function(data){
					if(data.error){
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
					}else{
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
						var status, btn_text, color_code, editButton, new_status, support_button;
						
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
							
							/*editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Approved Preview" title="Approved Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							
							if(item.order_status_id == 4){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Approved Preview" title="Approved Preview" onclick="" id="changeActionStatusBtn'+i+'">Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}*/
							
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
							
														
							table.row.add([item.order_id, pattern_no+'<br><a href="'+item.pattern_image_url+'" target="_blank"><img src="'+item.pattern_image_url+'" style="width:100px;margin-bottom:10px;" /></a>'+support_button, item.description, 'Qty: '+item.quantity+'<br>Wall size: '+item.wall_size, item.media,item.first_name+' '+item.last_name+'<br> ('+item.user_role_name+')', item.date_time,item.status_name,editButton]).draw();
							
							
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

function showOrderListDistributer(){
		
		
		$.ajax({
				url: serverURL + 'get_completed_job_distributer',
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
						var status, btn_text, color_code, editButton, new_status, support_button;
						
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
							
							//editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Approved Preview" title="Approved Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-info" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							
							/*if(item.order_status_id == 4){
								
								editButton = '<button type="button" style="margin-bottom: 8px;" class="btn btn-info" data-tooltip="Approved Preview" title="Approved Preview" onclick="" id="changeActionStatusBtn'+i+'">Approved Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Upload Preview" title="Upload Preview" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Upload Preview</button><button type="button" style="margin-bottom: 8px;" class="btn btn-default" data-tooltip="Sent Printing" title="Sent Printing" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Sent Printing</button><button type="button" class="btn btn-default" data-tooltip="Packed & Dispatched" title="Packed & Dispatched" onclick="" id="changeActionStatusBtn'+i+'"  disabled>Packed & Dispatched</button>';
							}*/
							
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
							
							if(item.order_id != ""){							
							
								table.row.add([item.order_id, pattern_no+'<br><a href="'+item.pattern_image_url+'" target="_blank"><img src="'+item.pattern_image_url+'" style="width:100px;margin-bottom:10px;" /></a>'+support_button, item.description, 'Qty: '+item.quantity+'<br>Wall size: '+item.wall_size, item.media,item.first_name+' '+item.last_name+'<br> ('+item.user_role_name+')', item.date_time,item.status_name,editButton]).draw();
							
							}else{
								
								table = $('#table_user').DataTable();
								table.rows().remove().draw();
										
							}	
							
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




}