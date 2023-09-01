var user_details=JSON.parse(sessionStorage.getItem("user_details"));

if(user_details==null){
	window.location="login.html";
}else{
	$(document).ready(function(){
		
		$('#table_user').dataTable({
			searching: false,
			"bPaginate": false,
			"bLengthChange": false,
			"bFilter": true,
			"bInfo": false,
			"ordering": false,
			"bAutoWidth": false });
			
		$('#table_users').dataTable({
			searching: false,
			"bPaginate": false,
			"bLengthChange": false,
			"bFilter": true,
			"bInfo": false,
			"ordering": false,
			"bAutoWidth": false });	
		
		if(user_details.user_role_name == "Admin"){
			
			$("#topdistributors").html('');	
			$("#topdistributors").append('<a href="https://stcapp.stcwallpaper.com/admin/distributor_report.html" style="text-align:right;">View All</a>');	
			
			$("#topmedias").html('');
			$("#topmedias").append('<a href="https://stcapp.stcwallpaper.com/admin/media_report.html" style="text-align:right;">View All</a>');
			
			$("#totalorder").html('');
			$("#totalorder").append('<a href="https://stcapp.stcwallpaper.com/admin/all_report.html" style="text-align:right;">View All</a>');
			
			$("#completeorder").html('');
			$("#completeorder").append('<a href="https://stcapp.stcwallpaper.com/admin/all_report.html" style="text-align:right;">View All</a>');
			
		}	
		
		$.ajax({
				url: serverURL + 'get_current_month_order_details',
				dataType: 'json',
				type: 'get',
				
				success: function(data){
					if(data.error){
						
						$("#amitotalorder").append('<h5 class="text-uppercase">This month orders</h5><span class="counter-icon" style="font-size: 40px;position: absolute;top: 20px;">0 sq.ft.</span><span class="counter-count" style="position: absolute;left: 0;"><span style="font-size:35px; font-weight:300;"> No. of orders: </span><span class="counter-init" data-from="5" data-to="0"></span>0</span>');
						
					}else{
						
						var total = data.Total_sq_ft;
						var total_sq_ft = total.toFixed(2);
						
						$("#amitotalorder").append('<h5 class="text-uppercase">This month orders</h5><span class="counter-icon" style="font-size: 40px;position: absolute;top: 20px;">'+total_sq_ft+' sq.ft.</span><span class="counter-count" style="position: absolute;left: 0;"><span style="font-size:35px; font-weight:300;"> No. of orders: </span><span class="counter-init" data-from="5" data-to="'+data.Total_order+'"></span>'+data.Total_order+'</span>');
						
						
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
				url: serverURL + 'get_current_month_order_distributer',
				dataType: 'json',
				type: 'get',
				
				success: function(data){
					if(data.error){
						
					}else{
						
						table = $('#table_user').DataTable();
						table.rows().remove().draw();
						
						var i =1;
						$.map(data.top_order,function(item){
							
							//$("#topdistributer").append('<p class="counter-icon'+i+'" style="font-size: 14px;">'+item.name+' - '+item.total_order+' order(s)'+' - '+item.total_sqft.toFixed(2)+' sq.ft.</p>');
							
							
							
							table.row.add([item.name, item.total_order,item.total_sqft.toFixed(2)+' sq.ft.']).draw();
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
			
			$.ajax({
				url: serverURL + 'get_current_month_order_media',
				dataType: 'json',
				type: 'get',
				
				success: function(data){
					if(data.error){
						
					}else{
						
						table = $('#table_users').DataTable();
						table.rows().remove().draw();
						
						var i =1;
						$.map(data.media_details,function(item){
							
							//$("#topmedia").append('<p class="counter-icon'+i+'" style="  font-size: 14px;">'+item.media+'</p>');
							table.row.add([item.media_name, item.paper, item.total_order,item.total_sqft.toFixed(2)+' sq.ft.']).draw();
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
			
			$.ajax({
				url: serverURL + 'get_current_month_completed_order_details',
				dataType: 'json',
				type: 'get',
				
				success: function(data){
					if(data.error){
						$("#amicompleteorder").append('<h5 class="text-uppercase">This month completed orders</h5><span class="counter-icon" style="font-size: 40px;position: absolute;top: 20px;">0 sq.ft.</span><span class="counter-count" style="position: absolute;left: 0;"><span style="font-size:35px; font-weight:300;"> No. of orders: </span><span class="counter-init" data-from="5" data-to="0"></span>0</span>');
					}else{
						$("#amicompleteorder").append('<h5 class="text-uppercase">This month completed orders</h5><span class="counter-icon" style="font-size: 40px;position: absolute;top: 20px;">'+data.Total_sq_ft.toFixed(2)+' sq.ft.</span><span class="counter-count" style="position: absolute;left: 0;"><span style="font-size:35px; font-weight:300;"> No. of orders: </span><span class="counter-init" data-from="5" data-to="'+data.Total_order+'"></span>'+data.Total_order+'</span>');
						
						
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
		
	});
}
