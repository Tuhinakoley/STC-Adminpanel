function checkmobile(){
	
	if($("#add_mobile").val()!=""){
	$.ajax({
			url: serverURL + 'get_user_send_otp_by_mobile_no',
			dataType: 'json',
			type: 'post',
			data:{
				mobile_no: $("#add_mobile").val()
				
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
				}else{
					sessionStorage.setItem('mobile_no',$("#add_mobile").val());
					$.notify({
					   message: 'OTP sent to your mobile.'
					   },{
						type: 'success',
						z_index: 9999,
						delay: 1000,
						placement: {
							from: "bottom",
							align: "right"
						}
					});
					window.location="otp.html";
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
	}else{
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
	}
}