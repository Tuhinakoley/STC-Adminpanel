<?php
require_once 'notification.php';
require_once dirname ( __FILE__ ) . '/DbConnect.php';
require_once 'Config.php';


//require_once 'changedatetimeformat.php';
//require_once "vendor/autoload.php";
//require_once "vendor/phpmailer/phpmailer/src/PHPMailer.php";
//require_once 'dbOperation1.php';
class dbOperation extends DbConnect {
	public $conn;
	public $db;
	
	
	
	// for Database connection //////////////////////////////////////////////////////
	function __construct() {
		// opening db connection
		$this->db = new DbConnect ();
		$this->conn = $this->db->connect ();
	}
// /////////////////////////////////////////////////////////

/***** start **** dummy send notification ***** done by AMI-DEV003 *****/	
public function dummySendNotification()
{
		$response = array ();
		
		$obj = new notification ();
		
        $sql1 = "SELECT push_notification_id FROM `Users` WHERE is_active = 1;";
		  
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			//$stmt1->bind_param ( "i" ,$request_address_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($push_notification_id);
				$i = 0;
				while ($result = $stmt1->fetch ()){
					$prof_name_mobile[$i] = array(
						"push_notification_id" => $push_notification_id
						);
						$i++;
				}
				
				$title = "STC WALLPAPER";
				$body = "You have a new notification ";
				$k=0;
				for($j=0; $j<sizeof($prof_name_mobile); $j++){
					
					if($prof_name_mobile[$j]['push_notification_id']!=""){
						$push_notification_id_list[$k] = $prof_name_mobile[$j]['push_notification_id'];
						$k++;
					}
				}
					//$response ['msg']= $push_notification_id_list;
										
				$obj->sendPushNotification($push_notification_id_list,$title,$body);
			}else{
				$response ["error"] = false;
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}
/***** end **** dummy send notification ***** done by AMI-DEV003 *****/	

/***** start **** dummy send notification ***** done by AMI-DEV003 *****/	
/*public function dummySendNotificationForJob($user_id,$post_job_order_id)
{
		$response = array ();
		
		$obj = new notification ();
		
        $sql1 = "SELECT push_notification_id FROM `Users` WHERE is_active = 1 and id =?;";
		  
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($push_notification_id);
				$i = 0;
				while ($result = $stmt1->fetch ()){
					$prof_name_mobile[$i] = array(
						"push_notification_id" => $push_notification_id
						);
						$i++;
				}
				
				$title = "STC WALLPAPER";
				$body = "You have a new notification ";
				$k=0;
				for($j=0; $j<sizeof($prof_name_mobile); $j++){
					
					if($prof_name_mobile[$j]['push_notification_id']!=""){
						$push_notification_id_list[$k] = $prof_name_mobile[$j]['push_notification_id'];
						$k++;
					}
				}
					//$response ['msg']= $push_notification_id_list;
										
				$obj->sendPushNotification($push_notification_id_list,$title,$body);
			}else{
				$response ["error"] = false;
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}*/
/***** end **** dummy send notification ***** done by AMI-DEV003 *****/	


    /********************STATE LIST********************/
    public function getStateList()
	{
		$response = array ();
		$sql1 = "SELECT id, state_name FROM State where is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "ssi" ,$given_email_id,$given_mobile_no,$id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $state_name);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$state_list[$i] = array(
						"id" => $id,
						"state_name" => $state_name
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["state_list"] = $state_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["state_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/********************DISTRICT LIST********************/
    public function getDistrictListByStateId($state_id)
	{
		$response = array ();
		$sql1 = "SELECT id, district_name FROM District where is_active = 1 AND state_id = ?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$state_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($district_id, $district_name);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$district_list[$i] = array(
						"district_id" => $district_id,
						"district_name" => $district_name
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["district_list"] = $district_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["district_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	 
	/********************CITY LIST BY STATE ID********************/
    public function getCityListByDistrictId($district_id)
	{
		$response = array ();
		$sql1 = "SELECT id, city_name FROM City where is_active = 1 AND district_id = ?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$district_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($city_id, $city_name);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$city_list[$i] = array(
						"city_id" => $city_id,
						"city_name" => $city_name
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["city_list"] = $city_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["city_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	public function getCityListByStateId($state_id)
	{
		$response = array ();
		$sql1 = "SELECT id, city_name FROM City where is_active = 1 AND state_id = ?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$state_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($city_id, $city_name);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$city_list[$i] = array(
						"city_id" => $city_id,
						"city_name" => $city_name
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["city_list"] = $city_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["city_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	
	/**** start **** checking mobile number or password ****/	
public function checkingAdminMobileNoPassword($mobile_number,$password)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT u.id, ur.id, ur.user_role_name, u.first_name, u.last_name, u.email_id, u.city_id FROM Users u, User_roles ur WHERE u.mobile_number=? and u.password=? and u.user_role_id = ur.id and u.is_active=1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "ss" ,$mobile_number, $password);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $user_role_id, $user_role_name, $first_name, $last_name, $email_id, $city_id);
				$result = $stmt1->fetch ();
			   
				if($user_role_id == 1){
					$response ["error"] = false;
					$response ["id"] = $id;
					$response ["user_role_id"] = $user_role_id;
					$response ["user_role_name"] = $user_role_name;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["email_id"] = $email_id;
					$response ["city_id"] = $city_id;
					$response ["msg"] = "Login Success";
				}elseif($user_role_id == 2){
					$response ["error"] = false;
					$response ["id"] = $id;
					$response ["user_role_id"] = $user_role_id;
					$response ["user_role_name"] = $user_role_name;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["email_id"] = $email_id;
					$response ["city_id"] = $city_id;
					$response ["msg"] = "Login Success";
				}else{
					$response ["error"] = true;
					$response ["msg"] = "You donot have access to login here";
				}	
					
			}else{
				$response ["error"] = true;
				$response ["msg"] = "Please enter correct mobile number or password";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

public function checkingMobileNoPassword($mobile_number,$password,$device_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.email_id, u.device_id, ur.user_role_name FROM Users u, User_roles ur WHERE u.mobile_number=? and u.password=? and u.is_active=1 and ur.id = u.user_role_id ;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "ss" ,$mobile_number, $password);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $email_id, $devices_id, $user_role_name);
				$result = $stmt1->fetch ();
				if($user_role_name != "Admin"){
					if ($devices_id == $device_id){
						
						//$response ["error"] = false;
						//$response ["msg"] ="login Successfully";
						
						$this->updateIsLoginById($id);
						$response ["id"] = $id;
						$response ["first_name"] = $first_name;
						$response ["last_name"] = $last_name;
						$response ["email_id"] = $email_id;
						$response ["devices_id"] = $devices_id;
						$response ["msg"] ="login Successfully";
						
					}else {
						$response ["error"] = false;
						$response ["id"] = $id;
						$response ["first_name"] = $first_name;
						$response ["last_name"] = $last_name;
						$response ["email_id"] = $email_id;
						$response ["devices_id"] = $devices_id;
						$this->updateDeviceIdById($device_id, $id);
						$this->FetchDeviceId($device_id, $id);
						$response ["msg"] = "Device Found";
					}
				}else{
					$response ["error"] = true;
				    $response ["msg"] = "You do not have permission to login.";
				}		
			}else{
				$response ["error"] = true;
				//$response ["msg"] = "You donot have access to login here";
				$response ["msg"] = "Please enter correct mobile number and password";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}
	

public function checkingMobileNoPassword_Pushnotification($mobile_number,$password,$device_id,$push_notification_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.email_id, u.device_id, ur.user_role_name FROM Users u, User_roles ur WHERE u.mobile_number=? and u.password=? and u.is_active=1 and ur.id = u.user_role_id ;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "ss" ,$mobile_number, $password);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $email_id, $devices_id, $user_role_name);
				$result = $stmt1->fetch ();
				if($user_role_name != "Admin"){
					if ($devices_id == $device_id){
						
						//$response ["error"] = false;
						//$response ["msg"] ="login Successfully";
						
						$this->updateIsLoginPushnotificationById($id, $push_notification_id);
						$response ["id"] = $id;
						$response ["first_name"] = $first_name;
						$response ["last_name"] = $last_name;
						$response ["email_id"] = $email_id;
						$response ["devices_id"] = $devices_id;
						$response ["msg"] ="login Successfully";
						
					}else {
						$response ["error"] = false;
						$response ["id"] = $id;
						$response ["first_name"] = $first_name;
						$response ["last_name"] = $last_name;
						$response ["email_id"] = $email_id;
						$response ["devices_id"] = $devices_id;
						$this->updateDeviceIdPushnotificationById($device_id, $push_notification_id, $id);
						$this->FetchDeviceIdPushNotificationId($device_id, $push_notification_id, $id);
						$response ["msg"] = "Device Found";
					}
				}else{
					$response ["error"] = true;
				    $response ["msg"] = "You do not have permission to login.";
				}		
			}else{
				$response ["error"] = true;
				//$response ["msg"] = "You donot have access to login here";
				$response ["msg"] = "Please enter correct mobile number and password";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}


public function updateIsLoginPushnotificationById($id, $push_notification_id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$is_login = 1;
		
		$sql1 = "UPDATE Users SET is_login=?, push_notification_id=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "isi" ,$is_login, $push_notification_id, $id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}		
	
	
public function updateIsLoginById($id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$is_login = 1;
		
		$sql1 = "UPDATE Users SET is_login=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$is_login, $id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function FetchDeviceIdPushNotificationId($deviceid, $push_notification_id, $user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT id, first_name, last_name, email_id, device_id FROM Users WHERE device_id=? and id!=? ;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "si" ,$deviceid, $user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $email_id, $devices_id);
				$result = $stmt1->fetch ();
				$this->updateOtherDeviceIdById($id);
			}else{
				$response ["error"] = false;
				$this->updateDeviceIdPushnotificationById($deviceid, $push_notification_id, $user_id);
				//$response ["msg"] = "WrongOtp1";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}


public function FetchDeviceId($deviceid, $user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT id, first_name, last_name, email_id, device_id FROM Users WHERE device_id=? and id!=? ;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "si" ,$deviceid, $user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $email_id, $devices_id);
				$result = $stmt1->fetch ();
				$this->updateOtherDeviceIdById($id);
			}else{
				$response ["error"] = false;
				$this->updateDeviceIdById($deviceid, $user_id);
				//$response ["msg"] = "WrongOtp1";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

public function updateDeviceIdPushnotificationById($device_ids, $push_notification_id, $id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$is_login = 1;	
		
		$sql1 = "UPDATE Users SET is_login=?, device_id=?, push_notification_id=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "issi" ,$is_login, $device_ids, $push_notification_id, $id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function FetchDeviceIdByLoginId($deviceid)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT id, first_name, last_name, email_id, device_id FROM Users WHERE device_id=? and is_login=1 ;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$deviceid);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $email_id, $devices_id);
				$result = $stmt1->fetch ();
				$response ["id"] = $id;
				$response ["first_name"] = $first_name;
				$response ["last_name"] = $last_name;
				$response ["email_id"] = $email_id;
				$response ["devices_id"] = $devices_id;
			}else{
				$response ["error"] = true;
				$response ["msg"] = "No Details Found";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

public function updateOtherDeviceIdById($id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$is_login = 0;
		$devicesid = "";
		
		$sql1 = "UPDATE Users SET is_login=?, device_id=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "isi" ,$is_login, $device_id, $id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function updateDeviceIdById($device_ids, $id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$is_login = 1;	
		
		$sql1 = "UPDATE Users SET is_login=?, device_id=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "isi" ,$is_login, $device_ids, $id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function updateProfileById($first_name, $last_name, $companyName, $office_address, $city_id, $state_id, $email_id, $pin_code, $profile_picture, $company_logo, $modify_by_id, $id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$modify_by_ip = "1.1.1.1";
				
		$sql1 = "UPDATE Users SET first_name=?, last_name=?, companyName=?, office_address=?, city_id=?, state_id=?, email_id=?, pin_code=?, modify_by_ip=?, modify_by_id=?, modify_date_time=? where id = ?";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ssssiisssisi" ,$first_name, $last_name, $companyName, $office_address, $city_id, $state_id, $email_id, $pin_code, $modify_by_ip, $modify_by_id, $date, $id);
			
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				/*$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";*/
				
				if($profile_picture !="" && $company_logo !="" ){
					
					$profile_pic = "backend/profile/".$profile_picture;
					$company_url = "backend/profile/".$company_logo;
					$this->updateProfileCompanyImageUrlById($id,$profile_pic,$company_url);
					
				}elseif($profile_picture !="" && $company_logo ==""){
					
					$profile_pic = "backend/profile/".$profile_picture;
					$this->updateProfileImageUrlById($id,$profile_pic);
					
				}elseif($profile_picture =="" && $company_logo !=""){
					
					$company_url = "backend/profile/".$company_logo;
					$this->updateCompanyImageUrlById($id,$company_url);
					
				}else{
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				}	
				
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function AdminupdateProfileById($first_name, $last_name, $companyName, $office_address, $city_id, $state_id, $email_id, $pin_code, $profile_picture, $company_logo, $modify_by_id, $id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$modify_by_ip = "1.1.1.1";
		
		if($profile_picture!= ""){
			$savePath = "../backend/profile/";
			$new_savePath1 = "backend/profile/";
			$imageName = "profile_".Date ( "YmdHis" );
			$profile_path = $this->allKindOfFileUpload($profile_picture, $savePath, $imageName, $new_savePath1);
			$pro_pic = $profile_path["image_url"];
		}else{
			$pro_pic ="";
		}		
		
		if($company_logo !=""){			
			$savePath1 = "../backend/company/";
			$new_savePath11 = "backend/company/";
			$imageName1 = "company_".Date ( "YmdHis" );
			$company_path = $this->allKindOfFileUpload($company_logo, $savePath1, $imageName1, $new_savePath11);
			$cpath = $company_path["image_url"];
		}else{
			$cpath = "";
			
		}
		
		$sql1 = "UPDATE Users SET first_name=?, last_name=?, companyName=?, profilePicture=?, company_logo=?, office_address=?, city_id=?, state_id=?, email_id=?, pin_code=?, modify_by_ip=?, modify_by_id=?, modify_date_time=? where id = ?";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ssssssiisssisi" ,$first_name, $last_name, $companyName, $pro_pic, $cpath, $office_address, $city_id, $state_id, $email_id, $pin_code, $modify_by_ip, $modify_by_id, $date, $id);
			
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				
				
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}


public function updateDealerProfileById($first_name, $last_name, $companyName, $office_address, $city_id, $state_id, $email_id, $pin_code, $profile_picture, $company_logo, $parent_user_id, $modify_by_id, $id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$modify_by_ip = "1.1.1.1";
		
		if($profile_picture!= ""){
			$savePath = "../backend/profile/";
			$new_savePath1 = "backend/profile/";
			$imageName = "profile_".Date ( "YmdHis" );
			$profile_path = $this->allKindOfFileUpload($profile_picture, $savePath, $imageName, $new_savePath1);
			$pro_pic = $profile_path["image_url"];
		}else{
			$pro_pic ="";
		}		
		
		if($company_logo !=""){			
			$savePath1 = "../backend/company/";
			$new_savePath11 = "backend/company/";
			$imageName1 = "company_".Date ( "YmdHis" );
			$company_path = $this->allKindOfFileUpload($company_logo, $savePath1, $imageName1, $new_savePath11);
			$cpath = $company_path["image_url"];
		}else{
			$cpath = "";
			
		}
		
		$sql1 = "UPDATE Users SET first_name=?, last_name=?, companyName=?, profilePicture=?, company_logo=?, office_address=?, city_id=?, state_id=?, email_id=?, pin_code=?, parent_user_id=?, modify_by_ip=?, modify_by_id=?, modify_date_time=? where id = ?";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ssssssiissisisi" ,$first_name, $last_name, $companyName, $pro_pic, $cpath, $office_address, $city_id, $state_id, $email_id, $pin_code, $parent_user_id, $modify_by_ip, $modify_by_id, $date, $id);
			
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				
				
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

/*update user profile picture and company*/
	function updateProfileCompanyImageUrlById($user_id,$profile_picture,$company_logo){
		
		try {
			$response = array ();
			$current_date_time= date("Y-m-d H:i:s");
			$this->conn->autocommit ( false );
			$sql = "UPDATE Users set `profilePicture` = ?, `company_logo` = ? where `id` = ?;";
			$stmt = $this->conn->prepare ( $sql );
			if ($stmt) {
				$stmt->bind_param ( "ssi", $profile_picture,$company_logo,$user_id);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {
					
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED_SUCCESSFULLY";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$response ['error'] = true;
				$response ['msg'] = QUERY_EXCEPTION;
			}
			
			return $response;
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			echo $e->getMessage ();
		}
		return $response;
	}
	
	/*** update user profile picture ***/
	function updateProfileImageUrlById($user_id,$profile_picture){
		
		try {
			$response = array ();
			$current_date_time= date("Y-m-d H:i:s");
			$this->conn->autocommit ( false );
			$sql = "UPDATE Users set `profilePicture` = ? where `id` = ?;";
			$stmt = $this->conn->prepare ( $sql );
			if ($stmt) {
				$stmt->bind_param ( "si", $profile_picture,$user_id);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {
					
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED_SUCCESSFULLY";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$response ['error'] = true;
				$response ['msg'] = QUERY_EXCEPTION;
			}
			
			return $response;
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			echo $e->getMessage ();
		}
		return $response;
	}
	
	/*update user company*/
	function updateCompanyImageUrlById($user_id,$company_logo){
		
		try {
			$response = array ();
			$current_date_time= date("Y-m-d H:i:s");
			$this->conn->autocommit ( false );
			$sql = "UPDATE Users set `company_logo` = ? where `id` = ?;";
			$stmt = $this->conn->prepare ( $sql );
			if ($stmt) {
				$stmt->bind_param ( "si", $company_logo,$user_id);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {
					
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED_SUCCESSFULLY";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$response ['error'] = true;
				$response ['msg'] = QUERY_EXCEPTION;
			}
			
			return $response;
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			echo $e->getMessage ();
		}
		return $response;
	}

/**** start **** image upload dynamic with image path **** AMIDEV-003 *****/
	function imageUpload($image, $savePath, $imageName, $server_path){
        
        if( $image != ""){
            
            
            $b64image = base64_encode(file_get_contents($image));                            
            $im = base64_decode ( $b64image );                        
            $im = base64_decode ( $image );                        
            imagejpeg(imagecreatefromstring($im), $savePath . '/' . (string)$imageName . ".jpg" , 20);
                
            $document_url= $server_path.(string)$imageName.".jpg";
            
            $response ["image_url"] = $document_url;
        }else{
            
            $response ["image_url"] = "";
        }
        return $response;
    }
	
	/********************allKindOfFileUpload**************************/
		
	/*public function allKindOfFileUpload1($image, $new_savePath, $imageName){
		$response = array();
		$savePath = "../".$new_savePath;
		$encoded_string = base64_encode(file_get_contents($image));
		$decoded_file = base64_decode($encoded_string); // decode the file
		$mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE);// extract mime type
		$extension = $this->mime2ext($mime_type); // extract extension from mime type
		$file_dir = $savePath.(string)$imageName.".".$extension;
		$document_url = $new_savePath.(string)$imageName.".".$extension;
		try {
			file_put_contents($file_dir, $decoded_file); // save
			
		} catch (Exception $e) {
			header('Content-Type: application/json');
			echo json_encode($e->getMessage());
		}
		$response ["image_url"] = $document_url;
		return $response;
	}*/
	
	public function uploadFileTest11($str){
		$savePath = "profile/";
		$imageName = Date ( "YmdHis" )."_profile_qwe";
		//$server_path = SERVER_NAME.SERVER_FOLDER_LAYER."profile/";
		//$profile_pic = $this->allKindOfFileUpload($profile_picture, $savePath, $imageName);
		$profile_pic = $this->uploadFileTest($str);
		
	}
	
	
	
	public function allKindOfFileUpload($image, $new_savePath, $imageName, $newpath){
		$response = array();
		$encoded_string = base64_encode(file_get_contents($image));
		$savePath = "../".$new_savePath;
		$decoded_file = base64_decode($encoded_string); // decode the file
		$mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE);// extract mime type
		$extension = $this->mime2ext($mime_type); // extract extension from mime type
		//$file = 'Test.'. $extension; // rename file as a unique name
		$file_dir = $savePath.(string)$imageName.".".$extension;
		$document_url = $new_savePath.(string)$imageName.".".$extension;
		$new_url = $newpath.(string)$imageName.".".$extension;
		try {
			file_put_contents($file_dir, $decoded_file); // save
			
		} catch (Exception $e) {
			header('Content-Type: application/json');
			echo json_encode($e->getMessage());
		}
		$response ["image_url"] = $new_url;
		return $response;
	}
	
	public function uploadFileTest($str){
		$response = array();
		//$encoded_string = base64_encode($str);
		$encoded_string = base64_encode(file_get_contents($str));
		//echo $encoded_string;
		$target_dir = '../profile/'; // add the specific path to save the file
		$decoded_file = base64_decode($encoded_string); // decode the file
		$mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
		//echo $decoded_file;
		$extension = $this->mime2ext($mime_type); // extract extension from mime type
		//echo $extension;
		//$file = uniqid() .'.'. $extension; // rename file as a unique name
		$file = 'Test.'. $extension; // rename file as a unique name
		//$file_dir = $target_dir . uniqid() .'.'. $extension;
		$imageName = Date ( "YmdHis" )."_profile_dfds";
		$file_dir = $target_dir .(string)$imageName.'.'. $extension;
		$file_dir1 = 'Test.'. $extension;
		//echo "   ".$file_dir."   ". $decoded_file;
		try {
			file_put_contents($file_dir, $decoded_file); // save
			//database_saving($file);
			//header('Content-Type: application/json');
			//echo json_encode("File Uploaded Successfully");
		} catch (Exception $e) {
			header('Content-Type: application/json');
			echo json_encode($e->getMessage());
		}

		$response["img"] = $file_dir;
			
		return $response;
	} 
	
	public function mime2ext($mime){
    $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
    "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
    "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
    "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
    "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
    "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
    "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
    "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
    "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
    "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
    "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
    "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
    "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
    "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
    "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
    "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
    "pdf":["application\/pdf","application\/octet-stream"],
    "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
    "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
    "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
    "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
    "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
    "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
    "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
    "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
    "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
    "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
    "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
    "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
    "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
    "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
    "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
    "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
    "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
    "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
    "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
    "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
    "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
    "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
    "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
    "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
    "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
    "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
    "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
    "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
    $all_mimes = json_decode($all_mimes,true);
    foreach ($all_mimes as $key => $value) {
        if(array_search($mime,$value) !== false) return $key;
    }
    return false;
	}
	
	/**** end **** image upload dynamic with image path **** AMIDEV-003 *****/
	/************* get user data by user id **************/
	
	public function GetUserDetailsByUserId($user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.companyName, u.profilePicture, u.company_logo, u.email_id, u.mobile_number, u.office_address, u.city_id, c.city_name, u.state_id, s.state_name, u.pin_code, u.device_id, ur.user_role_name FROM Users u, City c, State s, User_roles ur WHERE u.city_id = c.id and u.user_role_id = ur.id and u.state_id = s.id and u.id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $companyName, $profilePicture, $company_logo, $email_id, $mobile_number, $office_address, $city_id, $city_name, $state_id, $state_name, $pin_code, $devices_id, $user_role_name);
				$result = $stmt1->fetch ();
					
					if($companyName !="" && $profilePicture !=""){
						$flag = 0;
					}elseif($companyName !="" && $profilePicture ==""){
						$flag = 1;
					}elseif($companyName =="" && $profilePicture !=""){
						$flag = 2;
					}elseif($companyName =="" && $profilePicture ==""){
						$flag = 3;
					}	
					
					$response ["error"] = false;
					$response ["msg"] = "User Details Found.";
					$response ["id"] = $id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["companyName"] = $companyName;
					$response ["profilePicture"] = $profilePicture;
					$response ["company_logo"] = $company_logo;
					$response ["email_id"] = $email_id;
					$response ["mobile_number"] = $mobile_number;
					$response ["office_address"] = $office_address;
					$response ["city_id"] = $city_id;
					$response ["city_name"] = $city_name;
					$response ["state_id"] = $state_id;
					$response ["state_name"] = $state_name;
					$response ["pin_code"] = $pin_code;
					$response ["devices_id"] = $devices_id;
					$response ["user_role_name"] = $user_role_name;
					$response ["flag"] = $flag;
					
					
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "User Details Not Found.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

/************* get user data by user id **************/
	
	public function GetUserDetailsByUserIdAdmin($user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.companyName, u.profilePicture, u.company_logo, u.email_id, u.mobile_number, u.office_address, u.city_id, c.city_name, u.state_id, s.state_name, u.pin_code, u.device_id, ur.user_role_name, u.parent_user_id FROM Users u, City c, State s, User_roles ur WHERE u.city_id = c.id and u.user_role_id = ur.id and u.state_id = s.id and u.id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $companyName, $profilePicture, $company_logo, $email_id, $mobile_number, $office_address, $city_id, $city_name, $state_id, $state_name, $pin_code, $devices_id, $user_role_name, $parent_user_id);
				$result = $stmt1->fetch ();
					
					if($companyName !="" && $profilePicture !=""){
						$flag = 0;
					}elseif($companyName !="" && $profilePicture ==""){
						$flag = 1;
					}elseif($companyName =="" && $profilePicture !=""){
						$flag = 2;
					}elseif($companyName =="" && $profilePicture ==""){
						$flag = 3;
					}	
					
					$parent = $this->getParentUserDetails($parent_user_id);
					
					$response ["error"] = false;
					$response ["msg"] = "User Details Found.";
					$response ["id"] = $id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["companyName"] = $companyName;
					$response ["profilePicture"] = $profilePicture;
					$response ["company_logo"] = $company_logo;
					$response ["email_id"] = $email_id;
					$response ["mobile_number"] = $mobile_number;
					$response ["office_address"] = $office_address;
					$response ["city_id"] = $city_id;
					$response ["city_name"] = $city_name;
					$response ["state_id"] = $state_id;
					$response ["state_name"] = $state_name;
					$response ["pin_code"] = $pin_code;
					$response ["devices_id"] = $devices_id;
					$response ["user_role_name"] = $user_role_name;
					$response ["parent_user_id"] = $parent_user_id;
					$response ["parent_first_name"] = $parent["first_name"];
					$response ["parent_last_name"] = $parent["last_name"];
					$response ["parent_user_role_name"] = $parent["user_role_name"];
					$response ["flag"] = $flag;
					
					
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "User Details Not Found.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}


public function CheckPasswordByUserId($new_password,$retype_password,$old_password,$device_id,$modify_by_ip,$modify_by_id,$user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		//$sql1 = "SELECT id, password, device_id FROM Users WHERE device_id=? and password=? and id=?;";
		$sql1 = "SELECT id, password, device_id FROM Users WHERE device_id=? and id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			//$stmt1->bind_param ( "ssi" ,$device_id, $old_password, $user_id);	
			$stmt1->bind_param ( "si" ,$device_id, $user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $oldpassword, $device_id);
				$result = $stmt1->fetch ();
				
				if($old_password != $oldpassword){
					
					$response ["error"] = true;
					$response ["msg"] = "Entered old password is wrong.";
					
				}else if($old_password == $new_password){
					
					$response ["error"] = true;
					$response ["msg"] = "New password cannot be same as old password.";
					
				}else if($new_password != $retype_password){
					$response ["error"] = true;
					$response ["msg"] = "New password and re-enter new password do not match.";

				}else{		
				
					//$response ["error"] = false;
					$this->updatePasswordById($new_password,$retype_password,$modify_by_ip,$modify_by_id,$user_id);
					//$response ["msg"] = "User Details Found";
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				}
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "Either you have used a wrong password or you are simultenously login into another device. Kindly log-out and re-login to update your password.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}


public function CheckPasswordAdminByUserId($new_password,$retype_password,$old_password,$modify_by_ip,$modify_by_id,$user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT id, password FROM Users WHERE password=? and id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "si" , $old_password, $user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $oldpassword);
				$result = $stmt1->fetch ();
				
				if($oldpassword != $old_password){
					
					$response ["error"] = true;
					$response ["msg"] = "Entered old password is wrong.";
					
				}else if($old_password == $new_password){
					
					$response ["error"] = true;
					$response ["msg"] = "New password cannot be same as old password.";
					
				}else if($new_password != $retype_password){
					$response ["error"] = true;
					$response ["msg"] = "New password and re-enter new password do not match.";

				}else{		
				
					//$response ["error"] = false;
					$this->updatePasswordById($new_password,$retype_password,$modify_by_ip,$modify_by_id,$user_id);
					//$response ["msg"] = "User Details Found";
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				}
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "Either you have used a wrong password or you are simultenously login into another device. Kindly log-out and re-login to update your password.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}


public function updateNewPasswordById($new_password,$retype_password,$user_id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$mdate = date ("Y-m-d H:i:s");
		if($new_password != $retype_password){
			
			$response ["error"] = true;
			$response ["msg"] = "New password and re-enter new password do not match.";

		}else{
				
			$sql1 = "UPDATE Users SET password=?,modify_by_id=?,modify_date_time=? where id = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "sisi" ,$new_password,$user_id,$mdate,$user_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		}	
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function updatePasswordById($new_password,$retype_password,$modify_by_ip,$modify_by_id,$user_id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$mdate = date ("Y-m-d H:i:s");
		
				
			$sql1 = "UPDATE Users SET password=?,modify_by_ip=?,modify_by_id=?,modify_date_time=? where id = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ssisi" ,$new_password,$modify_by_ip,$modify_by_id,$mdate,$user_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
			
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}


/******************* Forgot Password update  *******************/

public function CheckForgotPasswordByUserId($new_password,$retype_password,$old_password,$modify_by_ip,$mobile_no)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT id, password, device_id FROM Users WHERE password=? and mobile_number=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "ss" , $old_password, $mobile_no);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id, $password, $device_id);
				$result = $stmt1->fetch ();
				//$response ["error"] = false;
				$this->updatePasswordById($new_password,$retype_password,$modify_by_ip,$user_id,$user_id);
				//$response ["msg"] = "User Details Found";
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "You have used a wrong password.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

public function CheckForgotPasswordByMobile($new_password,$retype_password,$modify_by_ip,$mobile_no)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT id, password, device_id FROM Users WHERE mobile_number=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "s" , $mobile_no);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id, $password, $device_id);
				$result = $stmt1->fetch ();
				//$response ["error"] = false;
				$this->updatePasswordById($new_password,$retype_password,$modify_by_ip,$user_id,$user_id);
				//$response ["msg"] = "User Details Found";
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "You have used a wrong password.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}



/*START SEND OTP TO GIVEN MOBILE NO*/
public function checkingMobileNoForOtpGenerate($mobile_no)
{
		$response = array ();
	
		$sql1 = "SELECT mobile_number, user_role_id FROM Users WHERE mobile_number=? and is_active=1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$mobile_no);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				
				$stmt1->bind_result($mobile_number, $user_role_id);
				$result = $stmt1->fetch ();
				
				if($user_role_id == 3){
					
					$response ["error"] = true;
					$response ["msg"] = "You do not have permission to access this panel.";
					
				}else{
					$response = $this->sendOtpByMobileForOtpGenerate ($mobile_no);
				}
			}else {	
				$response ["error"] = true;
				$response ["msg"] = "Mobile does not exist.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

public function sendOtpByMobileForOtpGenerate ($mobile_no) {
	        
		$response = array ();
		
		$crt_otp = new utility ();
		$generate_otp = $crt_otp->generateOTP();
			
		$sql1 = "SELECT otp FROM Users WHERE otp=?;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "s", $generate_otp);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) 	{
			
				$this->sendOtpByMobileForOtpGenerate ($mobile_no);
			} else{
			
			$this->updateOtpToMobile ($mobile_no,$generate_otp);
			$user = $this->	GetUserDetailsByMobile($mobile_no);
					$response ["error"] = false;
			        $response ["msg"] = "DATA_FOUND";
					$response ["otp"] = $generate_otp;
					$response ["user_id"] = $user["id"];
					
				
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	  /*update otp by mobile no*/
public function updateOtpToMobile ($mobile_no,$generate_otp){	
		try {
			$this->conn->autocommit ( false );
			$response = array ();
			
			$date = date ("Y-m-d H:i:s");
			$validDate = date('Y-m-d H:i:s', strtotime("+15 min"));
			
			$sql1 = "UPDATE Users SET otp = ?, otp_datetime=?, otp_valid_till=? where mobile_number = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ssss" ,$generate_otp,$date,$validDate,$mobile_no);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
					$this->sendOTP ($generate_otp,$mobile_no);
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION3";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	/*********** Send OTP on user Mobile **************/

public function GetUserDetailsByMobile($mobile_no)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.companyName, u.profilePicture, u.company_logo, u.email_id, u.mobile_number, u.office_address, u.city_id, c.city_name, u.state_id, s.state_name, u.pin_code, u.device_id, ur.user_role_name FROM Users u, City c, State s, User_roles ur WHERE u.city_id = c.id and u.user_role_id = ur.id and u.state_id = s.id and u.mobile_number=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$mobile_no);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $companyName, $profilePicture, $company_logo, $email_id, $mobile_number, $office_address, $city_id, $city_name, $state_id, $state_name, $pin_code, $devices_id, $user_role_name);
				$result = $stmt1->fetch ();
					
					if($companyName !="" && $profilePicture !=""){
						$flag = 0;
					}elseif($companyName !="" && $profilePicture ==""){
						$flag = 1;
					}elseif($companyName =="" && $profilePicture !=""){
						$flag = 2;
					}elseif($companyName =="" && $profilePicture ==""){
						$flag = 3;
					}	
					
					$response ["error"] = false;
					$response ["msg"] = "User Details Found.";
					$response ["id"] = $id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["companyName"] = $companyName;
					$response ["profilePicture"] = $profilePicture;
					$response ["company_logo"] = $company_logo;
					$response ["email_id"] = $email_id;
					$response ["mobile_number"] = $mobile_number;
					$response ["office_address"] = $office_address;
					$response ["city_id"] = $city_id;
					$response ["city_name"] = $city_name;
					$response ["state_id"] = $state_id;
					$response ["state_name"] = $state_name;
					$response ["pin_code"] = $pin_code;
					$response ["devices_id"] = $devices_id;
					$response ["user_role_name"] = $user_role_name;
					$response ["flag"] = $flag;
					
					
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "User Details Not Found.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

public function sendOTP ($generate_otp,$given_mobile_no)
{
$response = file_get_contents(SMS_URL.'&number='.$given_mobile_no.'&message=Your%20OTP%20is%20'.$generate_otp.'.%20Do%20not%20share%20it%20with%20any%20one');
}

/*START checking OTP*/
public function checkingOtpByMobileNo ($mobile_no,$otp)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		$sql1 = "SELECT id, otp, otp_valid_till FROM Users WHERE mobile_number=? and is_active=1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$mobile_no);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $original_otp,$otp_valid_till);
				$result = $stmt1->fetch ();
			   
				if ($original_otp == $otp){
					
					if($current_date_time<=$otp_valid_till){
						
						$response ["error"] = false;
						$response ["msg"] ="OTPVerficationSuccess";
						$response ["id"] = $id;
						
					}else{
						$response ["error"] = false;
						$response ["msg"] ="OTPExpired";
					}
				}else {
					$response ["error"] = true;
					$response ["msg"] = "WrongOtp";
				}	
			}else{
				$response ["error"] = true;
				$response ["msg"] = "WrongOtp";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}
	
public function LogoutByUserId($id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		$date = date ("Y-m-d H:i:s");
		$is_login = 0;
		$devicesid = "";
		
		$sql1 = "UPDATE Users SET is_login=?, device_id=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "isi" ,$is_login, $device_id, $id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "Logout Successfully";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}
	
public function fetchCatlogMaster()
{
		$response = array ();
	
		$sql1 = "SELECT id, catlog_name, catlog_image FROM catlog_master WHERE is_active=1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			//$stmt1->bind_param ( "s" ,$mobile_no);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				
				$stmt1->bind_result($id, $catlog_name, $catlog_image);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_iamge" => $catlog_image
						
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["catlog_list"] = $catlog_list;
				
			}else {	
				$response ["error"] = true;
				$response ["msg"] = "DataNotExist";
				$response ["catlog_list"] = "";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}	

public function fetchSubCatlogByCatlogMasterId($catlog_master_id)
{
		$response = array ();
	
		//$sql1 = "SELECT id, catlog_sub_category_name, sub_category_img_url FROM catlog_sub_category WHERE catlog_master_id=? and is_active=1;";
		$sql1 = "SELECT id, pattern_no, image_url FROM stock_catalog WHERE stock_catalog_master_id=? and is_active=1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$catlog_master_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				
				$stmt1->bind_result($id, $catlog_sub_category_name, $sub_category_img_url);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$sub_catlog_list[$i] = array(
						"id" => $id,
						"catlog_sub_category_name" => $catlog_sub_category_name,
						"sub_category_img_url" => $sub_category_img_url
						
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["sub_catlog_list"] = $sub_catlog_list;
				
			}else {	
				$response ["error"] = true;
				$response ["msg"] = "DataNotExist";
				$response ["sub_catlog_list"] = "";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}	

/********************Media Sheet LIST********************/
    public function getMediaSheetList()
	{
		$response = array ();
		$sql1 = "SELECT id, sheet_name, sheet_number FROM media_sheet_type where is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "ssi" ,$given_email_id,$given_mobile_no,$id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $sheet_name, $sheet_number);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$sheet_list[$i] = array(
						"id" => $id,
						"sheet_name" => $sheet_name,
						"sheet_number" => $sheet_number
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["sheet_list"] = $sheet_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["sheet_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTIONs";
		}
		return $response;
	}
	
	/******************** Get catlog master detials by catlog name ********************/
    public function getCatlogDetailsByCatlogName($name)
	{
		
		$name11 = '%'.$name.'%';
		$response = array ();
		$sql1 = "SELECT id, catlog_name, catlog_image FROM catlog_master where catlog_name LIKE ? and is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$name11);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_name, $catlog_image);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_image" => $catlog_image
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["catlog_list"] = $catlog_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["catlog_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get catlog sub category detials by catlog sub name ********************/
    public function getSubCatlogDetailsBysubCatlogName($name, $catlog_master_id)
	{
		
		$name11 = '%'.$name.'%';
		$response = array ();
		$sql1 = "SELECT id, catlog_sub_category_name, sub_category_img_url FROM catlog_sub_category where catlog_name LIKE ? and catlog_master_id = ? and is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "si" ,$name11,$catlog_master_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_sub_category_name, $sub_category_img_url);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$catlog_sub_category_list[$i] = array(
						"id" => $id,
						"catlog_sub_category_name" => $catlog_sub_category_name,
						"sub_category_img_url" => $sub_category_img_url
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["catlog_sub_category_list"] = $catlog_sub_category_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["catlog_sub_category_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get customise catlog master detials by catlog name ********************/
    public function getCustomiseCatlogDetails()
	{
		
		$response = array ();
	
		$sql1 = "SELECT id, catlog_name, catlog_image FROM customise_catlog_master WHERE is_active=1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			//$stmt1->bind_param ( "s" ,$mobile_no);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				
				$stmt1->bind_result($id, $catlog_name, $catlog_image);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_image" => $catlog_image
						
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["catlog_list"] = $catlog_list;
				
			}else {	
				$response ["error"] = true;
				$response ["msg"] = "DataNotExist";
				$response ["catlog_list"] = "";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}	

	
	/******************** Get Customise catlog sub category detials by catlog sub name ********************/
    public function getCustomiseSubCatlogDetailsBysubCatlogName($catlog_master_id)
	{
		
		$response = array ();
	
		$sql1 = "SELECT cc.id, c.catlog_name, cc.customise_catlog_sub_category_name, cc.pattern_no, cc.sub_category_img_url FROM customise_catlog_master c, customise_catlog_sub_category cc WHERE cc.customise_catlog_master_id=? and cc.is_active=1 and cc.customise_catlog_master_id = c.id;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$catlog_master_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				
				$stmt1->bind_result($id, $catlog_name, $catlog_sub_category_name, $pattern_no, $sub_category_img_url);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$sub_catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_sub_category_name" => $catlog_sub_category_name,
						"pattern_no" => $pattern_no,
						"sub_category_img_url" => $sub_category_img_url
						
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["sub_catlog_list"] = $sub_catlog_list;
				
			}else {	
				$response ["error"] = true;
				$response ["msg"] = "DataNotExist";
				$response ["sub_catlog_list"] = "";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get stock city list ********************/
    public function getStockCityList($user_id)
	{
		
		$response = array ();
		//$sql1 = "SELECT id, city_name, city_code FROM stock_city where is_active = 1;";
		$sql1 = "SELECT sc.id, sc.city_name, c.city_name, sc.city_code FROM stock_city sc, Users u, City c where sc.is_active = 1 and u.id=? and u.city_id = c.id;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $city_name, $ucity_name, $city_code);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					if($city_name == $ucity_name || $city_name == "Kolkata"){
						$stock_city_list[$i] = array(
							"id" => $id,
							"city_name" => $city_name,
							"city_code" => $city_code
						);
						
					$i++;	
					}	
					
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_city_list"] = $stock_city_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_city_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	/******************** Get stock city list ********************/
    public function getAllStockCityList()
	{
		
		$response = array ();
		//$sql1 = "SELECT id, city_name, city_code FROM stock_city where is_active = 1;";
		$sql1 = "SELECT sc.id, sc.city_name, sc.city_code FROM stock_city sc where sc.is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $city_name, $city_code);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					//if($city_name == $ucity_name || $city_name == "Kolkata"){
						$stock_city_list[$i] = array(
							"id" => $id,
							"city_name" => $city_name,
							"city_code" => $city_code
						);
						
					$i++;	
					//}	
					
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_city_list"] = $stock_city_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_city_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get media list ********************/
    public function getMediaList()
	{
		
		$response = array ();
		$sql1 = "SELECT id, sheet_name, sheet_number FROM media_sheet_type where is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "s" ,$name11);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $sheet_name, $sheet_number);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$media_list[$i] = array(
						"id" => $id,
						"sheet_name" => $sheet_name,
						"sheet_number" => $sheet_number
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["media_list"] = $media_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["media_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get paper list by media id ********************/
    public function getPaperListbymediaId($media_sheet_type_id)
	{
		
		$response = array ();
		$sql1 = "SELECT p.id, p.media_sheet_type_id, m.sheet_name, p.paper_type_name FROM paper_type p, media_sheet_type m where p.is_active = 1 and p.media_sheet_type_id = m.id and p.media_sheet_type_id = ?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$media_sheet_type_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $media_sheet_type_id, $sheet_name, $paper_type_name);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$paper_list[$i] = array(
						"id" => $id,
						"media_sheet_type_id" => $media_sheet_type_id,
						"sheet_name" => $sheet_name,
						"paper_type_name" => $paper_type_name
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["paper_list"] = $paper_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["paper_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get stock catalog detials by pattern no ********************/
    public function getStockDetailsBypattern($pattern_no,$city_id)
	{
		
		$pattern = '%'.$pattern_no.'%';
		$response = array ();
		$sql1 = "SELECT sc.id, scm.catalog_name, sc.pattern_no, sc.pattern FROM stock_catalog_master scm, stock_catalog sc where sc.pattern_no LIKE ? and sc.city_id = ? and sc.stock_catalog_master_id = scm.id and sc.is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "si" ,$pattern,$city_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_name,$pattern_no,$pattern);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$stock_catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"pattern_no" => $pattern_no,
						"pattern" => $pattern
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_catlog_list"] = $stock_catlog_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_catlog_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get stock city by city id ********************/
    public function getStockCityByCityId($city_id)
	{
		
		$response = array ();
		$sql1 = "SELECT id, city_name, update_stock_date FROM stock_city where id = ? and is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$city_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $city_name,$update_stock_date);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$stock_city_list[$i] = array(
						"id" => $id,
						"city_name" => $city_name,
						"update_stock_date" => $update_stock_date
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_city_list"] = $stock_city_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_city_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get message by order id ********************/
    /*public function getJobMessageByOrderId($order_id)
	{
		
		$response = array ();
		$sql1 = "SELECT om.id, u.id, u.first_name, u.last_name, om.message, om.created_date_time FROM order_message om, Users u where om.post_job_id = ? and om.user_id = u.id and om.is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $user_id, $first_name, $last_name, $message, $date_time);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$message_list[$i] = array(
						"id" => $id,
						"user_id" => $user_id,
						"first_name" => $first_name,
						"last_name" => $last_name,
						"message" => $message,
						"date_time" => $date_time
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["message_list"] = $message_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "No Message Found";
    			$response ["message_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}*/
	
	 public function getJobMessageByOrderId($order_id)
	{
		
		$response = array ();
		$sql1 = "SELECT id, message, user_id, created_date_time FROM order_message where post_job_id = ? and is_active = 1 ORDER BY id DESC;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $message, $user_id, $date_time);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$message_list[$i] = array(
						"_id" => $id,
						"text" => $message,
						"createdAt" => $date_time,
						"user" => $this->GetUserByUserId($user_id)
						
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["message_list"] = $message_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "No Message Found";
    			$response ["message_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	public function GetUserByUserId($user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.companyName, u.profilePicture, u.company_logo, u.email_id, u.mobile_number, u.office_address, u.city_id, c.city_name, u.state_id, s.state_name, u.pin_code, u.device_id, ur.user_role_name FROM Users u, City c, State s, User_roles ur WHERE u.city_id = c.id and u.user_role_id = ur.id and u.state_id = s.id and u.id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name, $companyName, $profilePicture, $company_logo, $email_id, $mobile_number, $office_address, $city_id, $city_name, $state_id, $state_name, $pin_code, $devices_id, $user_role_name);
				$result = $stmt1->fetch ();
					
										
					//$response ["error"] = false;
					//$response ["msg"] = "User Details Found.";
					$response ["_id"] = $id;
					$response ["name"] = $first_name.' '.$last_name;
							
					
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "User Details Not Found.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}
	
	/******************** Get stock quantity detials by id ********************/
    public function getStockQuantityDetailsById($id)
	{
		
		$server_path = SERVER_NAME1;
		$response = array ();
		$sql1 = "SELECT sc.id, scm.catalog_name, scm.wallpaper_type, sc.pattern_no, sc.pattern, sc.city_id, m.id, m.sheet_name, sc.paper_type_id, pt.paper_type_name, sc.roll_size, sc.total_sq_ft, sc.color, sc.latest_qty, sc.image_url, sc.mock_image_url,sc.country_of_origin,sc.stock_status FROM stock_catalog_master scm, stock_catalog sc, paper_type pt, media_sheet_type m where sc.id= ? and sc.stock_catalog_master_id = scm.id and sc.paper_type_id = pt.id and m.id = pt.media_sheet_type_id and sc.is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($s_id, $catalog_name, $wallpaper_type,$pattern_no,$pattern,$city_id, $media_id,$sheet_name,$paper_type_id,$paper_type_name,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$mock_image_url,$country_of_origin,$stock_status);
				$result = $stmt1->fetch ();
				
					$response ["error"] = false;
					$response ["msg"] = "Stock Details Found.";
					$response ["id"] = $s_id;
					$response ["catalog_name"] = $catalog_name;
					$response ["wallpaper_type"] = $wallpaper_type;
					$response ["pattern_no"] = $pattern_no;
					$response ["pattern"] = $pattern;
					$response ["city_id"] = $city_id;
					$response ["media_id"] = $media_id;
					$response ["sheet_name"] = $sheet_name;
					$response ["paper_type_id"] = $paper_type_id;
					$response ["paper_type_name"] = $paper_type_name;
					$response ["roll_size"] = $roll_size;
					$response ["total_sq_ft"] = $total_sq_ft;
					$response ["color"] = $color;
					$response ["latest_qty"] = $latest_qty;
					$response ["image_url"] = $server_path.$image_url;
					$response ["mock_image_url"] = $server_path.$mock_image_url;
					$response ["country_of_origin"] = $country_of_origin;
					$response ["stock_status"] = $stock_status;
					$image_urls = array($server_path.$image_url,$server_path.$mock_image_url);
					$response ["image_urls"] = $image_urls;
					
					
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "No Data Found.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/*public function getstockimagebyid($id)
	{
		
		$response = array ();
		$sql1 = "SELECT image_url, mock_image_url FROM stock_catalog where id= ? and is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($image_url, $mock_image_url);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$image_urls[$i] = array(
						"img" => $image_url,
						"img" => $mock_image_url,
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["image_urls"] = $image_urls;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "No Message Found";
    			$response ["image_urls"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}*/
	
	/************************************************/
	
	public function getlatestQtyofstock($stock_id){
	
		$response = array ();
		
		$sql1 = "SELECT MAX(qty) FROM stock_catalog_qty WHERE stock_catlog_id=?";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i", $stock_id );
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($qty);
				$result = $stmt1->fetch ();
				
				$response ["qty"] = $qty;
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "DATA_NOT_EXIST";
				
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = QUERY_EXCEPTION;
		}
		return $response;
	}
	
	/************************************************/
	
	public function getlatestorderno(){
	
		$response = array ();
		
		$sql1 = "SELECT MAX(order_id) FROM post_job_order";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "i", $stock_id );
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($order_id);
				$result = $stmt1->fetch ();
				
				$response ["order_id"] = $order_id;
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "DATA_NOT_EXIST";
				
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = QUERY_EXCEPTION;
		}
		return $response;
	}
	
	/******************** Get paper type list ********************/
    public function getPaperTypeList($sheet_id)
	{
		
		$response = array ();
		$sql1 = "SELECT pt.id, mst.id, mst.sheet_name, pt.paper_type_name FROM paper_type pt, media_sheet_type mst where pt.media_sheet_type_id=? and pt.media_sheet_type_id=mst.id and pt.is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$sheet_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $media_sheet_id, $sheet_name, $paper_type_name);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$paper_list[$i] = array(
						"id" => $id,
						"media_sheet_id" => $media_sheet_id,
						"sheet_name" => $sheet_name,
						"paper_type_name" => $paper_type_name
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["paper_list"] = $paper_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["paper_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	public function insertMessageOrderWise($order_id,$user_id,$message,$created_by_ip) {
		try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_message` (`post_job_id`, `user_id`, `message`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iisiississ" ,$order_id,$user_id,$message,$is_active,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
										
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	/******************** Get all job list ********************/
    public function getAllJobByUserId($user_id)
	{
			
			$response = array ();
			
			$sql1 = "SELECT pjo.id FROM post_job_order pjo WHERE pjo.is_active =1 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?) ORDER BY pjo.id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						$order_detail = $this->getAllJobByOrderUserId($order_id);
						
												
						$order_details[$i] = array(
							
							"id" => $order_detail["id"],
							"order_id" => $order_detail["order_id"],
							"pattern_image_url" => $order_detail["pattern_image_url"],
							"wall_size" => $order_detail["wall_size"],
							"date_time" => $order_detail["date_time"],
							"quantity" => $order_detail["quantity"],
							"description" => $order_detail["description"],
							"audio_url" => $order_detail["audio_url"],
							"user_role_id" => $order_detail["user_role_id"],
							"order_by_user_id" => $order_detail["order_by_user_id"],
							"parent_user_id" => $order_detail["parent_user_id"],
							"first_name" => $order_detail["first_name"],
							"last_name" => $order_detail["last_name"],
							"user_role_name" => $order_detail["user_role_name"],
							"order_status_id" => $order_detail["order_status_id"],
							"parent_user_role_name" => $order_detail["parent_user_role_name"],
							"parent_first_name" =>  $order_detail["parent_first_name"],
							"parent_last_name" =>  $order_detail["parent_last_name"],
							"pattern_no" =>  $order_detail["pattern_no"],
							"media" => $order_detail["media"],
							"button_show" => $order_detail["button_show"],
							"cancel_job" => $order_detail["cancel_job"],
							"support_image" =>  $order_detail["support_image"]
							
							
						);
						
						
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
			
			
		
	}
	
	function getAllJobByOrderUserId($order_id){
		
		$response = array ();
			
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, pjo.order_by_user_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.id = ? ORDER BY pjo.id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$order_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				if ($num_rows1 > 0) {
					
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $audio_url, $user_role_id, $order_by_user_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id,$sheet_name,$paper_type_name,$status_name);
					$result = $stmt1->fetch ();
					
					if($catlog_sub_category_id!=0){
						
						$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
						$pattern = $ccsc["pattern_no"];
						
					}else{
						$pattern = "";
					}
					
					if($parent_user_id != ""){
						
						$parent = $this->getParentUserDetails($parent_user_id);
						
						$parent_first_name = $parent["first_name"];
						$parent_last_name = $parent["last_name"];
						$parent_user_role_name = $parent["user_role_name"];
						
					}
					else{
						
						$parent_user_role_name = "";
						$parent_first_name = "";
						$parent_last_name = "";
					
					}
					
					if($order_status_id == 1 && $user_role_name == "Distributor"){
						$button = "Yes";
					}else{
						$button = "No";
					}
					
					if($order_status_id == 3 || $order_status_id == 6){
						$cancel_job = 1;
					}else{
						$cancel_job = 0;
					}
					
					$distributor_preview_desc = $this->getDistributerAcceptRejectDetails($id);
					$dealer_preview_desc = $this->getDealerAcceptRejectDetails($id);
					
					$support_image = $this->getsupportimagestatus($id);	
					$support_image_button = $support_image["support_button"];
									
					$response ["id"] = $id;
					$response ["order_id"] = $order_id;
					$response ["pattern_image_url"] = $pattern_image_url;
					$response ["wall_size"] = $width.' inch (W) x '.$height.' inch (H)';
					$response ["date_time"] = $date_time;
					$response ["quantity"] = $quantity;
					$response ["description"] = $description;
					$response ["audio_url"] = $audio_url;
					$response ["user_role_id"] = $user_role_id;
					$response ["order_by_user_id"] = $order_by_user_id;
					$response ["parent_user_id"] = $parent_user_id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["user_role_name"] = $user_role_name;
					$response ["order_status_id"] = $order_status_id;
					$response ["status_name"] = $status_name;
					$response ["parent_user_role_name"] = $parent_user_role_name;
					$response ["parent_first_name"] = $parent_first_name;
					$response ["parent_last_name"] = $parent_last_name;
					$response ["pattern_no"] = $pattern;
					$response ["media"] = $sheet_name.'-'.$paper_type_name;
					$response ["button_show"] = $button;
					$response ["cancel_job"] = $cancel_job;
					$response ["distributor_preview_description"] = $distributor_preview_desc["distributer_preview_description"];
					$response ["dealer_preview_description"] = $dealer_preview_desc["dealer_preview_description"];
					$response ["support_image_show"] = $support_image_button;
					$response ["support_image"] = $this->getSupportImageByOrderId($id);
					
					
					
				}else {	
					$response ["id"] = "";
					$response ["order_id"] = "";
					$response ["pattern_image_url"] = "";
					$response ["wall_size"] = "";
					$response ["date_time"] = "";
					$response ["quantity"] = "";
					$response ["description"] = "";
					$response ["audio_url"] = "";
					$response ["user_role_id"] = "";
					$response ["order_by_user_id"] = "";
					$response ["parent_user_id"] = "";
					$response ["first_name"] = "";
					$response ["last_name"] = "";
					$response ["user_role_name"] = "";
					$response ["order_status_id"] = "";
					$response ["status_name"] = "";
					$response ["parent_user_role_name"] = "";
					$response ["parent_first_name"] = "";
					$response ["parent_last_name"] = "";
					$response ["pattern_no"] = "";
					$response ["media"] = "";
					$response ["button_show"] =  "";
					$response ["cancel_job"] =  "";
					$response ["distributor_preview_description"] = "";
					$response ["dealer_preview_description"] = "";
					$response ["support_image_show"] = "";
					$response ["support_image"] = "";
					
				}
				
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	
	/************** get distributer accept reject details ****************/
	
	public function getDistributerAcceptRejectDetails($post_job_order_id){
		$response = array ();
		
		
		$sql1 = "SELECT description, status_id FROM order_status WHERE order_id = ? and status_id in(8,12) ORDER BY id DESC;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($description, $status_id);
				$result = $stmt1->fetch ();
				
				if($status_id == 8 || $status_id == 12){
				
				$response ["distributer_preview_description"] = $description;
				
				}else{
					$response ["distributer_preview_description"] = "";
				}	
			} else { 
				$response ["distributer_preview_description"] = "";
				
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get dealer accept reject details ****************/
	
	public function getDealerAcceptRejectDetails($post_job_order_id){
		$response = array ();
		
		
		$sql1 = "SELECT description, status_id FROM order_status WHERE order_id = ? and status_id in(10,11)ORDER BY id DESC;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($description, $status_id);
				$result = $stmt1->fetch ();
				
				if($status_id == 10 || $status_id == 11){
				
				$response ["dealer_preview_description"] = $description;
				
				}else{
					$response ["dealer_preview_description"] = "";
				}	
			} else { 
				$response ["dealer_preview_description"] = "";
				
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	public function GetUserRoleByUserId($user_id)
{
		$response = array ();
		$current_date_time = date ("Y-m-d H:i:s");
		
		
		$sql1 = "SELECT u.id, u.first_name, u.last_name, ur.user_role_name FROM Users u, User_roles ur WHERE u.user_role_id = ur.id and u.id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name, $last_name,$user_role_name);
				$result = $stmt1->fetch ();
					
				if($user_role_name == "Admin"){
					
					$this->getAllJobByAdmin();
					
				}elseif($user_role_name == "Distributor"){
					$this->getAllJobByDistributer($user_id);
				}		
					
				
			}else{
				$response ["error"] = true;
				$response ["msg"] = "User Details Not Found.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

/************** get status details ****************/
	
	public function getOrderStatusDetails($order_id){
		$response = array ();
		
		$sql1 = "SELECT MAX(created_date_time) FROM order_status WHERE order_id=?;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($created_date_time);
				$result = $stmt1->fetch ();
				
				$response ["created_date_time"] = $created_date_time;
				
				
			} else { 
				$response ["created_date_time"] = "";
				
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
/************** get approve preview image details ****************/
	
	public function getApproveImagePreviewDetails($post_job_order_id){
		$response = array ();
		
		$sql1 = "SELECT upload_image_url, description, approved_by_distributer, approved_by_dealer FROM post_job_approved_image WHERE post_job_order_id=?;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($upload_image_url, $description,$approved_by_distributer,$approved_by_dealer);
				$result = $stmt1->fetch ();
				
				$response ["upload_image_url"] = $upload_image_url;
				$response ["description"] = $description;
				
				if($approved_by_distributer == 0){
					
					$approved_by_distributers = "false";
					
				}else{
					
					$approved_by_distributers = "true";
					
				}

				if($approved_by_dealer == 0){
					
					$approved_by_dealers = "false";
					
				}else{
					
					$approved_by_dealers = "true";
					
				}				
				
				$response ["approved_by_distributer"] = $approved_by_distributers;
				$response ["approved_by_dealer"] = $approved_by_dealer;
				
				
			} else { 
				$response ["upload_image_url"] = "";
				$response ["description"] = "";
				$response ["approved_by_distributer"] = "";
				$response ["approved_by_dealer"] = "";
				
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get approve preview image details ****************/
	
	public function getPreviewRemarksDetailsOrderId($post_job_order_id){
		$response = array ();
		
		$distributor_preview_desc = $this->getDistributerAcceptRejectDetails($post_job_order_id);
		$dealer_preview_desc = $this->getDealerAcceptRejectDetails($post_job_order_id);
		
		$response ["distributor_preview_description"] = $distributor_preview_desc["distributer_preview_description"];
		$response ["dealer_preview_description"] = $dealer_preview_desc["dealer_preview_description"];
		
		return $response;
	}
	
	public function getAllJobByAdmin()
	{
			
			$response = array ();
			
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, pjo.created_date_time, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id ORDER BY pjo.order_id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				//$stmt1->bind_param ( "i" ,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $audio_url, $user_role_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id, $created_date_time,$sheet_name,$paper_type_name,$status_name);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						if($order_status_id == 1 && $user_role_name == "Distributor"){
							$button = "Yes";
						}else{
							$button = "No";
						}	
						
						if($catlog_sub_category_id!=0){
							$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
							$pattern = $ccsc["pattern_no"];
							//$pattern = "";
						}else{
							$pattern = "";
						}
						
						
						if($parent_user_id != ""){
						
							$parent = $this->getParentUserDetails($parent_user_id);
							
							
							$parent_first_name = $parent["first_name"];
							$parent_last_name = $parent["last_name"];
							$parent_user_role_name = $parent["user_role_name"];
							
							
						}
						else{
							
							$parent_user_role_name = "";
							$parent_first_name = "";
							$parent_last_name = "";
						
						}

						$support_image = $this->getsupportimagestatus($id);	
						$order_status_date = $this->getOrderStatusDetails($id);	
						$order_approve_image = $this->getApproveImagePreviewDetails($id);	
						
						
						$distributor_preview_desc = $this->getDistributerAcceptRejectDetails($id);
						$dealer_preview_desc = $this->getDealerAcceptRejectDetails($id);
						
						
						$order_details[$i] = array(
							"id" => $id,
							"order_id" => $order_id,
							"pattern_image_url" => $pattern_image_url,
							"wall_size" => $width.' inch (W) x '.$height.' inch (H)',
							"date_time" => $date_time,
							"quantity" => $quantity,
							"description" => $description,
							"audio_url" => $audio_url,
							"user_role_id" => $user_role_id,
							"parent_user_id" => $parent_user_id,
							"first_name" => $first_name,
							"last_name" => $last_name,
							"user_role_name" => $user_role_name,
							"order_status_id" => $order_status_id,
							"status_name" => $status_name,
							"status_date_time" => $order_status_date["created_date_time"],
							"created_date_time" => $created_date_time,
							"approve_distributer" => $order_approve_image["approved_by_distributer"],
							"approve_preview_image" => $order_approve_image["upload_image_url"],
							"parent_user_role_name" => $parent_user_role_name,
							"parent_first_name" =>  $parent_first_name,
							"parent_last_name" =>  $parent_last_name,
							"pattern_no" =>  $pattern,
							"media" => $sheet_name.'-'.$paper_type_name,
							"button_show" =>  $button,
							"distributor_preview_description" => $distributor_preview_desc["distributer_preview_description"],
							"dealer_preview_description" => $dealer_preview_desc["dealer_preview_description"],
							"support_image_show" =>  $support_image["support_button"]
							//"support_image" =>  $this->getSupportImageByOrderId($id)
						);
							
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	public function getAllJobByDistributer($user_id)
	{
			
			$response = array ();
			
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id ORDER BY pjo.order_id DESC;";
			
			$sql1 = "SELECT pjo.id FROM post_job_order pjo WHERE pjo.is_active =1 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?);";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						$order_detail = $this->getorderdetailsByOrderid($order_id);
						
												
						$order_details[$i] = array(
							
							"id" => $order_id,
							"order_id" => $order_detail["orders_id"],
							"pattern_image_url" => $order_detail["pattern_image_url"],
							"wall_size" => $order_detail["wall_size"],
							"date_time" => $order_detail["date_time"],
							"quantity" => $order_detail["quantity"],
							"description" => $order_detail["description"],
							"audio_url" => $order_detail["audio_url"],
							"user_role_id" => $order_detail["user_role_id"],
							"parent_user_id" => $order_detail["parent_user_id"],
							"first_name" => $order_detail["first_name"],
							"last_name" => $order_detail["last_name"],
							"user_role_name" => $order_detail["user_role_name"],
							"order_status_id" => $order_detail["order_status_id"],
							"status_name" => $order_detail["status_name"],
							"parent_user_role_name" => $order_detail["parent_user_role_name"],
							"parent_first_name" =>  $order_detail["parent_first_name"],
							"parent_last_name" =>  $order_detail["parent_last_name"],
							"pattern_no" =>  $order_detail["pattern_no"],
							"media" => $order_detail["media"],
							"support_image_show" =>  $order_detail["support_image_show"]
							//"support_image" =>  $this->getSupportImageByOrderId($id)
						);
						
						
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	public function getorderdetailsByOrderid($order_id)
	{
			
			$response = array ();
			
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.id = ?;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$order_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				if ($num_rows1 > 0) {
					
					$stmt1->bind_result($id, $orders_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $audio_url, $user_role_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id,$sheet_name,$paper_type_name,$status_name);
					$result = $stmt1->fetch ();
					
					if($catlog_sub_category_id!=0){
						
						$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
						$pattern = $ccsc["pattern_no"];
						
					}else{
						$pattern = "";
					}
					
					if($parent_user_id != ""){
						
						$parent = $this->getParentUserDetails($parent_user_id);
						
						$parent_first_name = $parent["first_name"];
						$parent_last_name = $parent["last_name"];
						$parent_user_role_name = $parent["user_role_name"];
						
					}
					else{
						
						$parent_user_role_name = "";
						$parent_first_name = "";
						$parent_last_name = "";
					
					}
					
					$support_image = $this->getsupportimagestatus($id);	
					$support_image_button = $support_image["support_button"];
									
					$response ["id"] = $id;
					$response ["orders_id"] = $orders_id;
					$response ["pattern_image_url"] = $pattern_image_url;
					$response ["wall_size"] = $width.' inch (W) x '.$height.' inch (H)';
					$response ["date_time"] = $date_time;
					$response ["quantity"] = $quantity;
					$response ["description"] = $description;
					$response ["audio_url"] = $audio_url;
					$response ["user_role_id"] = $user_role_id;
					$response ["parent_user_id"] = $parent_user_id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["user_role_name"] = $user_role_name;
					$response ["order_status_id"] = $order_status_id;
					$response ["status_name"] = $status_name;
					$response ["parent_user_role_name"] = $parent_user_role_name;
					$response ["parent_first_name"] = $parent_first_name;
					$response ["parent_last_name"] = $parent_last_name;
					$response ["pattern_no"] = $pattern;
					$response ["media"] = $sheet_name.'-'.$paper_type_name;
					$response ["support_image_show"] = $support_image_button;
					
					
					
				}else {	
					$response ["id"] = "";
					$response ["orders_id"] = "";
					$response ["pattern_image_url"] = "";
					$response ["wall_size"] = "";
					$response ["date_time"] = "";
					$response ["quantity"] = "";
					$response ["description"] = "";
					$response ["audio_url"] = "";
					$response ["user_role_id"] = "";
					$response ["parent_user_id"] = "";
					$response ["first_name"] = "";
					$response ["last_name"] = "";
					$response ["user_role_name"] = "";
					$response ["order_status_id"] = "";
					$response ["status_name"] = "";
					$response ["parent_user_role_name"] = "";
					$response ["parent_first_name"] = "";
					$response ["parent_last_name"] = "";
					$response ["pattern_no"] = "";
					$response ["media"] = "";
					$response ["support_image_show"] = "";
					
				}
				
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	
	/******************** Get in progress job list ********************/
    public function getInProgressJobByUserId($user_id)
	{
		
		$response = array ();
			
			$sql1 = "SELECT pjo.id FROM post_job_order pjo WHERE pjo.is_active =1 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?) ORDER BY pjo.id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						$order_detail = $this->getInProgressJobByOrderId($order_id);
						
												
						$order_details[$i] = array(
							
							"id" => $order_detail["id"],
							"order_id" => $order_detail["order_id"],
							"pattern_image_url" => $order_detail["pattern_image_url"],
							"wall_size" => $order_detail["wall_size"],
							"date_time" => $order_detail["date_time"],
							"quantity" => $order_detail["quantity"],
							"description" => $order_detail["description"],
							"audio_url" => $order_detail["audio_url"],
							"user_role_id" => $order_detail["user_role_id"],
							"parent_user_id" => $order_detail["parent_user_id"],
							"order_by_user_id" => $order_detail["order_by_user_id"],
							"first_name" => $order_detail["first_name"],
							"last_name" => $order_detail["last_name"],
							"user_role_name" => $order_detail["user_role_name"],
							"order_status_id" => $order_detail["order_status_id"],
							"parent_user_role_name" => $order_detail["parent_user_role_name"],
							"parent_first_name" =>  $order_detail["parent_first_name"],
							"parent_last_name" =>  $order_detail["parent_last_name"],
							"pattern_no" =>  $order_detail["pattern_no"],
							"media" => $order_detail["media"],
							"cancel_job" => $order_detail["cancel_job"],
							"button_show" => $order_detail["button_show"],
							"support_image" =>  $order_detail["support_image"]
							
							
						);
						
						
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
			
	}
	
	function getInProgressJobByOrderId($order_id){
		
		$response = array ();
			
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.id = ?;";
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, u.parent_user_id, pjo.order_by_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.id = ? and not pjo.order_status_id= 3 and not pjo.order_status_id= 6 and not pjo.order_status_id= 7 ORDER BY pjo.id DESC;"; 
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$order_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				if ($num_rows1 > 0) {
					
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $audio_url, $user_role_id,$parent_user_id, $order_by_user_id,$first_name,$last_name,$user_role_name,$order_status_id,$sheet_name,$paper_type_name,$status_name);
					$result = $stmt1->fetch ();
					
					if($catlog_sub_category_id!=0){
						
						$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
						$pattern = $ccsc["pattern_no"];
						
					}else{
						$pattern = "";
					}
					
					if($parent_user_id != ""){
						
						$parent = $this->getParentUserDetails($parent_user_id);
						
						$parent_first_name = $parent["first_name"];
						$parent_last_name = $parent["last_name"];
						$parent_user_role_name = $parent["user_role_name"];
						
					}
					else{
						
						$parent_user_role_name = "";
						$parent_first_name = "";
						$parent_last_name = "";
					
					}
					
					if($order_status_id == 1 && $user_role_name == "Distributor"){
						$button = "Yes";
					}else{
						$button = "No";
					}
					
					if($order_status_id == 3 || $order_status_id == 6){
						$cancel_job = 1;
					}else{
						$cancel_job = 0;
					}
					
					$support_image = $this->getsupportimagestatus($id);	
					$support_image_button = $support_image["support_button"];
									
					$response ["id"] = $id;
					$response ["order_id"] = $order_id;
					$response ["pattern_image_url"] = $pattern_image_url;
					$response ["wall_size"] = $width.' inch (W) x '.$height.' inch (H)';
					$response ["date_time"] = $date_time;
					$response ["quantity"] = $quantity;
					$response ["description"] = $description;
					$response ["audio_url"] = $audio_url;
					$response ["user_role_id"] = $user_role_id;
					$response ["parent_user_id"] = $parent_user_id;
					$response ["order_by_user_id"] = $order_by_user_id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["user_role_name"] = $user_role_name;
					$response ["order_status_id"] = $order_status_id;
					$response ["status_name"] = $status_name;
					$response ["parent_user_role_name"] = $parent_user_role_name;
					$response ["parent_first_name"] = $parent_first_name;
					$response ["parent_last_name"] = $parent_last_name;
					$response ["pattern_no"] = $pattern;
					$response ["media"] = $sheet_name.'-'.$paper_type_name;
					$response ["button_show"] = $button;
					$response ["cancel_job"] = $cancel_job;
					$response ["support_image_show"] = $support_image_button;
					$response ["support_image"] = $this->getSupportImageByOrderId($id);
					
					
					
				}else {	
					$response ["id"] = "";
					$response ["order_id"] = "";
					$response ["pattern_image_url"] = "";
					$response ["wall_size"] = "";
					$response ["date_time"] = "";
					$response ["quantity"] = "";
					$response ["description"] = "";
					$response ["audio_url"] = "";
					$response ["user_role_id"] = "";
					$response ["parent_user_id"] = "";
					$response ["order_by_user_id"] = "";
					$response ["first_name"] = "";
					$response ["last_name"] = "";
					$response ["user_role_name"] = "";
					$response ["order_status_id"] = "";
					$response ["status_name"] = "";
					$response ["parent_user_role_name"] = "";
					$response ["parent_first_name"] = "";
					$response ["parent_last_name"] = "";
					$response ["pattern_no"] = "";
					$response ["media"] = "";
					$response ["button_show"] =  "";
					$response ["cancel_job"] =  "";
					$response ["support_image_show"] = "";
					$response ["support_image"] = "";
					
				}
				
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
		
		
	}
	
	
	/********************** In progress job list admin ***********************/
	
	public function getInptogressJobByAdmin()
	{
			
			$response = array ();
			
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id ORDER BY pjo.order_id DESC;";
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, pjo.created_date_time, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and not pjo.order_status_id= 3 and not pjo.order_status_id= 6 and not pjo.order_status_id= 7 ORDER BY pjo.order_id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				//$stmt1->bind_param ( "i" ,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $audio_url, $user_role_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id, $created_date_time,$sheet_name,$paper_type_name,$status_name);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						if($order_status_id == 1 && $user_role_name == "Distributor"){
							$button = "Yes";
						}else{
							$button = "No";
						}	
						
						if($catlog_sub_category_id!=0){
							$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
							$pattern = $ccsc["pattern_no"];
							//$pattern = "";
						}else{
							$pattern = "";
						}
						
						
						if($parent_user_id != ""){
						
							$parent = $this->getParentUserDetails($parent_user_id);
							
							
							$parent_first_name = $parent["first_name"];
							$parent_last_name = $parent["last_name"];
							$parent_user_role_name = $parent["user_role_name"];
							
							
						}
						else{
							
							$parent_user_role_name = "";
							$parent_first_name = "";
							$parent_last_name = "";
						
						}

						$support_image = $this->getsupportimagestatus($id);	
						$order_status_date = $this->getOrderStatusDetails($id);	
						$order_approve_image = $this->getApproveImagePreviewDetails($id);	
						
						$order_details[$i] = array(
							"id" => $id,
							"order_id" => $order_id,
							"pattern_image_url" => $pattern_image_url,
							"wall_size" => $width.' inch (W) x '.$height.' inch (H)',
							"date_time" => $date_time,
							"quantity" => $quantity,
							"description" => $description,
							"audio_url" => $audio_url,
							"user_role_id" => $user_role_id,
							"parent_user_id" => $parent_user_id,
							"first_name" => $first_name,
							"last_name" => $last_name,
							"user_role_name" => $user_role_name,
							"order_status_id" => $order_status_id,
							"status_date_time" => $order_status_date["created_date_time"],
							"created_date_time" => $created_date_time,
							"approve_distributer" => $order_approve_image["approved_by_distributer"],
							"approve_preview_image" => $order_approve_image["upload_image_url"],
							"status_name" => $status_name,
							"parent_user_role_name" => $parent_user_role_name,
							"parent_first_name" =>  $parent_first_name,
							"parent_last_name" =>  $parent_last_name,
							"pattern_no" =>  $pattern,
							"media" => $sheet_name.'-'.$paper_type_name,
							"button_show" =>  $button,
							"support_image_show" =>  $support_image["support_button"]
							//"support_image" =>  $this->getSupportImageByOrderId($id)
						);
							
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	public function getInprogressJobByDistributer($user_id)
	{
			
			$response = array ();
			
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id ORDER BY pjo.order_id DESC;";
			
			$sql1 = "SELECT pjo.id FROM post_job_order pjo WHERE pjo.is_active =1 and not pjo.order_status_id= 3 and not pjo.order_status_id= 6 and not pjo.order_status_id= 7 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?);";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						$order_detail = $this->getorderdetailsByOrderid($order_id);
						
												
						$order_details[$i] = array(
							
							"id" => $order_id,
							"order_id" => $order_detail["orders_id"],
							"pattern_image_url" => $order_detail["pattern_image_url"],
							"wall_size" => $order_detail["wall_size"],
							"date_time" => $order_detail["date_time"],
							"quantity" => $order_detail["quantity"],
							"description" => $order_detail["description"],
							"audio_url" => $order_detail["audio_url"],
							"user_role_id" => $order_detail["user_role_id"],
							"parent_user_id" => $order_detail["parent_user_id"],
							"first_name" => $order_detail["first_name"],
							"last_name" => $order_detail["last_name"],
							"user_role_name" => $order_detail["user_role_name"],
							"order_status_id" => $order_detail["order_status_id"],
							"status_name" => $order_detail["status_name"],
							"parent_user_role_name" => $order_detail["parent_user_role_name"],
							"parent_first_name" =>  $order_detail["parent_first_name"],
							"parent_last_name" =>  $order_detail["parent_last_name"],
							"pattern_no" =>  $order_detail["pattern_no"],
							"media" => $order_detail["media"],
							"support_image_show" =>  $order_detail["support_image_show"]
							//"support_image" =>  $this->getSupportImageByOrderId($id)
						);
						
						
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	/******************** Get cancelled job list ********************/
    public function getCancelledJobByUserId($user_id)
	{
		
		$response = array ();
			
			$sql1 = "SELECT pjo.id FROM post_job_order pjo WHERE pjo.is_active =1 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?) ORDER BY pjo.id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						$order_detail = $this->getCancelledJobOrderByUserId($order_id);
						
												
						$order_details[$i] = array(
							
							"id" => $order_detail["id"],
							"order_id" => $order_detail["order_id"],
							"pattern_image_url" => $order_detail["pattern_image_url"],
							"wall_size" => $order_detail["wall_size"],
							"date_time" => $order_detail["date_time"],
							"quantity" => $order_detail["quantity"],
							"description" => $order_detail["description"],
							"audio_url" => $order_detail["audio_url"],
							"user_role_id" => $order_detail["user_role_id"],
							"parent_user_id" => $order_detail["parent_user_id"],
							"first_name" => $order_detail["first_name"],
							"last_name" => $order_detail["last_name"],
							"user_role_name" => $order_detail["user_role_name"],
							"order_status_id" => $order_detail["order_status_id"],
							"parent_user_role_name" => $order_detail["parent_user_role_name"],
							"parent_first_name" =>  $order_detail["parent_first_name"],
							"parent_last_name" =>  $order_detail["parent_last_name"],
							"pattern_no" =>  $order_detail["pattern_no"],
							"media" => $order_detail["media"],
							"cancel_job" => $order_detail["cancel_job"],
							"button_show" => $order_detail["button_show"],
							"support_image" =>  $order_detail["support_image"]
							
							
						);
						
						
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	public function getCancelledJobOrderByUserId($order_id){
		
		$response = array ();
			
						
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.paper_type_id = p.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.id = ? and pjo.order_status_id in( 3,6) ORDER BY pjo.id DESC;"; 
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$order_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				if ($num_rows1 > 0) {
					
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $audio_url, $user_role_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id,$sheet_name,$paper_type_name,$status_name);
					$result = $stmt1->fetch ();
					
					if($catlog_sub_category_id!=0){
						
						$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
						$pattern = $ccsc["pattern_no"];
						
					}else{
						$pattern = "";
					}
					
					if($parent_user_id != ""){
						
						$parent = $this->getParentUserDetails($parent_user_id);
						
						$parent_first_name = $parent["first_name"];
						$parent_last_name = $parent["last_name"];
						$parent_user_role_name = $parent["user_role_name"];
						
					}
					else{
						
						$parent_user_role_name = "";
						$parent_first_name = "";
						$parent_last_name = "";
					
					}
					
					if($order_status_id == 1 && $user_role_name == "Distributor"){
						$button = "Yes";
					}else{
						$button = "No";
					}
					
					if($order_status_id == 3 || $order_status_id == 6){
						$cancel_job=1;
					}else{
						$cancel_job = 0;
					}
					
					$support_image = $this->getsupportimagestatus($id);	
					$support_image_button = $support_image["support_button"];
									
					$response ["id"] = $id;
					$response ["order_id"] = $order_id;
					$response ["pattern_image_url"] = $pattern_image_url;
					$response ["wall_size"] = $width.' inch (W) x '.$height.' inch (H)';
					$response ["date_time"] = $date_time;
					$response ["quantity"] = $quantity;
					$response ["description"] = $description;
					$response ["audio_url"] = $audio_url;
					$response ["user_role_id"] = $user_role_id;
					$response ["parent_user_id"] = $parent_user_id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["user_role_name"] = $user_role_name;
					$response ["order_status_id"] = $order_status_id;
					$response ["status_name"] = $status_name;
					$response ["parent_user_role_name"] = $parent_user_role_name;
					$response ["parent_first_name"] = $parent_first_name;
					$response ["parent_last_name"] = $parent_last_name;
					$response ["pattern_no"] = $pattern;
					$response ["media"] = $sheet_name.'-'.$paper_type_name;
					$response ["cancel_job"] = $cancel_job;
					$response ["button_show"] = $button;
					$response ["support_image_show"] = $support_image_button;
					$response ["support_image"] = $this->getSupportImageByOrderId($id);
					
					
					
				}else {	
					$response ["id"] = "";
					$response ["order_id"] = "";
					$response ["pattern_image_url"] = "";
					$response ["wall_size"] = "";
					$response ["date_time"] = "";
					$response ["quantity"] = "";
					$response ["description"] = "";
					$response ["audio_url"] = "";
					$response ["user_role_id"] = "";
					$response ["parent_user_id"] = "";
					$response ["first_name"] = "";
					$response ["last_name"] = "";
					$response ["user_role_name"] = "";
					$response ["order_status_id"] = "";
					$response ["status_name"] = "";
					$response ["parent_user_role_name"] = "";
					$response ["parent_first_name"] = "";
					$response ["parent_last_name"] = "";
					$response ["pattern_no"] = "";
					$response ["media"] = "";
					$response ["cancel_job"] =  "";
					$response ["button_show"] =  "";
					$response ["support_image_show"] = "";
					$response ["support_image"] = "";
					
				}
				
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
		
	}
	
	
	/********************** Cancelled job list admin ***********************/
	
	public function getCancelledJobByAdmin()
	{
			
			$response = array ();
						
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and not pjo.order_status_id= 3 and not pjo.order_status_id= 6 and not pjo.order_status_id= 7;";
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.order_status_id in( 3,6) ORDER BY pjo.order_id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				//$stmt1->bind_param ( "i" ,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $user_role_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id,$sheet_name,$paper_type_name,$status_name);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						if($order_status_id == 1 && $user_role_name == "Distributor"){
							$button = "Yes";
						}else{
							$button = "No";
						}	
						
						if($catlog_sub_category_id!=0){
							$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
							$pattern = $ccsc["pattern_no"];
							//$pattern = "";
						}else{
							$pattern = "";
						}
						
						
						if($parent_user_id != ""){
						
							$parent = $this->getParentUserDetails($parent_user_id);
							
							
							$parent_first_name = $parent["first_name"];
							$parent_last_name = $parent["last_name"];
							$parent_user_role_name = $parent["user_role_name"];
							
							
						}
						else{
							
							$parent_user_role_name = "";
							$parent_first_name = "";
							$parent_last_name = "";
						
						}

						$support_image = $this->getsupportimagestatus($id);	
						
						$order_details[$i] = array(
							"id" => $id,
							"order_id" => $order_id,
							"pattern_image_url" => $pattern_image_url,
							"wall_size" => $width.' inch (W) x '.$height.' inch (H)',
							"date_time" => $date_time,
							"quantity" => $quantity,
							"description" => $description,
							"user_role_id" => $user_role_id,
							"parent_user_id" => $parent_user_id,
							"first_name" => $first_name,
							"last_name" => $last_name,
							"user_role_name" => $user_role_name,
							"order_status_id" => $order_status_id,
							"status_name" => $status_name,
							"parent_user_role_name" => $parent_user_role_name,
							"parent_first_name" =>  $parent_first_name,
							"parent_last_name" =>  $parent_last_name,
							"pattern_no" =>  $pattern,
							"media" => $sheet_name.'-'.$paper_type_name,
							"button_show" =>  $button,
							"support_image_show" =>  $support_image["support_button"]
							//"support_image" =>  $this->getSupportImageByOrderId($id)
						);
							
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	public function getCancelledJobByDistributer($user_id)
	{
			
			$response = array ();
			
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id ORDER BY pjo.order_id DESC;";
			
			$sql1 = "SELECT pjo.id, pjo.order_status_id FROM post_job_order pjo WHERE pjo.is_active =1 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?)";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id, $order_status_id);
					
					
					
						$i=0;
						while($result = $stmt1->fetch ()){
							
							if( $order_status_id ==3 || $order_status_id ==6){
							
							$order_detail = $this->getorderdetailsByOrderid($order_id);
							
													
							$order_details[$i] = array(
								
								"id" => $order_id,
								"order_id" => $order_detail["orders_id"],
								"pattern_image_url" => $order_detail["pattern_image_url"],
								"wall_size" => $order_detail["wall_size"],
								"date_time" => $order_detail["date_time"],
								"quantity" => $order_detail["quantity"],
								"description" => $order_detail["description"],
								"audio_url" => $order_detail["audio_url"],
								"user_role_id" => $order_detail["user_role_id"],
								"parent_user_id" => $order_detail["parent_user_id"],
								"first_name" => $order_detail["first_name"],
								"last_name" => $order_detail["last_name"],
								"user_role_name" => $order_detail["user_role_name"],
								"order_status_id" => $order_detail["order_status_id"],
								"status_name" => $order_detail["status_name"],
								"parent_user_role_name" => $order_detail["parent_user_role_name"],
								"parent_first_name" =>  $order_detail["parent_first_name"],
								"parent_last_name" =>  $order_detail["parent_last_name"],
								"pattern_no" =>  $order_detail["pattern_no"],
								"media" => $order_detail["media"],
								"support_image_show" =>  $order_detail["support_image_show"]
								//"support_image" =>  $this->getSupportImageByOrderId($id)
							);
							
							
							}else{
								
								$order_details[$i] = array(
								
									"order_id" => "",
									"pattern_image_url" => "",
									"wall_size" => "",
									"date_time" => "",
									"quantity" => "",
									"description" => "",
									"user_role_id" => "",
									"parent_user_id" => "",
									"first_name" => "",
									"last_name" => "",
									"user_role_name" => "",
									"order_status_id" => "",
									"status_name" => "",
									"parent_user_role_name" => "",
									"parent_first_name" =>  "",
									"parent_last_name" =>  "",
									"pattern_no" =>  "",
									"media" => "",
									"support_image_show" =>  ""
									
								);
										
								
							}
							$i++;
						}
										
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	
	/********************** Completed job list admin ***********************/
	
	public function getCompletedJobByAdmin()
	{
			
			$response = array ();
						
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and not pjo.order_status_id= 3 and not pjo.order_status_id= 6 and not pjo.order_status_id= 7;";
			$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.order_status_id = 7 ORDER BY pjo.order_id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				//$stmt1->bind_param ( "i" ,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $user_role_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id,$sheet_name,$paper_type_name,$status_name);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						if($order_status_id == 1 && $user_role_name == "Distributor"){
							$button = "Yes";
						}else{
							$button = "No";
						}	
						
						if($catlog_sub_category_id!=0){
							$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
							$pattern = $ccsc["pattern_no"];
							//$pattern = "";
						}else{
							$pattern = "";
						}
						
						
						if($parent_user_id != ""){
						
							$parent = $this->getParentUserDetails($parent_user_id);
							
							
							$parent_first_name = $parent["first_name"];
							$parent_last_name = $parent["last_name"];
							$parent_user_role_name = $parent["user_role_name"];
							
							
						}
						else{
							
							$parent_user_role_name = "";
							$parent_first_name = "";
							$parent_last_name = "";
						
						}

						$support_image = $this->getsupportimagestatus($id);	
						
						$order_details[$i] = array(
							"id" => $id,
							"order_id" => $order_id,
							"pattern_image_url" => $pattern_image_url,
							"wall_size" => $width.' inch (W) x '.$height.' inch (H)',
							"date_time" => $date_time,
							"quantity" => $quantity,
							"description" => $description,
							"user_role_id" => $user_role_id,
							"parent_user_id" => $parent_user_id,
							"first_name" => $first_name,
							"last_name" => $last_name,
							"user_role_name" => $user_role_name,
							"order_status_id" => $order_status_id,
							"status_name" => $status_name,
							"parent_user_role_name" => $parent_user_role_name,
							"parent_first_name" =>  $parent_first_name,
							"parent_last_name" =>  $parent_last_name,
							"pattern_no" =>  $pattern,
							"media" => $sheet_name.'-'.$paper_type_name,
							"button_show" =>  $button,
							"support_image_show" =>  $support_image["support_button"]
							//"support_image" =>  $this->getSupportImageByOrderId($id)
						);
							
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	public function getCompletedJobByDistributer($user_id)
	{
			
			$response = array ();
			
			//$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id ORDER BY pjo.order_id DESC;";
			
			$sql1 = "SELECT pjo.id, pjo.order_status_id FROM post_job_order pjo WHERE pjo.is_active =1 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?)";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id, $order_status_id);
					
					
					
						$i=0;
						while($result = $stmt1->fetch ()){
							
							if( $order_status_id == 7 ){
							
							$order_detail = $this->getorderdetailsByOrderid($order_id);
							
													
							$order_details[$i] = array(
								
								"id" => $order_id,
								"order_id" => $order_detail["orders_id"],
								"pattern_image_url" => $order_detail["pattern_image_url"],
								"wall_size" => $order_detail["wall_size"],
								"date_time" => $order_detail["date_time"],
								"quantity" => $order_detail["quantity"],
								"description" => $order_detail["description"],
								"audio_url" => $order_detail["audio_url"],
								"user_role_id" => $order_detail["user_role_id"],
								"parent_user_id" => $order_detail["parent_user_id"],
								"first_name" => $order_detail["first_name"],
								"last_name" => $order_detail["last_name"],
								"user_role_name" => $order_detail["user_role_name"],
								"order_status_id" => $order_detail["order_status_id"],
								"status_name" => $order_detail["status_name"],
								"parent_user_role_name" => $order_detail["parent_user_role_name"],
								"parent_first_name" =>  $order_detail["parent_first_name"],
								"parent_last_name" =>  $order_detail["parent_last_name"],
								"pattern_no" =>  $order_detail["pattern_no"],
								"media" => $order_detail["media"],
								"support_image_show" =>  $order_detail["support_image_show"]
								//"support_image" =>  $this->getSupportImageByOrderId($id)
							);
							
							
							}else{
								
								$order_details[$i] = array(
								
									"order_id" => "",
									"pattern_image_url" => "",
									"wall_size" => "",
									"date_time" => "",
									"quantity" => "",
									"description" => "",
									"user_role_id" => "",
									"parent_user_id" => "",
									"first_name" => "",
									"last_name" => "",
									"user_role_name" => "",
									"order_status_id" => "",
									"status_name" => "",
									"parent_user_role_name" => "",
									"parent_first_name" =>  "",
									"parent_last_name" =>  "",
									"pattern_no" =>  "",
									"media" => "",
									"support_image_show" =>  ""
									
								);
										
								
							}	
							$i++;
						}
									
						$response ["error"] = false;
						$response ["msg"] ="DATA_FOUND";
						$response ["order_details"] = $order_details;
						
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	
	public function getCustomiseSubCatlogDetailsById($catlog_sub_category_id)
	{
		
		$response = array ();
	
		$sql1 = "SELECT id, customise_catlog_sub_category_name, pattern_no, sub_category_img_url FROM  customise_catlog_sub_category WHERE id=? and is_active=1 ;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$catlog_sub_category_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				
				$stmt1->bind_result($id, $customise_catlog_sub_category_name, $pattern_no, $sub_category_img_url);
				$result = $stmt1->fetch ();
								
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["id"] = $id;
				$response ["customise_catlog_sub_category_name"] = $customise_catlog_sub_category_name;
				$response ["pattern_no"] = $pattern_no;
				$response ["sub_category_img_url"] = $sub_category_img_url;
				
				
			}else {	
				$response ["error"] = true;
				$response ["msg"] = "DataNotExist";
				
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	/******************** Get cancelled job list ********************/
    public function getCompletedJobByUserId($user_id)
	{
		
		$response = array ();
			
			$sql1 = "SELECT pjo.id FROM post_job_order pjo WHERE pjo.is_active =1 and pjo.order_by_user_id = ? or pjo.order_by_user_id IN (select us.id From Users us Where us.parent_user_id = ? or us.id = ?) ORDER BY pjo.id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "iii" ,$user_id,$user_id,$user_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($order_id);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						
						$order_detail = $this->getCompletedJobOrderByUserId($order_id);
						
												
						$order_details[$i] = array(
							
							"id" => $order_detail["id"],
							"order_id" => $order_detail["order_id"],
							"pattern_image_url" => $order_detail["pattern_image_url"],
							"wall_size" => $order_detail["wall_size"],
							"date_time" => $order_detail["date_time"],
							"quantity" => $order_detail["quantity"],
							"description" => $order_detail["description"],
							"audio_url" => $order_detail["audio_url"],
							"user_role_id" => $order_detail["user_role_id"],
							"parent_user_id" => $order_detail["parent_user_id"],
							"first_name" => $order_detail["first_name"],
							"last_name" => $order_detail["last_name"],
							"user_role_name" => $order_detail["user_role_name"],
							"order_status_id" => $order_detail["order_status_id"],
							"parent_user_role_name" => $order_detail["parent_user_role_name"],
							"parent_first_name" =>  $order_detail["parent_first_name"],
							"parent_last_name" =>  $order_detail["parent_last_name"],
							"pattern_no" =>  $order_detail["pattern_no"],
							"media" => $order_detail["media"],
							"cancel_job" => $order_detail["cancel_job"],
							"button_show" => $order_detail["button_show"],
							"support_image" =>  $order_detail["support_image"]
							
							
						);
						
						
						
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["order_details"] = $order_details;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["order_details"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;	
		
	}
	
	public function getCompletedJobOrderByUserId($order_id){
	
		$sql1 = "SELECT pjo.id, pjo.order_id, pjo.pattern_image_url, pjo.width, pjo.height, pjo.created_date_time, pjo.catlog_sub_category_id, pjo.quantity, pjo.description, pjo.audio_url, u.user_role_id, u.parent_user_id, u.first_name, u.last_name, ur.user_role_name, pjo.order_status_id, m.sheet_name, p.paper_type_name, s.status_name FROM Users u, User_roles ur, post_job_order pjo, media_sheet_type m, paper_type p, status s WHERE pjo.is_active =1 and u.user_role_id = ur.id and pjo.order_by_user_id = u.id and pjo.media_sheet_type_id = m.id and pjo.order_status_id = s.id and pjo.paper_type_id = p.id and pjo.order_status_id = 7 and pjo.id =? ORDER BY pjo.id DESC;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$order_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				if ($num_rows1 > 0) {
					
					$stmt1->bind_result($id, $order_id, $pattern_image_url, $width, $height, $date_time, $catlog_sub_category_id, $quantity, $description, $audio_url, $user_role_id,$parent_user_id,$first_name,$last_name,$user_role_name,$order_status_id,$sheet_name,$paper_type_name,$status_name);
					$result = $stmt1->fetch ();
					
					if($catlog_sub_category_id!=0){
						
						$ccsc = $this->getPatternDetailsById($catlog_sub_category_id);
						$pattern = $ccsc["pattern_no"];
						
					}else{
						$pattern = "";
					}
					
					if($parent_user_id != ""){
						
						$parent = $this->getParentUserDetails($parent_user_id);
						
						$parent_first_name = $parent["first_name"];
						$parent_last_name = $parent["last_name"];
						$parent_user_role_name = $parent["user_role_name"];
						
					}
					else{
						
						$parent_user_role_name = "";
						$parent_first_name = "";
						$parent_last_name = "";
					
					}
					
					if($order_status_id == 1 && $user_role_name == "Distributor"){
						$button = "Yes";
					}else{
						$button = "No";
					}
					
					if($order_status_id == 3 || $order_status_id == 6){
						$cancel_job =1;
					}else{
						$cancel_job =0;
					}
					
					$support_image = $this->getsupportimagestatus($id);	
					$support_image_button = $support_image["support_button"];
									
					$response ["id"] = $id;
					$response ["order_id"] = $order_id;
					$response ["pattern_image_url"] = $pattern_image_url;
					$response ["wall_size"] = $width.' inch (W) x '.$height.' inch (H)';
					$response ["date_time"] = $date_time;
					$response ["quantity"] = $quantity;
					$response ["description"] = $description;
					$response ["audio_url"] = $audio_url;
					$response ["user_role_id"] = $user_role_id;
					$response ["parent_user_id"] = $parent_user_id;
					$response ["first_name"] = $first_name;
					$response ["last_name"] = $last_name;
					$response ["user_role_name"] = $user_role_name;
					$response ["order_status_id"] = $order_status_id;
					$response ["status_name"] = $status_name;
					$response ["parent_user_role_name"] = $parent_user_role_name;
					$response ["parent_first_name"] = $parent_first_name;
					$response ["parent_last_name"] = $parent_last_name;
					$response ["pattern_no"] = $pattern;
					$response ["media"] = $sheet_name.'-'.$paper_type_name;
					$response ["cancel_job"] = $cancel_job;
					$response ["button_show"] = $button;
					$response ["support_image_show"] = $support_image_button;
					$response ["support_image"] = $this->getSupportImageByOrderId($id);
					
					
					
				}else {	
					$response ["id"] = "";
					$response ["order_id"] = "";
					$response ["pattern_image_url"] = "";
					$response ["wall_size"] = "";
					$response ["date_time"] = "";
					$response ["quantity"] = "";
					$response ["description"] = "";
					$response ["audio_url"] = "";
					$response ["user_role_id"] = "";
					$response ["parent_user_id"] = "";
					$response ["first_name"] = "";
					$response ["last_name"] = "";
					$response ["user_role_name"] = "";
					$response ["order_status_id"] = "";
					$response ["status_name"] = "";
					$response ["parent_user_role_name"] = "";
					$response ["parent_first_name"] = "";
					$response ["parent_last_name"] = "";
					$response ["pattern_no"] = "";
					$response ["media"] = "";
					$response ["cancel_job"] =  "";
					$response ["button_show"] =  "";
					$response ["support_image_show"] = "";
					$response ["support_image"] = "";
					
				}
				
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}	
	
	
	
	/********** get suppport image by order_id ***********/

	public function getSupportImageByOrderId($order_id)
	{
		
		$response = array ();
		$sql1 = "SELECT image_url FROM post_job_support_image WHERE post_job_order_id = ? and is_active=1;"; 
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
						
			if ($num_rows1 > 0) {
				$stmt1->bind_result($image_url);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					
								
					$image_details[$i] = array(

						"image_url" => $image_url
					);
					
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["image_details"] = $image_details;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["image_details"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/********** get suppport image by order_id ***********/

	public function getOrderStatusByOrderId($order_id)
	{
		
		$response = array ();
		$sql1 = "SELECT s.status_name,os.created_date_time,os.description,s.status_color_code FROM order_status os, status s WHERE os.status_id = s.id and os.order_id =? and os.is_active=1 ORDER BY os.created_date_time ASC;"; 
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($status_name, $created_date_time, $description, $status_color_code);
				
				$i=0;
				$priority = 0;
				while($result = $stmt1->fetch ()){
					
					$priority++;			
					$status_details[$i] = array(
						"label" => $status_name,
						"dataTime" => $created_date_time,
						"status" => $description,
						"labelColor" => $status_color_code,
						"priority" => $priority
					);
					
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["status_details"] = $status_details;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["status_details"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	public function getlatestOrderStatusByPostJobOrderId($post_job_order_id)
	{
		
		$response = array ();
		$sql1 = "SELECT s.status_name,pjo.order_status_id FROM post_job_order pjo, status s WHERE pjo.order_status_id = s.id and pjo.id =? ;"; 
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($status_name, $order_status_id);
				
				$i=0;
				
				while($result = $stmt1->fetch ()){
					
								
					$status_details[$i] = array(
						"status_name" => $status_name,
						"order_status_id" => $order_status_id
					);
					
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["status_details"] = $status_details;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["status_details"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get stock catalog detials by wallpaper type platinum ********************/
    public function getStockDetailsByWallpaperTypePlatinum()
	{
		$server_path = SERVER_NAME1;
		$wallpaper_type = "Platinum";
		$response = array ();
		//$sql1 = "SELECT sc.id, scm.catalog_name, sc.pattern_no, sc.pattern FROM stock_catalog_master scm, stock_catalog sc where scm.wallpaper_type = ? and sc.stock_catalog_master_id = scm.id and sc.is_active = 1;";
		$sql1 = "SELECT id, catalog_name, catalog_image FROM stock_catalog_master where wallpaper_type = ? and is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$wallpaper_type);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_name,$catlog_image);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$stock_catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_image" => $catlog_image
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_catlog_list"] = $stock_catlog_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_catlog_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get stock catalog detials by wallpaper type economical ********************/
    public function getStockDetailsByWallpaperTypeEconomical()
	{
		//$server_path = SERVER_NAME1;
		$wallpaper_type = "Economical";
		$response = array ();
		//$sql1 = "SELECT sc.id, scm.catalog_name, sc.pattern_no, sc.pattern FROM stock_catalog_master scm, stock_catalog sc where scm.wallpaper_type = ? and sc.stock_catalog_master_id = scm.id and sc.is_active = 1;";
		$sql1 = "SELECT id, catalog_name, catalog_image FROM stock_catalog_master where wallpaper_type = ? and is_active = 1;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$wallpaper_type);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_name,$catlog_image);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$stock_catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_image" => $catlog_image
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_catlog_list"] = $stock_catlog_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_catlog_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get stock catalog detials by all wallpaper type ********************/
    public function getStockDetailsByAllWallpaperType($flag)
	{
		//$server_path = SERVER_NAME1;
		$response = array ();
		if($flag == 0){
			$sql1 = "SELECT id, catalog_name, catalog_image, wallpaper_type, is_active FROM stock_catalog_master;";
		}else if($flag == 1){
			$sql1 = "SELECT id, catalog_name, catalog_image, wallpaper_type, is_active FROM stock_catalog_master WHERE wallpaper_type = 'Platinum' ;";
		}else if($flag == 2){
			$sql1 = "SELECT id, catalog_name, catalog_image, wallpaper_type, is_active FROM stock_catalog_master WHERE wallpaper_type = 'Economical' ;";
		}	
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "s" ,$wallpaper_type);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_name,$catlog_image, $wallpaper_type, $is_active);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$stock_catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_image" => $catlog_image,
						"wallpaper_type" => $wallpaper_type,
						"is_active" => $is_active
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_catlog_list"] = $stock_catlog_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_catlog_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	/******************** Get stock catalog detials by all wallpaper type by distributor ********************/
    public function getStockDetailsByAllWallpaperTypeDistributor($flag,$city_id)
	{
		//$server_path = SERVER_NAME1;
		$response = array ();
		if($flag == 0){
			$sql1 = "select DISTINCT scm.id, scm.catalog_name, scm.catalog_image, scm.wallpaper_type, scm.is_active From stock_catalog_master scm, stock_catalog sc where scm.id = sc.stock_catalog_master_id and sc.city_id IN (1,?);";
		}else if($flag == 1){
			//$sql1 = "SELECT id, catalog_name, catalog_image, wallpaper_type, is_active FROM stock_catalog_master WHERE wallpaper_type = 'Platinum' ;";
			$sql1 = "select DISTINCT scm.id, scm.catalog_name, scm.catalog_image, scm.wallpaper_type, scm.is_active From stock_catalog_master scm, stock_catalog sc where scm.id = sc.stock_catalog_master_id and sc.city_id IN (1,?) AND scm.wallpaper_type = 'Platinum' ;";
		}else if($flag == 2){
			//$sql1 = "SELECT id, catalog_name, catalog_image, wallpaper_type, is_active FROM stock_catalog_master WHERE wallpaper_type = 'Economical' ;";
			$sql1 = "select DISTINCT scm.id, scm.catalog_name, scm.catalog_image, scm.wallpaper_type, scm.is_active From stock_catalog_master scm, stock_catalog sc where scm.id = sc.stock_catalog_master_id and sc.city_id IN (1,?) AND scm.wallpaper_type = 'Economical';";
		}	
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$city_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_name,$catlog_image, $wallpaper_type, $is_active);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					$stock_catlog_list[$i] = array(
						"id" => $id,
						"catlog_name" => $catlog_name,
						"catlog_image" => $catlog_image,
						"wallpaper_type" => $wallpaper_type,
						"is_active" => $is_active
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["stock_catlog_list"] = $stock_catlog_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_catlog_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************ update job status ************/
	
	public function getUserRoleDetailsById($order_id,$user_id,$description,$created_by_ip)
	{
		
		$response = array ();
		$sql1 = "SELECT u.id, ur.user_role_name FROM Users u, User_roles ur where u.id = ? and ur.id = u.user_role_id;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $user_role_name);
				$result = $stmt1->fetch ();				
				/*$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["id"] = $id;
				$response ["user_role_name"] = $user_role_name;*/
				$this->InsertCancelStatusByOrderId($order_id,$user_id,$description,$user_role_name,$created_by_ip);
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	public function getUserRoleDetailsByUserId($user_id)
	{
		
		$response = array ();
		$sql1 = "SELECT u.id, ur.user_role_name FROM Users u, User_roles ur where u.id = ? and ur.id = u.user_role_id;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $user_role_name);
				$result = $stmt1->fetch ();				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["id"] = $id;
				$response ["user_role_name"] = $user_role_name;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	
	public function InsertCancelStatusByOrderId($order_id,$user_id,$description,$user_role_name,$created_by_ip){	
	try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			//echo $user_role_name;
			if($user_role_name ="Distributor"){
				$status = 3;
			}else{
				$status =6;
			}
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_status` (`order_id`, `status_id`, `description`, `user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iisiiississ" ,$order_id,$status,$description,$user_id,$is_active,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					/*$response ["error"] = false;
					$response ["message"] = "DATA_ADDED_SUCCESSFULLY";*/
					$this->updateOrderStatusByOrderId($status,$order_id);
					
															
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
}

public function updateOrderStatusByOrderId($order_status_id,$order_id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
										
		$sql1 = "UPDATE post_job_order SET order_status_id=? where id = ?";
				
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$order_status_id, $order_id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function InsertDistributorApproveStatusByOrderId($order_id,$user_id,$created_by_ip){	
	try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$status = 2;
			$description = " ";
			
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_status` (`order_id`, `status_id`, `description`, `user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`) VALUES (?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iisiiiss" ,$order_id,$status,$description,$user_id,$is_active,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					//$response ["error"] = false;
					//$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
					$this->updateOrderStatusByOrderId($status,$order_id);
					
															
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
}


/***************** insert approved preview order ****************/

public function InsertApprovedPreviewStatusByOrderId($order_id,$user_id,$created_by_ip){	
	try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			//echo $user_role_name;
			$status = 8;
			
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_status` (`order_id`, `status_id`, `user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iiiiississ" ,$order_id,$status,$user_id,$is_active,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					/*$response ["error"] = false;
					$response ["message"] = "DATA_ADDED_SUCCESSFULLY";*/
					$this->updateOrderStatusByOrderId($status,$order_id);
					
															
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
}

/***************** insert approved preview order ****************/

public function InsertUploadPreviewStatusByOrderId($order_id,$user_id,$created_by_ip){	
	try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			//echo $user_role_name;
			$status = 9;
			
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_status` (`order_id`, `status_id`, `user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iiiiississ" ,$order_id,$status,$user_id,$is_active,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					/*$response ["error"] = false;
					$response ["message"] = "DATA_ADDED_SUCCESSFULLY";*/
					$this->updateOrderStatusByOrderId($status,$order_id);
					
															
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
}

/***************** insert printing order ****************/

public function InsertPrintingStatusByOrderId($order_id,$user_id,$created_by_ip){	
	try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			//echo $user_role_name;
			$status = 5;
			
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_status` (`order_id`, `status_id`, `user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iiiiississ" ,$order_id,$status,$user_id,$is_active,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					/*$response ["error"] = false;
					$response ["message"] = "DATA_ADDED_SUCCESSFULLY";*/
					$this -> getprintuserbyorderid($order_id);
					$this->updateOrderStatusByOrderId($status,$order_id);
					
															
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
}

public function getprintuserbyorderid($post_job_order_id){
		$response = array ();
		
		
		$sql1 = "select u.id, u.parent_user_id, pjo.order_id From Users u ,post_job_order pjo where pjo.id = ? and pjo.order_by_user_id = u.id;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id,$parent_user_id,$order_id);
								
				
				$result = $stmt1->fetch ();
				
			/*$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["user_id"] = $user_id;
			$response ["parent_user_id"] = $parent_user_id;*/
			$this -> SentPrintSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id);
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
public function SentPrintSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id)
{
		$response = array ();
		$push_notification_id_list = array();
		$obj = new notification ();
		
        //$sql1 = "select id,push_notification_id From Users where id in(?,?);";
		$sql1 = "select id,push_notification_id From Users where id in(?,?) or user_role_id = 1;";
		  
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$user_id,$parent_user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($userid,$push_notification_registration_id);
				$i = 0;
				while ($result = $stmt1->fetch ()){
					$prof_name_mobile[$i] = array(
						"userid" => $userid,
						"push_notification_registration_id" => $push_notification_registration_id
						);
						$i++;
				}
				
				//$title = "STC WALLPAPER";
				//$body = "Order Id - ".$order_id." sent for printing";
				
				$notice_id = 7;
				$getnotification = $this->getAllNoticeByNoticeId($notice_id);
				
				$title = $getnotification["notification_title"];
				$body = $getnotification["notification_body"];
				
				$k=0;
				for($j=0; $j<sizeof($prof_name_mobile); $j++){
					
					if($prof_name_mobile[$j]['push_notification_registration_id']!=""){
						$push_notification_id_list[$k] = $prof_name_mobile[$j]['push_notification_registration_id'];
						$k++;
					}
				}
				
				$k1=0;
				for($j1=0; $j1<sizeof($prof_name_mobile); $j1++){
					
					if($prof_name_mobile[$j1]['userid']!=""){
						$user_id_list[$k1] = $prof_name_mobile[$j1]['userid'];
						$k1++;
					}
				}
				//$this-> insertnotification($user_id_list,$title,$body,$user_id);	
					
				//$obj->sendPushNotification($push_notification_id_list,$title,$body);
				
				$order_detail = $this->getAllJobByOrderUserId($post_job_order_id);
				$preview = $this->getApproveImagePreviewDetails($post_job_order_id);
						
										
				$id = $order_detail["id"];
				$order_id = $order_detail["order_id"];
				$pattern_image_url = $order_detail["pattern_image_url"];
				$wall_size = $order_detail["wall_size"];
				$date_time = $order_detail["date_time"];
				$quantity = $order_detail["quantity"];
				$description = $order_detail["description"];
				$audio_url = $order_detail["audio_url"];
				$user_role_id = $order_detail["user_role_id"];
				$order_by_user_id = $order_detail["order_by_user_id"];
				$parent_user_id = $order_detail["parent_user_id"];
				$first_name = $order_detail["first_name"];
				$last_name = $order_detail["last_name"];
				$user_role_name = $order_detail["user_role_name"];
				$order_status_id = $order_detail["order_status_id"];
				$status_name = $order_detail["status_name"];
				$parent_user_role_name = $order_detail["parent_user_role_name"];
				$parent_first_name = $order_detail["parent_first_name"];
				$parent_last_name =  $order_detail["parent_last_name"];
				$pattern_no = $order_detail["pattern_no"];
				$media = $order_detail["media"];
				$button_show = $order_detail["button_show"];
				$cancel_job = $order_detail["cancel_job"];
				$support_image =  $order_detail["support_image"];
				$preview_image = $preview["upload_image_url"];
							
				//echo $pattern_image_url;	
				
				//$this-> insertnotification($user_id_list,$title,$body,$post_job_order_id,$user_id);	
				$this-> insertnotificationJob($notice_id,$user_id_list,$post_job_order_id,$user_id);
					
				$obj->sendPushNotificationForJob($push_notification_id_list,$title,$body,$order_id,$pattern_image_url,$order_by_user_id,$order_status_id,$status_name,$description,$audio_url,$pattern_no,$preview_image,$support_image);
				
			}else{
				$response ["error"] = false;
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

/***************** insert packed and dispatch order ****************/

public function InsertPackedandPrintStatusByOrderId($order_id,$user_id,$created_by_ip){	
	try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			//echo $user_role_name;
			$status = 7;
			
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_status` (`order_id`, `status_id`, `user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iiiiississ" ,$order_id,$status,$user_id,$is_active,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					/*$response ["error"] = false;
					$response ["message"] = "DATA_ADDED_SUCCESSFULLY";*/
					$this -> getPackeduserbyorderid($order_id);	
					$this->updateOrderStatusByOrderId($status,$order_id);
					
															
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
}

public function getPackeduserbyorderid($post_job_order_id){
		$response = array ();
		
		
		$sql1 = "select u.id, u.parent_user_id, pjo.order_id From Users u ,post_job_order pjo where pjo.id = ? and pjo.order_by_user_id = u.id;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id,$parent_user_id,$order_id);
								
				
				$result = $stmt1->fetch ();
				
			/*$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["user_id"] = $user_id;
			$response ["parent_user_id"] = $parent_user_id;*/
			$this -> SentPackedSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id);
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
public function SentPackedSendNotification($user_id,$parent_user_id,$order_ids,$post_job_order_id)
{
		$response = array ();
		$push_notification_id_list = array();
		$obj = new notification ();
		
        //$sql1 = "select id,push_notification_id From Users where id in(?,?);";
		$sql1 = "select id,push_notification_id From Users where id in(?,?) or user_role_id = 1;";
		  
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$user_id,$parent_user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($userid,$push_notification_registration_id);
				$i = 0;
				while ($result = $stmt1->fetch ()){
					$prof_name_mobile[$i] = array(
						"userid" => $userid,
						"push_notification_registration_id" => $push_notification_registration_id
						);
						$i++;
				}
				
				//$title = "STC WALLPAPER";
				//$body = "Order Id - ".$order_id." sent for packed and dispatched.";
				
				$notice_id = 8;
				$getnotification = $this->getAllNoticeByNoticeId($notice_id);

				$title = $getnotification["notification_title"];
				$body = $getnotification["notification_body"];
				//echo $title;
				
				$k=0;
				for($j=0; $j<sizeof($prof_name_mobile); $j++){
					
					if($prof_name_mobile[$j]['push_notification_registration_id']!=""){
						$push_notification_id_list[$k] = $prof_name_mobile[$j]['push_notification_registration_id'];
						$k++;
					}
				}
				
				$k1=0;
				for($j1=0; $j1<sizeof($prof_name_mobile); $j1++){
					
					if($prof_name_mobile[$j1]['userid']!=""){
						$user_id_list[$k1] = $prof_name_mobile[$j1]['userid'];
						$k1++;
					}
				}
				//$this-> insertnotification($user_id_list,$title,$body,$user_id);	
					
				//$obj->sendPushNotification($push_notification_id_list,$title,$body);
				
				$order_detail = $this->getAllJobByOrderUserId($post_job_order_id);
				$preview = $this->getApproveImagePreviewDetails($post_job_order_id);
						
										
				$id = $order_detail["id"];
				$order_id = $order_detail["order_id"];
				$pattern_image_url = $order_detail["pattern_image_url"];
				$wall_size = $order_detail["wall_size"];
				$date_time = $order_detail["date_time"];
				$quantity = $order_detail["quantity"];
				$description = $order_detail["description"];
				$audio_url = $order_detail["audio_url"];
				$user_role_id = $order_detail["user_role_id"];
				$order_by_user_id = $order_detail["order_by_user_id"];
				$parent_user_id = $order_detail["parent_user_id"];
				$first_name = $order_detail["first_name"];
				$last_name = $order_detail["last_name"];
				$user_role_name = $order_detail["user_role_name"];
				$order_status_id = $order_detail["order_status_id"];
				$status_name = $order_detail["status_name"];
				$parent_user_role_name = $order_detail["parent_user_role_name"];
				$parent_first_name = $order_detail["parent_first_name"];
				$parent_last_name =  $order_detail["parent_last_name"];
				$pattern_no = $order_detail["pattern_no"];
				$media = $order_detail["media"];
				$button_show = $order_detail["button_show"];
				$cancel_job = $order_detail["cancel_job"];
				$support_image =  $order_detail["support_image"];
				$preview_image = $preview["upload_image_url"];
							
				//echo $pattern_image_url;	
				
				//$this-> insertnotification($user_id_list,$title,$body,$post_job_order_id,$user_id);
					$this-> insertnotificationJob($notice_id,$user_id_list,$post_job_order_id,$user_id);				
					
				$obj->sendPushNotificationForJob($push_notification_id_list,$title,$body,$order_ids,$pattern_image_url,$order_by_user_id,$order_status_id,$status_name,$description,$audio_url,$pattern_no,$preview_image,$support_image);
				
				
			}else{
				$response ["error"] = false;
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}


/***************** insert Accept and Reject order ****************/

public function InsertAcceptRejectStatusByOrderId($order_id,$status_id,$description,$user_id,$created_by_ip){	
	try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			//echo $user_role_name;
			//$status = 7;
			
			$this->conn->autocommit ( false );
			$response = array ();
			
			$sql = "INSERT INTO `order_status` (`order_id`, `status_id`, `description`, `user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "iisiiississ" ,$order_id,$status_id,$description,$user_id,$is_active,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					/*$response ["error"] = false;
					$response ["message"] = "DATA_ADDED_SUCCESSFULLY";*/
					$this -> getAcceptRejectuserbyorderid($order_id,$user_id,$status_id);	
					$this->updateOrderStatusByOrderId($status_id,$order_id);
					
															
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
}

public function getAcceptRejectuserbyorderid($post_job_order_id,$user_id,$status_id){
		$response = array ();
		
		
		//$sql1 = "select u.id, u.parent_user_id, ur.user_role_name, pjo.order_id From Users u ,post_job_order pjo, User_roles ur where pjo.id = ? and pjo.order_by_user_id = u.id and u.user_role_id = ur.id ;";
		
		$sql1 = "select u.id, u.parent_user_id, ur.user_role_name From Users u , User_roles ur where u.id =? and u.user_role_id = ur.id;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id,$parent_user_id, $user_role);
								
				
				$result = $stmt1->fetch ();
				
			/*$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["user_id"] = $user_id;
			$response ["parent_user_id"] = $parent_user_id;*/
			$this -> PreviewAcceprRejectSendNotification($user_id,$parent_user_id,$user_role,$status_id,$post_job_order_id);
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
public function PreviewAcceprRejectSendNotification($user_id,$parent_user_id,$user_role,$status_id,$post_job_order_id)
{
		$response = array ();
		$push_notification_id_list = array();
		$obj = new notification ();
		
        //$sql1 = "select id,push_notification_id From Users where id in(?,?);";
		$sql1 = "select id,push_notification_id From Users where id =? or user_role_id = 1;";
		  
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			//$stmt1->bind_param ( "ii" ,$user_id,$parent_user_id);	
			$stmt1->bind_param ( "i" ,$parent_user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($userid,$push_notification_registration_id);
				$i = 0;
				while ($result = $stmt1->fetch ()){
					$prof_name_mobile[$i] = array(
						"userid" => $userid,
						"push_notification_registration_id" => $push_notification_registration_id
						);
						$i++;
				}
				//echo $user_role;
				
				$order_detail = $this->getAllJobByOrderUserId($post_job_order_id);
				$preview = $this->getApproveImagePreviewDetails($post_job_order_id);
						
										
				$id = $order_detail["id"];
				$order_id = $order_detail["order_id"];
				$pattern_image_url = $order_detail["pattern_image_url"];
				$wall_size = $order_detail["wall_size"];
				$date_time = $order_detail["date_time"];
				$quantity = $order_detail["quantity"];
				$description = $order_detail["description"];
				$audio_url = $order_detail["audio_url"];
				$user_role_id = $order_detail["user_role_id"];
				$order_by_user_id = $order_detail["order_by_user_id"];
				$parent_user_id = $order_detail["parent_user_id"];
				$first_name = $order_detail["first_name"];
				$last_name = $order_detail["last_name"];
				$user_role_name = $order_detail["user_role_name"];
				$order_status_id = $order_detail["order_status_id"];
				$status_name = $order_detail["status_name"];
				$parent_user_role_name = $order_detail["parent_user_role_name"];
				$parent_first_name = $order_detail["parent_first_name"];
				$parent_last_name =  $order_detail["parent_last_name"];
				$pattern_no = $order_detail["pattern_no"];
				$media = $order_detail["media"];
				$button_show = $order_detail["button_show"];
				$cancel_job = $order_detail["cancel_job"];
				$support_image =  $order_detail["support_image"];
				$preview_image = $preview["upload_image_url"];
				
				if($user_role == "Distributor" && $status_id == 8){
				
					//$title = "STC WALLPAPER";
					//$body = "Preview approved by distributor for Order Id - ".$order_id;
					$notice_id = 3;
					$getnotification = $this->getAllNoticeByNoticeId($notice_id);

					$title = $getnotification["notification_title"];
					$body = $getnotification["notification_body"]."- ".$order_id;
				
				}else if($user_role == "Distributor" && $status_id == 12){
				
					//$title = "STC WALLPAPER";
					//$body = "Preview rejected by distributor for Order Id - ".$order_id;
					$notice_id = 4;
					$getnotification = $this->getAllNoticeByNoticeId($notice_id);

					$title = $getnotification["notification_title"];
					$body = $getnotification["notification_body"]."- ".$order_id;
				
				}else if($user_role == "Dealer" && $status_id == 10){
				
					//$title = "STC WALLPAPER";
					//$body = "Preview approved by dealer for Order Id - ".$order_id;
					$notice_id = 5;
					$getnotification = $this->getAllNoticeByNoticeId($notice_id);

					$title = $getnotification["notification_title"];
					$body = $getnotification["notification_body"]."- ".$order_id;
				
				}else if($user_role == "Dealer" && $status_id == 11){
				
					//$title = "STC WALLPAPER";
					//$body = "Preview rejected by dealer for Order Id - ".$order_id;
					
					$notice_id = 6;
					$getnotification = $this->getAllNoticeByNoticeId($notice_id);

					$title = $getnotification["notification_title"];
					$body = $getnotification["notification_body"]."- ".$order_id;
				
				}
				$k=0;
				for($j=0; $j<sizeof($prof_name_mobile); $j++){
					
					if($prof_name_mobile[$j]['push_notification_registration_id']!=""){
						$push_notification_id_list[$k] = $prof_name_mobile[$j]['push_notification_registration_id'];
						$k++;
					}
				}
				
				$k1=0;
				for($j1=0; $j1<sizeof($prof_name_mobile); $j1++){
					
					if($prof_name_mobile[$j1]['userid']!=""){
						$user_id_list[$k1] = $prof_name_mobile[$j1]['userid'];
						$k1++;
					}
				}
				//$this-> insertnotification($user_id_list,$title,$body,$user_id);	
					
				//$obj->sendPushNotification($push_notification_id_list,$title,$body);
				
				
							
				//echo $pattern_image_url;	
				
				//$this-> insertnotification($user_id_list,$title,$body,$post_job_order_id,$user_id);	
				$this-> insertnotificationJob($notice_id,$user_id_list,$post_job_order_id,$user_id);
					
				$obj->sendPushNotificationForJob($push_notification_id_list,$title,$body,$order_id,$pattern_image_url,$order_by_user_id,$order_status_id,$status_name,$description,$audio_url,$pattern_no,$preview_image,$support_image);
				
				
			}else{
				$response ["error"] = false;
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

	
	/************ insert job details *****************/
	
	public function insertPostJobOrder($catlog_sub_category_id,$pattern_image_url,$width,$height,$quantity,$description,$audio_url,$media_sheet_type_id,$paper_type_id,$order_by_user_id,$support_image_list,$img_flag) {
		try {
			
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$order_status_id = 2;
			$this->conn->autocommit ( false );
			$latest_order_no = $this->getlatestorderno();
			$latestorderno = $latest_order_no["order_id"]+1;
			$response = array ();
			
			if($img_flag==1){
				$pattern_url = $pattern_image_url;
				
			}elseif($img_flag==2){
				$p = basename($pattern_image_url);
				$pattern_url = "/backend/editpattern/".$p;
				//echo $p;
			}

			if($audio_url!=""){
				//$audiourl = "backend/postjob/".$audio_url;
				/*$savePath1 = "../backend/audio/";
				$new_savePath11 = "backend/audio/";
				$imageName1 = "audio-".Date ( "YmdHis" );
				$audio_path = $this->allKindOfFileUpload($audio_url, $savePath1, $imageName1, $new_savePath11);
				$audiourl = $audio_path["image_url"];*/
				$audiourl = $audio_url;
				
			}else{
				$audiourl ="";
			}			
			
			$total_heightwidth = ($width * $height)/144;
			$total_sqft1 = $total_heightwidth * $quantity;
			$total_sqft = number_format((float)$total_sqft1, 2, '.', '');
			
			$sql = "INSERT INTO `post_job_order` (`order_id`, `catlog_sub_category_id`, `pattern_image_url`, `width`, `height`, `quantity`, `Total_sq_ft`, `description`, `audio_url`, `media_sheet_type_id`, `paper_type_id`, `order_status_id`, `order_by_user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
			if ($stmt = $this->conn->prepare ( $sql )) {
				$stmt->bind_param ( "sisssssssiiiiiississ" ,$latestorderno,$catlog_sub_category_id,$pattern_url,$width,$height,$quantity,$total_sqft,$description,$audiourl,$media_sheet_type_id,$paper_type_id,$order_status_id,$order_by_user_id,$is_active,$order_by_user_id,$created_by_ip,$date,$order_by_user_id,$created_by_ip,$date);
				$result = $stmt->execute ();
				$job_id = $this->conn->insert_id;
				//$stmt->close ();
				if ($result) {	
					$this->conn->commit ();
					
					$response ["last_id"] = $job_id;
					//$response ["audiourl"] = $audiourl;
					$this -> getPostJobuserbyorderid($job_id);	
					
					if($support_image_list!=""){
						$this->insertPostJobsupportimage($job_id,$support_image_list,$order_by_user_id);
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
					}else{
						$response ["error"] = false;
						 $response ["message"] = "DATA_ADDED_SUCCESSFULLY";
					}		
										
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "DATA_ADDED_FAILED";
					$response ['msg'] = $stmt->error;
				}
			} else {
				$this->conn->rollback ();
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	public function getPostJobuserbyorderid($post_job_order_id){
		$response = array ();
		
		
		$sql1 = "select u.id, u.parent_user_id, pjo.order_id From Users u ,post_job_order pjo where pjo.id = ? and pjo.order_by_user_id = u.id;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id,$parent_user_id,$order_id);
								
				
				$result = $stmt1->fetch ();
				
			/*$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";*/
			//$response ["user_id"] = $user_id;
			//$response ["parent_user_id"] = $parent_user_id;
			$this -> PostJobSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id);
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
public function PostJobSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id)
{
		$response = array ();
		$push_notification_id_list = array();
		$obj = new notification ();
		
        //$sql1 = "select id,push_notification_id From Users where id in(?,?);";
        $sql1 = "select id,push_notification_id From Users where id = ? or user_role_id = 1;";
		  
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			//$stmt1->bind_param ( "ii" ,$user_id,$parent_user_id);	
			$stmt1->bind_param ( "i" ,$parent_user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($userid,$push_notification_registration_id);
				$i = 0;
				while ($result = $stmt1->fetch ()){
					$prof_name_mobile[$i] = array(
						"userid" => $userid,
						"push_notification_registration_id" => $push_notification_registration_id
						);
						$i++;
				}
				
				//$title = "STC WALLPAPER";
				//$body = "New Job Posted.";
				
				$notice_id = 1;
				$getnotification = $this->getAllNoticeByNoticeId($notice_id);

				$title = $getnotification["notification_title"];
				$body = $getnotification["notification_body"];
				
				$k=0;
				for($j=0; $j<sizeof($prof_name_mobile); $j++){
					
					if($prof_name_mobile[$j]['push_notification_registration_id']!=""){
						$push_notification_id_list[$k] = $prof_name_mobile[$j]['push_notification_registration_id'];
						$k++;
					}
				}
					//print_r($push_notification_id_list);
				
				$k1=0;
				for($j1=0; $j1<sizeof($prof_name_mobile); $j1++){
					
					if($prof_name_mobile[$j1]['userid']!=""){
						$user_id_list[$k1] = $prof_name_mobile[$j1]['userid'];
						$k1++;
					}
				}
				
				$order_detail = $this->getAllJobByOrderUserId($post_job_order_id);
				$preview = $this->getApproveImagePreviewDetails($post_job_order_id);
						
										
				$id = $order_detail["id"];
				$order_id = $order_detail["order_id"];
				$pattern_image_url = $order_detail["pattern_image_url"];
				$wall_size = $order_detail["wall_size"];
				$date_time = $order_detail["date_time"];
				$quantity = $order_detail["quantity"];
				$description = $order_detail["description"];
				$audio_url = $order_detail["audio_url"];
				$user_role_id = $order_detail["user_role_id"];
				$order_by_user_id = $order_detail["order_by_user_id"];
				$parent_user_id = $order_detail["parent_user_id"];
				$first_name = $order_detail["first_name"];
				$last_name = $order_detail["last_name"];
				$user_role_name = $order_detail["user_role_name"];
				$order_status_id = $order_detail["order_status_id"];
				$status_name = $order_detail["status_name"];
				$parent_user_role_name = $order_detail["parent_user_role_name"];
				$parent_first_name = $order_detail["parent_first_name"];
				$parent_last_name =  $order_detail["parent_last_name"];
				$pattern_no = $order_detail["pattern_no"];
				$media = $order_detail["media"];
				$button_show = $order_detail["button_show"];
				$cancel_job = $order_detail["cancel_job"];
				$support_image =  $order_detail["support_image"];
				$preview_image = $preview["upload_image_url"];
							
				//print_r($support_image);	
				
				//$this-> insertnotification($user_id_list,$title,$body,$post_job_order_id,$user_id);	
				$this-> insertnotificationJob($notice_id,$user_id_list,$post_job_order_id,$user_id);
					
				$obj->sendPushNotificationForJob($push_notification_id_list,$title,$body,$order_id,$pattern_image_url,$order_by_user_id,$order_status_id,$status_name,$description,$audio_url,$pattern_no,$preview_image,$support_image);
			}else{
				$response ["error"] = false;
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}
	
	public function insertPostJobsupportimage($job_id,$support_image_list,$order_by_user_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$this->conn->autocommit ( false );
			$response = array ();
			
			$supportimagelist = json_decode($support_image_list,true);	
			//echo sizeof($s);
			foreach ($supportimagelist as $key => $value) {
				$supportimagelist_path = basename($value["uri"]);
				//echo $supportimagelist_path;
				$supportimage = "backend/postjob/".$supportimagelist_path;
				
				$sql = "INSERT INTO `post_job_support_image` (`post_job_order_id`, `image_url`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "isiississ" ,$job_id,$supportimage,$is_active,$order_by_user_id,$created_by_ip,$date,$order_by_user_id,$created_by_ip,$date);
					$result = $stmt->execute ();
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			}
			//$supportimagelist = explode("},",$support_image_list);
			//$supportimagelist_path = $supportimagelist['uri'];
			//$supportimagelist_imgname = basename($supportimagelist_path);
			//print_r ($supportimagelist['uri']);
			//print_r ($supportimagelist_imgname);
			//echo sizeof($id_list);
			//for($i=0;$i<sizeof($s);$i++){
				
				//print $s[$i];
				/*
				$supportimage = "backend/postjob/".$supportimagelist[$i];
				
				$sql = "INSERT INTO `post_job_support_image` (`post_job_order_id`, `image_url`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "isiississ" ,$job_id,$supportimage,$is_active,$order_by_user_id,$created_by_ip,$date,$order_by_user_id,$created_by_ip,$date);
					$result = $stmt->execute ();
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}*/
			//}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	/************************* List Admin User ***********************/
	
	public function getListAllUserByUserRole($user_role_id)
	{
		$response = array ();
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.companyName, u.profilePicture, u.company_logo, u.email_id, u.mobile_number, u.password, u.office_address, u.city_id, c.city_name, u.state_id, s.state_name, u.pin_code, u.user_role_id, u.parent_user_id, ur.user_role_name, u.is_active FROM Users u, City c, State s, User_roles ur WHERE u.user_role_id = ur.id and u.city_id = c.id and u.state_id = s.id and u.user_role_id = ?";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_role_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$city_name,$state_id,$state_name,$pin_code,$user_role_id,$parent_user_id,$user_role_name,$is_active);
				
				
				
					
				
					$i=0;
					while($result = $stmt1->fetch ()){
						
						if($parent_user_id != ""){
						
							$parent = $this->getParentUserDetails($parent_user_id);
							
							
							$parent_first_name = $parent["first_name"];
							$parent_last_name = $parent["last_name"];
							$parent_user_role_name = $parent["user_role_name"];
							
							
						}
						else{
							
							$parent_user_role_name = "";
							$parent_first_name = "";
							$parent_last_name = "";
						
						}						
						
						$user_list[$i] = array(
							"id" => $id,
							"first_name1" => $first_name,
							"last_name" => $last_name,
							"companyName" => $companyName,
							"profilePicture" => $profilePicture,
							"company_logo" => $company_logo,
							"email_id" => $email_id,
							"mobile_number" => $mobile_number,
							"password" => $password,
							"office_address" => $office_address,
							"city_id" => $city_id,
							"city_name" => $city_name,
							"state_id" => $state_id,
							"state_name" => $state_name,
							"pin_code" => $pin_code,
							"user_role_id" => $user_role_id,
							"user_role_name" => $user_role_name,
							"is_active" => $is_active,
							"parent_user_role_name" => $parent_user_role_name,
							"parent_first_name" =>  $parent_first_name,
							"parent_last_name" =>  $parent_last_name,
						);
						$i++;
					}
				
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
    			$response ["user_list"] = $user_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["user_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	public function GetDealerDetailsByDistributerIdAdmin($user_id)
	{
		$response = array ();
		$sql1 = "SELECT u.id, u.first_name, u.last_name, u.companyName, u.profilePicture, u.company_logo, u.email_id, u.mobile_number, u.password, u.office_address, u.city_id, c.city_name, u.state_id, s.state_name, u.pin_code, u.user_role_id, u.parent_user_id, ur.user_role_name, u.is_active FROM Users u, City c, State s, User_roles ur WHERE u.user_role_id = ur.id and u.city_id = c.id and u.state_id = s.id and u.parent_user_id = ?";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$city_name,$state_id,$state_name,$pin_code,$user_role_id,$parent_user_id,$user_role_name,$is_active);
				
				
				
					
				
					$i=0;
					while($result = $stmt1->fetch ()){
						
						if($parent_user_id != ""){
						
							$parent = $this->getParentUserDetails($parent_user_id);
							
							
							$parent_first_name = $parent["first_name"];
							$parent_last_name = $parent["last_name"];
							$parent_user_role_name = $parent["user_role_name"];
							
							
						}
						else{
							
							$parent_user_role_name = "";
							$parent_first_name = "";
							$parent_last_name = "";
						
						}						
						
						$user_list[$i] = array(
							"id" => $id,
							"first_name1" => $first_name,
							"last_name" => $last_name,
							"companyName" => $companyName,
							"profilePicture" => $profilePicture,
							"company_logo" => $company_logo,
							"email_id" => $email_id,
							"mobile_number" => $mobile_number,
							"password" => $password,
							"office_address" => $office_address,
							"city_id" => $city_id,
							"city_name" => $city_name,
							"state_id" => $state_id,
							"state_name" => $state_name,
							"pin_code" => $pin_code,
							"user_role_id" => $user_role_id,
							"user_role_name" => $user_role_name,
							"is_active" => $is_active,
							"parent_user_role_name" => $parent_user_role_name,
							"parent_first_name" =>  $parent_first_name,
							"parent_last_name" =>  $parent_last_name,
						);
						$i++;
					}
				
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
    			$response ["user_list"] = $user_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["user_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	/************** get parents user details ****************/
	
	public function getParentUserDetails($parent_user_id){
		$response = array ();
		
		//$sql1 = "SELECT t.grand_total FROM ami_school_student_batch_mapping m, ami_school_exam_grand_total t WHERE m.student_id = ? and m.batch_id = ? and m.id = t.student_batch_section_id and t.exam_id = ? ;";
		$sql1 = "SELECT u.first_name, u.last_name, ur.user_role_name FROM Users u, User_roles ur WHERE u.user_role_id = ur.id and u.id=?;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$parent_user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($first_name,$last_name,$user_role_name);
				$result = $stmt1->fetch ();
				
				$response ["first_name"] = $first_name;
				$response ["last_name"] = $last_name;
				$response ["user_role_name"] = $user_role_name;
				
			} else { 
				$response ["first_name"] = "";
				$response ["last_name"] = "";
				$response ["user_role_name"] = "";
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get parents user details ****************/
	
	public function getsupportimagestatus($orders_id){
		$response = array ();
		
		//$sql1 = "SELECT t.grand_total FROM ami_school_student_batch_mapping m, ami_school_exam_grand_total t WHERE m.student_id = ? and m.batch_id = ? and m.id = t.student_batch_section_id and t.exam_id = ? ;";
		$sql1 = "SELECT image_url FROM post_job_support_image WHERE post_job_order_id = ? ;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$orders_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result ($image_url);
				$result = $stmt1->fetch ();
				
				$response ["support_button"] = "Yes";
				
				
			} else { 
				$response ["support_button"] = "No";
			}
		} else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/*************************/
	
	public function getPatternDetailsById($catlog_sub_category_id)
	{
		
		$response = array ();
	
		$sql1 = "SELECT id, customise_catlog_sub_category_name, pattern_no, sub_category_img_url FROM  customise_catlog_sub_category WHERE id=? and is_active=1 ;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$catlog_sub_category_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				
				$stmt1->bind_result($id, $customise_catlog_sub_category_name, $pattern_no, $sub_category_img_url);
				$result = $stmt1->fetch ();
								
				$response ["id"] = $id;
				$response ["customise_catlog_sub_category_name"] = $customise_catlog_sub_category_name;
				$response ["pattern_no"] = $pattern_no;
				$response ["sub_category_img_url"] = $sub_category_img_url;
				
				
			}else {	
				$response ["id"] = "";
				$response ["customise_catlog_sub_category_name"] = "";
				$response ["pattern_no"] = "";
				$response ["sub_category_img_url"] = "";
				
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************************************ Update is_active ************************************/
	
	public function updateIsActiveByUserId($status,$user_id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
								
		$sql1 = "UPDATE Users SET is_active=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$status, $user_id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

public function updateIsActiveByStockCatlogMasterId($status,$stock_catlog_master_id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
								
		$sql1 = "UPDATE stock_catalog_master SET is_active=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$status, $stock_catlog_master_id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

/************************ insert user details ***********************/
public function checkUserDetails($first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$state_id,$pin_code,$user_role_id,$parent_user_id,$created_by_id) {
		$response = array ();
		$sql1 = "SELECT id FROM Users WHERE mobile_number=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$mobile_number);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id);
				$result = $stmt1->fetch ();
				
    			$response ["error"] = true;
    			//$response ["msg"] ="DATA_FOUND";
				$response ["msg"] = "Mobile number register with us.";
    		
    		}else{
				
					
					if($profilePicture !=""){		
						$savePath = "../backend/profile/";
						$new_savePath1 = "backend/profile/";
						$imageName = "profile_".Date ( "YmdHis" );
						//$image_path = $this->imageUpload($profilePicture, $savePath, $imageName);
						$profile_path = $this->allKindOfFileUpload($profilePicture, $savePath, $imageName, $new_savePath1);
						$profilepath = $profile_path["image_url"];
					}else{
						$profilepath = "";
					}
					
					
					if($company_logo !=""){				
						$savePath1 = "../backend/company/";
						$new_savePath11 = "backend/company/";
						$imageName1 = "company_".Date ( "YmdHis" );
						//$image_path = $this->imageUpload($company_logo, $savePath, $imageName);
						$company_path = $this->allKindOfFileUpload($company_logo, $savePath1, $imageName1, $new_savePath11);
						$cpath = $company_path["image_url"];
					}else{
						$cpath = "";
					}
				    			
    			$userRegistration = $this->insertUserDetails($first_name,$last_name,$companyName,$profilepath,$cpath,$email_id,$mobile_number,$password,$office_address,$city_id,$state_id,$pin_code,$user_role_id,$parent_user_id,$created_by_id);
				
								
				$response ["error"] = false;
    			$response ["msg"] = DATA_ADDED_SUCCESSFULLY;
				
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;

}

public function insertUserDetails($first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$state_id,$pin_code,$user_role_id,$parent_user_id,$created_by_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$this->conn->autocommit ( false );
			$response = array ();
			
						
				$sql = "INSERT INTO `Users` (`first_name`, `last_name`, `companyName`, `profilePicture`, `company_logo`, `email_id`, `mobile_number`, `password`, `office_address`, `city_id`, `state_id`, `pin_code`, `user_role_id`, `parent_user_id`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modify_by_ip`, `modify_by_id`, `modify_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "sssssssssiisiiiississ" ,$first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$state_id,$pin_code,$user_role_id,$parent_user_id,$is_active,$created_by_id,$created_by_ip,$date,$created_by_ip,$created_by_id,$date);
					$result = $stmt->execute ();
					$user_id = $this->conn->insert_id;
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						$response ["last_id"] = $user_id;
						
						
											
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			
			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	
/************************ insert stock catlog master details ***********************/

public function checkStockCatlogMasterDetails($catalog_name,$catalog_image,$wallpaper_type,$created_by_id) {
		$response = array ();
		$sql1 = "SELECT id FROM stock_catalog_master WHERE catalog_name=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "s" ,$catalog_name);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id);
				$result = $stmt1->fetch ();
				
    			$response ["error"] = true;
    			//$response ["msg"] ="DATA_FOUND";
				$response ["msg"] = "catlog name already exist.";
    		
    		}else{
				
					if (!is_dir("../catlog/".$catalog_name)) {
						mkdir("../catlog/".$catalog_name);
					}
					$savePath = "../backend/catlog/".$catalog_name."/";
					$new_savePath1 = "/backend/catlog/".$catalog_name."/";
					$imageName = $catalog_name;
					//$image_path = $this->imageUpload($profilePicture, $savePath, $imageName);
					$catlog_path = $this->allKindOfFileUpload($catalog_image, $savePath, $imageName, $new_savePath1);
					
					//echo $catlog_path["image_url"];
				    			
    			$userRegistration = $this->insertCatlogMasterDetails($catalog_name,$catlog_path["image_url"],$wallpaper_type,$created_by_id);
				
								
				//$response ["error"] = false;
    			//$response ["msg"] = DATA_ADDED_SUCCESSFULLY;
				
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;

}

public function insertCatlogMasterDetails($catalog_name,$catalogimage,$wallpaper_type,$created_by_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$this->conn->autocommit ( false );
			$response = array ();
			
						
				$sql = "INSERT INTO `stock_catalog_master` (`catalog_name`, `catalog_image`, `wallpaper_type`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "sssiisssis" ,$catalog_name, $catalogimage, $wallpaper_type, $is_active, $created_by_id, $created_by_ip, $date, $created_by_id, $created_by_ip, $date);
					$result = $stmt->execute ();
					$catlog_id = $this->conn->insert_id;
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						$response ["catlog_id"] = $catlog_id;
						
						
											
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			
			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}	


public function getStockCatlogMasterDetailsById($catlog_master_id) {
		$response = array ();
		$sql1 = "SELECT id, catalog_name, wallpaper_type, catalog_image FROM stock_catalog_master WHERE id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$catlog_master_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id,$catlog_name,$wallpaper_type,$catlog_image);
				$result = $stmt1->fetch ();
				
    			$response ["error"] = false;
    			$response ["id"] = $id;
    			$response ["catlog_name"] = $catlog_name;
    			$response ["wallpaper_type"] = $wallpaper_type;
    			$response ["catlog_image"] = $catlog_image;
    		
    		}else{
				
				$response ["error"] = true;
    			$response ["id"] = "";
    			$response ["catlog_name"] = "";
    			$response ["wallpaper_type"] = "";
    			$response ["catlog_image"] = "";
				
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;

}
/**************** update stock catlog master details *********************/

public function updateStockCatlogMasterByStockCatlogMasterId($catalog_name,$catalog_image,$wallpaper_type, $stock_catlog_master_id){	
	try {
		$this->conn->autocommit ( false );
		$response = array ();
		
		if (!is_dir("../catlog/".$catalog_name)) {
			mkdir("../catlog/".$catalog_name);
		}
		
		$savePath = "../backend/catlog/".$catalog_name."/";
		$new_savePath1 = "/backend/catlog/".$catalog_name."/";
		$imageName = $catalog_name;
		//$image_path = $this->imageUpload($profilePicture, $savePath, $imageName);
		$catlog_path = $this->allKindOfFileUpload($catalog_image, $savePath, $imageName, $new_savePath1);
								
		$sql1 = "UPDATE stock_catalog_master SET catalog_name=?, catalog_image=?, wallpaper_type=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "sssi" ,$catalog_name, $catlog_path["image_url"], $wallpaper_type, $stock_catlog_master_id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

/******************** update user details **********************/

public function updateUserDetailsById($first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$state_id,$pin_code,$user_role_id,$parent_user_id,$user_id){	
	try {
		
		$date = date ("Y-m-d H:i:s");
		$is_active = 1;
		$created_by_ip = "1.1.1.1";
		$this->conn->autocommit ( false );
		$response = array ();
		
								
		$sql1 = "UPDATE post_job_order SET order_status_id=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$order_status_id, $order_id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}

/************************ get stock catlog by stock catlog master id *************************/

	public function getStockCatlogDetailsByStockCatlogMasterId($stock_catlog_master_id, $city_id)
	{
		$response = array ();
		
		if($city_id == 0){
		
		$sql1 = "Select sc.id, sc.city_id, scc.city_name, sc.pattern_no, sc.pattern, sc.paper_type_id, p.paper_type_name, m.sheet_name, sc.roll_size, sc.total_sq_ft, sc.color, sc.latest_qty, sc.image_url, sc.country_of_origin, sc.stock_status, sc.is_active From stock_catalog sc, stock_city scc, paper_type p, media_sheet_type m where p.media_sheet_type_id = m.id and sc.paper_type_id = p.id and sc.city_id = scc.id and sc.stock_catalog_master_id = ?";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$stock_catlog_master_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id,$city_id,$city_name,$pattern_no,$pattern,$paper_type_id,$paper_type_name,$sheet_name,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$country_of_origin,$stock_status,$is_active);
				
				
					$i=0;
					while($result = $stmt1->fetch ()){
						
												
						$stock_catalog[$i] = array(
							"id" => $id,
							"city_id" => $city_id,
							"city_name" => $city_name,
							"pattern_no" => $pattern_no,
							"pattern" => $pattern,
							"paper_type_id" => $paper_type_id,
							"media" => $sheet_name.'-'.$paper_type_name,
							"roll_size" => $roll_size,
							"total_sq_ft" => $total_sq_ft,
							"color" => $color,
							"latest_qty" => $latest_qty,
							"image_url" => $image_url,
							"country_of_origin" => $country_of_origin,
							"stock_status" => $stock_status,
							"is_active" => $is_active,
							
						);
						$i++;
					}
				
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
    			$response ["stock_catalog"] = $stock_catalog;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["stock_catalog"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		
		
		}else{
			
			$sql1 = "Select sc.id, sc.city_id, scc.city_name, sc.pattern_no, sc.pattern, sc.paper_type_id, p.paper_type_name, m.sheet_name, sc.roll_size, sc.total_sq_ft, sc.color, sc.latest_qty, sc.image_url, sc.country_of_origin, sc.stock_status, sc.is_active From stock_catalog sc, stock_city scc, paper_type p, media_sheet_type m where p.media_sheet_type_id = m.id and sc.paper_type_id = p.id and sc.city_id = scc.id and sc.stock_catalog_master_id = ? and sc.city_id = ?";
			
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ii" ,$stock_catlog_master_id,$city_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id,$city_id,$city_name,$pattern_no,$pattern,$paper_type_id,$paper_type_name,$sheet_name,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$country_of_origin,$stock_status,$is_active);
					
					
						$i=0;
						while($result = $stmt1->fetch ()){
							
													
							$stock_catalog[$i] = array(
								"id" => $id,
								"city_id" => $city_id,
								"city_name" => $city_name,
								"pattern_no" => $pattern_no,
								"pattern" => $pattern,
								"paper_type_id" => $paper_type_id,
								"media" => $sheet_name.'-'.$paper_type_name,
								"roll_size" => $roll_size,
								"total_sq_ft" => $total_sq_ft,
								"color" => $color,
								"latest_qty" => $latest_qty,
								"image_url" => $image_url,
								"country_of_origin" => $country_of_origin,
								"stock_status" => $stock_status,
								"is_active" => $is_active,
								
							);
							$i++;
						}
					
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["stock_catalog"] = $stock_catalog;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["stock_catalog"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			
		}	
		
		return $response;
	}
	
	/***************** update is active stock catlog id ************************/
	
	public function updateIsActiveByStockCatlogId($status,$stock_catlog_id){	
		try {
			$this->conn->autocommit ( false );
			$response = array ();
			
									
			$sql1 = "UPDATE stock_catalog SET is_active=? where id = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ii" ,$status, $stock_catlog_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION3";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	/******************** insert stock catlog details **********************/
	
	public function checkStockCatlogDetails($stock_catalog_master_id,$stock_catalog_master_name,$city_id,$pattern_no,$pattern,$paper_type_id,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$mock_image_url,$country_of_origin,$stock_status,$created_by_id) {
		$response = array ();
		$sql1 = "SELECT id FROM stock_catalog WHERE pattern_no = ? and city_id = ?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "si" ,$pattern_no,$city_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id);
				$result = $stmt1->fetch ();
				
    			$response ["error"] = true;
    			//$response ["msg"] ="DATA_FOUND";
				$response ["msg"] = "This pattern  no. already exist in this city.";
    		
    		}else{
				
						    			
    			$stockcatlogadd = $this->insertStockCatlogDetails($stock_catalog_master_id,$stock_catalog_master_name,$city_id,$pattern_no,$pattern,$paper_type_id,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$mock_image_url,$country_of_origin,$stock_status,$created_by_id);
				
				
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;

}
	
	public function insertStockCatlogDetails($stock_catalog_master_id,$stock_catalog_master_name,$city_id,$pattern_no,$pattern,$paper_type_id,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$mock_image_url,$country_of_origin,$stock_status,$created_by_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$this->conn->autocommit ( false );
			$response = array ();
				
				//echo $stock_catalog_master_name;
				
				if (!is_dir("../catlog/".$stock_catalog_master_name."/mockup")) {
					mkdir("../catlog/".$stock_catalog_master_name."/mockup");
				}
				
				if($image_url!=""){
				
					$savePath = "../backend/catlog/".$stock_catalog_master_name."/";
					$new_savePath1 = "/backend/catlog/".$stock_catalog_master_name."/";
					$imageName = $pattern_no;
					$catlog_path = $this->allKindOfFileUpload($image_url, $savePath, $imageName, $new_savePath1);
					$catlog_img = $catlog_path["image_url"];
					
				}else{
					$catlog_img = "";
				}

				if($mock_image_url!=""){
					
									
					$savePath1 = "../backend/catlog/".$stock_catalog_master_name."/mockup/";
					$new_savePath11 = "/backend/catlog/".$stock_catalog_master_name."/mockup/";
					$imageName1 = $pattern_no."_1";
					$catlog_mock_path = $this->allKindOfFileUpload($mock_image_url, $savePath1, $imageName1, $new_savePath11);
					$catlog_mock_img = $catlog_mock_path["image_url"];
					
				}else{
					$catlog_mock_img = "";
				}	
					
						
				$sql = "INSERT INTO `stock_catalog` (`stock_catalog_master_id`, `city_id`, `pattern_no`, `pattern`, `paper_type_id`, `roll_size`, `total_sq_ft`, `color`, `latest_qty`, `image_url`, `mock_image_url`, `country_of_origin`, `stock_status`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "iississssssssiississ" ,$stock_catalog_master_id, $city_id, $pattern_no, $pattern, $paper_type_id, $roll_size, $total_sq_ft, $color, $latest_qty, $catlog_img, $catlog_mock_img, $country_of_origin, $stock_status, $is_active, $created_by_id, $created_by_ip, $date, $created_by_id, $created_by_ip, $date);
					$result = $stmt->execute ();
										
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
																	
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			
			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}

	/***************** update stock catlog details by id *********************/

	public function updateStockCatlogDetailsByStockCatlogId($stock_catalog_master_id,$stock_catalog_master_name,$city_id,$pattern_no,$pattern,$paper_type_id,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$mock_image_url,$country_of_origin,$stock_status,$created_by_id,$stock_catlog_id){	
	try {
		
		$date = date ("Y-m-d H:i:s");
		$created_by_ip = "1.1.1.1";
		$this->conn->autocommit ( false );
		$response = array ();
		
		
		if($image_url!=""){
				
			$savePath = "../backend/catlog/".$stock_catalog_master_name."/";
			$new_savePath1 = "/backend/catlog/".$stock_catalog_master_name."/";
			$imageName = $pattern_no;
			$catlog_path = $this->allKindOfFileUpload($image_url, $savePath, $imageName, $new_savePath1);
			$catlog_img = $catlog_path["image_url"];
			
		}else{
			$catlog_img = "";
		}

		if($mock_image_url!=""){
			
			if (!is_dir("../catlog/".$stock_catalog_master_name."/mockup")) {
				mkdir("../catlog/".$stock_catalog_master_name."/mockup");
			}
		
			$savePath = "../backend/catlog/".$stock_catalog_master_name."/mockup/";
			$new_savePath1 = "/backend/catlog/".$stock_catalog_master_name."/mockup/";
			$imageName = $pattern_no;
			$catlog_mock_path = $this->allKindOfFileUpload($mock_image_url, $savePath, $imageName, $new_savePath1);
			$catlog_mock_img = $catlog_mock_path["image_url"];
			
		}else{
			$catlog_mock_img = "";
		}
								
		$sql1 = "UPDATE stock_catalog SET stock_catalog_master_id=?, city_id=?, pattern_no=?, pattern=?, paper_type_id=?, roll_size=?, total_sq_ft=?, color=?, latest_qty=?, image_url=?, mock_image_url=?, country_of_origin=?, stock_status=?, modified_by_id=?, modified_by_ip=?, modified_date_time=? where id = ?";
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "iississssssssissi" ,$stock_catalog_master_id, $city_id, $pattern_no, $pattern, $paper_type_id, $roll_size, $total_sq_ft, $color, $latest_qty, $catlog_img, $catlog_mock_img, $country_of_origin, $stock_status, $created_by_id, $created_by_ip, $date, $stock_catlog_id);
			$result1 = $stmt1->execute ();
			$stmt1->close ();
			if ($result1) {
				$this->conn->commit ();
				$response ["error"] = false;
				$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
			} else {
				$response ['error'] = true;
				$response ['msg'] = "DATA_NOT_UPDATED";
				$response ['msgDet'] = $this->conn->error;
			}
		} else {
			$this->conn->rollback ();
			
			$response ["error"] = true;
			$response ["message"] = "QUERY_EXCEPTION3";
		}
	} catch ( Exception $e ) {
		$this->conn->rollback ();
		$response ["error"] = true;
		$response ["message"] = $e->getMessage ();
	}
	return $response;
}	

/************** get customise catlog master details ****************/

public function getcsutomisestockcatalogdeatils(){
		$response = array ();
		
		$sql1 = "SELECT id, catlog_name, catlog_image, is_active FROM customise_catlog_master ;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "i" ,$stock_catlog_master_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id,$catlog_name,$catlog_image,$is_active);
				
				
					$i=0;
					while($result = $stmt1->fetch ()){
						
												
						$csutomise_stock_catalog[$i] = array(
							"id" => $id,
							"catlog_name" => $catlog_name,
							"catlog_image" => $catlog_image,
							"is_active" => $is_active,
							
						);
						$i++;
					}
				
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
    			$response ["csutomise_stock_catalog"] = $csutomise_stock_catalog;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["csutomise_stock_catalog"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
/************** get customise catlog master details ****************/

	public function getcsutomisestockcatalogdeatilsbyid($customise_stock_catlog_master_id){
		$response = array ();
		
		$sql1 = "SELECT id, catlog_name, catlog_image FROM customise_catlog_master where id=? ;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$customise_stock_catlog_master_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $catlog_name, $catlog_image);
				$result = $stmt1->fetch ();	
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["id"] = $id;
				$response ["catlog_name"] = $catlog_name;
				$response ["catlog_image"] = $catlog_image;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get customise catlog details by id ****************/

	public function getcsutomisestockcatalogdeatilbyid($customise_stock_catlog_id){
		$response = array ();
		
		$sql1 = "SELECT ccsc.id, ccsc.customise_catlog_master_id, ccm.catlog_name, ccsc.customise_catlog_sub_category_name, ccsc.sub_category_img_url, ccsc.pattern_no FROM customise_catlog_sub_category ccsc, customise_catlog_master ccm  where ccsc.id=? and ccm.id = ccsc.customise_catlog_master_id;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$customise_stock_catlog_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id, $customise_catlog_master_id, $catalog_name, $customise_catlog_sub_category_name, $sub_category_img_url, $pattern_no);
				$result = $stmt1->fetch ();	
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["id"] = $id;
				$response ["customise_catlog_master_id"] = $customise_catlog_master_id;
				$response ["catalog_name"] = $catalog_name;
				$response ["customise_catlog_sub_category_name"] = $customise_catlog_sub_category_name;
				$response ["sub_category_img_url"] = $sub_category_img_url;
				$response ["pattern_no"] = $pattern_no;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}

/***************** update is active customise stock catlog master id ************************/
	
	public function updateIsActiveByCustomiseStockCatlogMasterId($status,$customise_stock_catlog_master_id){	
		try {
			$this->conn->autocommit ( false );
			$response = array ();
			
									
			$sql1 = "UPDATE customise_catlog_master SET is_active=? where id = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ii" ,$status, $customise_stock_catlog_master_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION3";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	/***************** update is active customise stock catlog id ************************/
	
	public function updateIsActiveByCustomiseStockCatlogId($status,$customise_stock_catlog_id){	
		try {
			$this->conn->autocommit ( false );
			$response = array ();
			
									
			$sql1 = "UPDATE customise_catlog_sub_category SET is_active=? where id = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ii" ,$status, $customise_stock_catlog_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION3";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}

/*********************** insert customise stock catlog master **********************/

	public function insertCustomiseCatlogMasterDetails($catalog_name,$catalog_image,$created_by_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$this->conn->autocommit ( false );
			$response = array ();
			
				if (!is_dir("../catlog/".$catalog_name)) {
					mkdir("../catlog/".$catalog_name);
				}
				
				$savePath = "../backend/catlog/".$catalog_name."/";
				$new_savePath1 = "/backend/catlog/".$catalog_name."/";
				$imageName = $catalog_name;
				$catlog_path = $this->allKindOfFileUpload($catalog_image, $savePath, $imageName, $new_savePath1);
			
						
				$sql = "INSERT INTO `customise_catlog_master` (`catlog_name`, `catlog_image`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_data_time`) VALUES (?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "ssiississ" ,$catalog_name, $catlog_path["image_url"], $is_active, $created_by_id, $created_by_ip, $date, $created_by_id, $created_by_ip, $date);
					$result = $stmt->execute ();
					$catlog_id = $this->conn->insert_id;
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						
											
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			
			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}

	public function updateCustomiseStockCatlogMasterByStockCatlogMasterId($catalog_name,$catalog_image, $customise_stock_catlog_master_id){	
		try {
			$this->conn->autocommit ( false );
			$response = array ();
			
			if (!is_dir("../catlog/".$catalog_name)) {
				mkdir("../catlog/".$catalog_name);
			}
			
			$savePath = "../backend/catlog/".$catalog_name."/";
			$new_savePath1 = "/backend/catlog/".$catalog_name."/";
			$imageName = $catalog_name;
			$catlog_path = $this->allKindOfFileUpload($catalog_image, $savePath, $imageName, $new_savePath1);
									
			$sql1 = "UPDATE customise_catlog_master SET catlog_name=?, catlog_image=? where id = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ssi" ,$catalog_name, $catlog_path["image_url"], $customise_stock_catlog_master_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION3";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	
	public function updateCustomiseStockCatlogByStockCatlogId($catlog_master_name,$customise_catlog_master_id, $customise_catlog_sub_category_name, $sub_category_img_url, $pattern_no, $created_by_id, $customise_stock_catlog_id){	
		try {
			$this->conn->autocommit ( false );
			$response = array ();
			
			if (!is_dir("../catlog/".$catlog_master_name)) {
				mkdir("../catlog/".$catlog_master_name);
			}
			
			$savePath = "../backend/catlog/".$catlog_master_name."/";
			$new_savePath1 = "/backend/catlog/".$catlog_master_name."/";
			$imageName = $pattern_no;
			$catlog_path = $this->allKindOfFileUpload($sub_category_img_url, $savePath, $imageName, $new_savePath1);
									
			$sql1 = "UPDATE customise_catlog_sub_category SET customise_catlog_master_id=?, customise_catlog_sub_category_name=?, sub_category_img_url=?, pattern_no=?, modified_by_id=? where id = ?";
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "isssii" ,$customise_catlog_master_id, $customise_catlog_sub_category_name, $catlog_path["image_url"], $pattern_no, $created_by_id,$customise_stock_catlog_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION3";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}

public function getCustomiseStockCatlogDetails($customise_stock_catlog_master_id)
	{
		$response = array ();
		
		if($customise_stock_catlog_master_id == 0){
		
			$sql1 = "Select ccsc.id, ccsc.customise_catlog_master_id, ccm.catlog_name, ccsc.customise_catlog_sub_category_name, ccsc.sub_category_img_url, ccsc.pattern_no, ccsc.is_active from customise_catlog_sub_category ccsc, customise_catlog_master ccm where ccsc.customise_catlog_master_id = ccm.id;";
			
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				//$stmt1->bind_param ( "i" ,$stock_catlog_master_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id,$customise_catlog_master_id,$catlog_name,$customise_catlog_sub_category_name,$sub_category_img_url,$pattern_no,$is_active);
					
					
						$i=0;
						while($result = $stmt1->fetch ()){
							
													
							$stock_catalog[$i] = array(
								"id" => $id,
								"customise_catlog_master_id" => $customise_catlog_master_id,
								"catlog_name" => $catlog_name,
								"customise_catlog_sub_category_name" => $customise_catlog_sub_category_name,
								"sub_category_img_url" => $sub_category_img_url,
								"pattern_no" => $pattern_no,
								"is_active" => $is_active,
								
							);
							$i++;
						}
					
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["stock_catalog"] = $stock_catalog;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["stock_catalog"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
		}else{
			
			$sql1 = "Select ccsc.id, ccsc.customise_catlog_master_id, ccm.catlog_name, ccsc.customise_catlog_sub_category_name, ccsc.sub_category_img_url, ccsc.pattern_no, ccsc.is_active from customise_catlog_sub_category ccsc, customise_catlog_master ccm where ccsc.customise_catlog_master_id = ccm.id and ccsc.customise_catlog_master_id = ?;";
			
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$customise_stock_catlog_master_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id,$customise_catlog_master_id,$catlog_name,$customise_catlog_sub_category_name,$sub_category_img_url,$pattern_no,$is_active);
					
					
						$i=0;
						while($result = $stmt1->fetch ()){
							
													
							$stock_catalog[$i] = array(
								"id" => $id,
								"customise_catlog_master_id" => $customise_catlog_master_id,
								"catlog_name" => $catlog_name,
								"customise_catlog_sub_category_name" => $customise_catlog_sub_category_name,
								"sub_category_img_url" => $sub_category_img_url,
								"pattern_no" => $pattern_no,
								"is_active" => $is_active,
								
							);
							$i++;
						}
					
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["stock_catalog"] = $stock_catalog;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["stock_catalog"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
		}	
			
		
	}	
	
	
	public function insertCustomiseCatlogDetails($catlog_master_name,$customise_catlog_master_id,$customise_catlog_sub_category_name,$sub_category_img_url,$pattern_no,$created_by_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$this->conn->autocommit ( false );
			$response = array ();
			
				if (!is_dir("../catlog/".$catlog_master_name)) {
					mkdir("../catlog/".$catlog_master_name);
				}
				
				$savePath = "../backend/catlog/".$catlog_master_name."/";
				$new_savePath1 = "/backend/catlog/".$catlog_master_name."/";
				$imageName = $pattern_no;
				$catlog_path = $this->allKindOfFileUpload($sub_category_img_url, $savePath, $imageName, $new_savePath1);
			
						
				$sql = "INSERT INTO `customise_catlog_sub_category` (`customise_catlog_master_id`, `customise_catlog_sub_category_name`, `sub_category_img_url`, `pattern_no`, `is_active`, `created_by_id`, `created_by_ip`, `created_by_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "isssiississ" ,$customise_catlog_master_id, $customise_catlog_sub_category_name, $catlog_path["image_url"], $pattern_no, $is_active, $created_by_id, $created_by_ip, $date, $created_by_id, $created_by_ip, $date);
					$result = $stmt->execute ();
					//$catlog_id = $this->conn->insert_id;
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						
											
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			
			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	/************** get current month order details ****************/

	public function getcurrentmonthorder(){
		$response = array ();
		
		$current_year = date("Y");
		$current_month = date("m");
		
		$start_date = $current_year."-".$current_month."-01";
		$end_date = $current_year."-".$current_month."-31";
		
		$sql1 = "SELECT Total_sq_ft FROM `post_job_order` WHERE `created_date_time` >= ? AND `created_date_time` <= ?;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ss" ,$start_date,$end_date);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($Total_sq_ft);
				
				$i=0;
				$total_sqft = 0;
				while($result = $stmt1->fetch ()){
					
					$total_sqft = $total_sqft +	$Total_sq_ft;					
					
					$i++;
				}
			
			
			$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["Total_order"] = $num_rows1;
			$response ["Total_sq_ft"] = $total_sqft;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get current month completed order details ****************/

	public function getcurrentmonthcompletedorder(){
		$response = array ();
		
		$current_year = date("Y");
		$current_month = date("m");
		
		$start_date = $current_year."-".$current_month."-01";
		$end_date = $current_year."-".$current_month."-31";
		
		$sql1 = "SELECT Total_sq_ft FROM `post_job_order` WHERE `created_date_time` >= ? AND `created_date_time` <= ? and order_status_id = 7;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ss" ,$start_date,$end_date);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($Total_sq_ft);
				
				$i=0;
				$total_sqft = 0;
				while($result = $stmt1->fetch ()){
					
					$total_sqft = $total_sqft +	$Total_sq_ft;					
					
					$i++;
				}
			
			
			$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["Total_order"] = $num_rows1;
			$response ["Total_sq_ft"] = $total_sqft;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get current month top distributor details ****************/

	public function getcurrentmonthtopdistributer(){
		$response = array ();
		
		$current_year = date("Y");
		$current_month = date("m");
		
		$start_date = $current_year."-".$current_month."-01";
		$end_date = $current_year."-".$current_month."-31";
		
		//$sql1 = "SELECT order_id, media_sheet_type_id  FROM `post_job_order` WHERE `created_date_time` >= ? AND `created_date_time` <= ? GROUP BY media_sheet_type_id ORDER BY media_sheet_type_id DESC LIMIT 5;";
		$sql1 = "SELECT u.first_name, u.last_name, count(pjo.order_by_user_id), SUM(pjo.Total_sq_ft), pjo.order_by_user_id FROM post_job_order pjo, Users u WHERE u.id = pjo.order_by_user_id AND pjo.created_date_time >= ? AND pjo.created_date_time <= ? GROUP BY pjo.order_by_user_id ORDER BY count(pjo.order_by_user_id) DESC LIMIT 5;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ss" ,$start_date,$end_date);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($first_name, $last_name, $order_count, $total_sqft, $order_by_user_id);
				
				
				
				$i=0;
				while($result = $stmt1->fetch ()){
									
					$top_order[$i] = array(
						"name" => $first_name." ".$last_name,
						"total_order" => $order_count,
						"total_sqft" => $total_sqft,
						"user_id" => $order_by_user_id
						
					);
					
					$i++;
				}
			
			
			$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["top_order"] = $top_order;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	
	
	
	/************** get current month top paper details ****************/

	public function getcurrentmonthtopMedia(){
		$response = array ();
		
		$current_year = date("Y");
		$current_month = date("m");
		
		$start_date = $current_year."-".$current_month."-01";
		$end_date = $current_year."-".$current_month."-31";
		
		$sql1 = "SELECT count(pjo.paper_type_id), pjo.paper_type_id, m.sheet_name, p.paper_type_name FROM post_job_order pjo, paper_type p, media_sheet_type m WHERE  pjo.created_date_time >= ? AND pjo.created_date_time <= ? AND m.id = pjo.media_sheet_type_id AND p.id = pjo.paper_type_id GROUP BY pjo.paper_type_id ORDER BY count(pjo.paper_type_id) DESC LIMIT 5;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "ss" ,$start_date,$end_date);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($paper_count,$paper_type_id,$sheet_name,$paper_type_name);
								
				$i=0;
				while($result = $stmt1->fetch ()){
					//$order_total = $this->getOrdercountByUserId($order_by_user_id);
									
					$media_details[$i] = array(
					
						"media" => $sheet_name." - ".$paper_type_name
												
					);
					
					$i++;
				}
			
			
			$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["media_details"] = $media_details;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get notification by user id ****************/

	public function getnotificationbyuserid($user_id){
		$response = array ();
		
		
		//$sql1 = "SELECT notification_type, notification_title, notification_body, notification_doc_url, post_job_order_id, created_date_time FROM stc_notification WHERE user_id=? ORDER BY id DESC;";
		
		$sql1 = "SELECT sn.notification_type, sn.notification_title, sn.notification_body, sn.notification_doc_url, snum.post_job_order_id, snum.created_date_time FROM stc_notifications sn, stc_notification_user_mapping snum WHERE snum.user_id=? AND sn.id = snum.stc_notification_id ORDER BY snum.id DESC;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($notification_type,$notification_title,$notification_body, $notification_doc_url, $post_job_order_id,$created_date_time);
								
				$i=0;
				while($result = $stmt1->fetch ()){
					//$order_total = $this->getOrdercountByUserId($order_by_user_id);
					if($notification_doc_url == ""){
						$noti_doc_url = "/backend/img/logo.png";
					}else{
						$noti_doc_url = $notification_doc_url;
					}
									
					$notification_details[$i] = array(
					
						"notification_type" => $notification_type,
						"notification_title" => $notification_title,
						"notification_body" => $notification_body,
						"notification_doc_url" => $noti_doc_url,
						"post_job_order_id" => $post_job_order_id,
						"date_time" => $created_date_time
												
					);
					
					$i++;
				}
			
			
			$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["notification_details"] = $notification_details;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************** get all notification  ****************/

	public function getAllnotificationAdmin(){
		$response = array ();
		
		
		//$sql1 = "SELECT notification_type, notification_title, notification_body, notification_doc_url, post_job_order_id, created_date_time FROM stc_notification WHERE user_id=? ORDER BY id DESC;";
		
		$sql1 = "SELECT sn.notification_type, sn.notification_title, sn.notification_body, sn.notification_doc_url, snum.post_job_order_id, snum.created_date_time FROM stc_notifications sn, stc_notification_user_mapping snum WHERE sn.id = snum.stc_notification_id AND sn.notification_type = 'Notice_Details' ORDER BY snum.id DESC;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			//$stmt1->bind_param ( "i" ,$user_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($notification_type,$notification_title,$notification_body, $notification_doc_url, $post_job_order_id,$created_date_time);
								
				$i=0;
				while($result = $stmt1->fetch ()){
					//$order_total = $this->getOrdercountByUserId($order_by_user_id);
					if($notification_doc_url == ""){
						$noti_doc_url = "/backend/img/logo.png";
					}else{
						$noti_doc_url = $notification_doc_url;
					}
									
					$notification_details[$i] = array(
					
						"notification_type" => $notification_type,
						"notification_title" => $notification_title,
						"notification_body" => $notification_body,
						"notification_doc_url" => $noti_doc_url,
						"post_job_order_id" => $post_job_order_id,
						"date_time" => $created_date_time
												
					);
					
					$i++;
				}
			
			
			$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["notification_details"] = $notification_details;
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/************************ check approve image details ***********************/
public function checkapproveimagebyorderid($post_job_order_id,$upload_image_url,$description,$created_by_id) {
		$response = array ();
		$sql1 = "SELECT id FROM post_job_approved_image WHERE post_job_order_id=?;";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($id);
				$result = $stmt1->fetch ();
				
    			//$response ["error"] = true;
    			//$response ["msg"] ="DATA_FOUND";
				//$response ["msg"] = "Mobile number register with us.";
				
				$this -> getuserbyorderid($post_job_order_id);
				$imageapproveupdation = $this->updateapproveimagebyorderid($post_job_order_id,$upload_image_url,$description,$created_by_id);
				//$response ["error"] = false;
    			//$response ["msg"] = DATA_ADDED_SUCCESSFULLY;
				
    		
    		}else{
				
				$this -> getuserbyorderid($post_job_order_id);
				
    			$imageapproveinsertion = $this->insertapproveimagebyorserid($post_job_order_id,$upload_image_url,$description,$created_by_id);
				
								
				//$response ["error"] = false;
    			//$response ["msg"] = DATA_ADDED_SUCCESSFULLY;
				
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;

}


public function getuserbyorderid($post_job_order_id){
		$response = array ();
		
		
		$sql1 = "select u.id, u.parent_user_id, pjo.order_id From Users u ,post_job_order pjo where pjo.id = ? and pjo.order_by_user_id = u.id;";
		
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$post_job_order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id,$parent_user_id,$order_id);
								
				
				$result = $stmt1->fetch ();
				
			/*$response ["error"] = false;
			$response ["msg"] ="DATA_FOUND";
			$response ["user_id"] = $user_id;
			$response ["parent_user_id"] = $parent_user_id;*/
			$this -> UploadPreviewSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id);
				
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
public function UploadPreviewSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id)
{
		$response = array ();
		$push_notification_id_list = array();
		$obj = new notification ();
		
        //$sql1 = "select id,push_notification_id From Users where id in(?,?);";
		$sql1 = "select id,push_notification_id From Users where id in(?,?) or user_role_id = 1;";
		  
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "ii" ,$user_id,$parent_user_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($userid, $push_notification_registration_id);
				$i = 0;
				while ($result = $stmt1->fetch ()){
					$prof_name_mobile[$i] = array(
						"userid" => $userid,
						"push_notification_registration_id" => $push_notification_registration_id
						);
						$i++;
				}
				
				//$title = "STC WALLPAPER";
				//$body = "Upload Preview on Order Id - ".$order_id;
				$notice_id = 2;
				$getnotification = $this->getAllNoticeByNoticeId($notice_id);
				
				$title = $getnotification["notification_title"];
				$body = $getnotification["notification_body"];
				
				$k=0;
				for($j=0; $j<sizeof($prof_name_mobile); $j++){
					
					if($prof_name_mobile[$j]['push_notification_registration_id']!=""){
						$push_notification_id_list[$k] = $prof_name_mobile[$j]['push_notification_registration_id'];
						$k++;
					}
				}
				
				$k1=0;
				for($j1=0; $j1<sizeof($prof_name_mobile); $j1++){
					
					if($prof_name_mobile[$j1]['userid']!=""){
						$user_id_list[$k1] = $prof_name_mobile[$j1]['userid'];
						$k1++;
					}
				}
				//$this-> insertnotification($user_id_list,$title,$body,$user_id);	
				//$obj->sendPushNotification($push_notification_id_list,$title,$body);
				
				$order_detail = $this->getAllJobByOrderUserId($post_job_order_id);
				$preview = $this->getApproveImagePreviewDetails($post_job_order_id);
						
										
				$id = $order_detail["id"];
				$order_id = $order_detail["order_id"];
				$pattern_image_url = $order_detail["pattern_image_url"];
				$wall_size = $order_detail["wall_size"];
				$date_time = $order_detail["date_time"];
				$quantity = $order_detail["quantity"];
				$description = $order_detail["description"];
				$audio_url = $order_detail["audio_url"];
				$user_role_id = $order_detail["user_role_id"];
				$order_by_user_id = $order_detail["order_by_user_id"];
				$parent_user_id = $order_detail["parent_user_id"];
				$first_name = $order_detail["first_name"];
				$last_name = $order_detail["last_name"];
				$user_role_name = $order_detail["user_role_name"];
				$order_status_id = $order_detail["order_status_id"];
				$status_name = $order_detail["status_name"];
				$parent_user_role_name = $order_detail["parent_user_role_name"];
				$parent_first_name = $order_detail["parent_first_name"];
				$parent_last_name =  $order_detail["parent_last_name"];
				$pattern_no = $order_detail["pattern_no"];
				$media = $order_detail["media"];
				$button_show = $order_detail["button_show"];
				$cancel_job = $order_detail["cancel_job"];
				$support_image =  $order_detail["support_image"];
				$preview_image = $preview["upload_image_url"];
							
				//echo $pattern_image_url;	
				
				//$this-> insertnotification($user_id_list,$title,$body,$post_job_order_id,$user_id);
				$this-> insertnotificationJob($notice_id,$user_id_list,$post_job_order_id,$user_id);				
					
				$obj->sendPushNotificationForJob($push_notification_id_list,$title,$body,$order_id,$pattern_image_url,$order_by_user_id,$order_status_id,$status_name,$description,$audio_url,$pattern_no,$preview_image,$support_image);
			}else{
				$response ["error"] = false;
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
}

public function insertnotification($user_id_list,$notification_title,$notification_body,$post_job_order_id,$user_id) {
		
		
		
		try {
			
						
			for($i=0; $i<sizeof($user_id_list); $i++){
			
			
				$date = date ("Y-m-d H:i:s");
				$is_active = 1;
				$created_by_ip = "1.1.1.1";
				$notice_img = "";
				$notification_type = "Job_Details";
				$this->conn->autocommit ( false );
				$response = array ();
			
							
				$sql = "INSERT INTO `stc_notification` (`notification_type`, `notification_title`, `notification_body`, `notification_doc_url`, `post_job_order_id`, `user_id`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "ssssiiississ" ,$notification_type,$notification_title,$notification_body, $notice_img,$post_job_order_id,$user_id_list[$i],$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
					$result = $stmt->execute ();
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			}			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	
	public function insertnotificationJob($notice_id,$user_id_list,$post_job_order_id,$user_id) {
		
		try {
			
						
			for($i=0; $i<sizeof($user_id_list); $i++){
			
			
				$date = date ("Y-m-d H:i:s");
				$is_active = 1;
				$created_by_ip = "1.1.1.1";
				$notice_img = "";
				$notification_type = "Job_Details";
				$this->conn->autocommit ( false );
				$response = array ();
			
							
				$sql = "INSERT INTO `stc_notification_user_mapping` (`stc_notification_id`, `user_id`, `post_job_order_id`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "iiiississ" ,$notice_id,$user_id_list[$i],$post_job_order_id,$user_id,$created_by_ip,$date,$user_id,$created_by_ip,$date);
					$result = $stmt->execute ();
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			}			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}

public function insertsupportimage($job_id,$support_image_url,$order_by_user_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$this->conn->autocommit ( false );
			$response = array ();
			
				
				
				$sql = "INSERT INTO `post_job_support_image` (`post_job_order_id`, `image_url`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_date_time`) VALUES (?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "isiississ" ,$job_id,$support_image_url,$is_active,$order_by_user_id,$created_by_ip,$date,$order_by_user_id,$created_by_ip,$date);
					$result = $stmt->execute ();
					
					$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						//echo $post_job_order_id;			
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
						
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	public function insertapproveimagebyorserid($post_job_order_id,$upload_image_url,$description,$created_by_id) {
		try {
			
			//$support_image_list = array();
			$date = date ("Y-m-d H:i:s");
			$is_active = 1;
			$created_by_ip = "1.1.1.1";
			$approved_by_distributer = 0;
			$approved_by_dealer = 0;
			$this->conn->autocommit ( false );
			$response = array ();
			
								
				$savePath = "../backend/approveimage/";
				$new_savePath1 = "/backend/approveimage/";
				$imageName = "approve_".Date ( "YmdHis" );;
				$approve_path = $this->allKindOfFileUpload($upload_image_url, $savePath, $imageName, $new_savePath1);
			
						
				$sql = "INSERT INTO `post_job_approved_image` (`post_job_order_id`, `upload_image_url`, `description`, `approved_by_distributer`, `approved_by_dealer`, `is_active`, `created_by_id`, `created_by_ip`, `created_date_time`, `modified_by_id`, `modified_by_ip`, `modified_by_date_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
				if ($stmt = $this->conn->prepare ( $sql )) {
					$stmt->bind_param ( "issiiiississ" ,$post_job_order_id, $approve_path["image_url"], $description, $approved_by_distributer, $approved_by_dealer, $is_active, $created_by_id, $created_by_ip, $date, $created_by_id, $created_by_ip, $date);
					$result = $stmt->execute ();
					//$catlog_id = $this->conn->insert_id;
					
					//$stmt->close ();
					if ($result) {	
						$this->conn->commit ();
						//$imagesupportinsertion = $this->insertsupportimage($post_job_order_id,$approve_path["image_url"],$created_by_id);
											
						$response ["error"] = false;
						$response ["message"] = "DATA_ADDED_SUCCESSFULLY";
						//$this -> getuserbyorderid($post_job_order_id);	
											
					} else {
						$this->conn->rollback ();
						$response ["error"] = true;
						$response ["message"] = "DATA_ADDED_FAILED";
						$response ['msg'] = $stmt->error;
					}
				} else {
					$this->conn->rollback ();
					$response ["error"] = true;
					$response ["message"] = "QUERY_EXCEPTION";
				}
			
			
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	public function updateapproveimagebyorderid($post_job_order_id,$upload_image_url,$description,$created_by_id){	
		try {
			$this->conn->autocommit ( false );
			$response = array ();
			
			$date = date ("Y-m-d H:i:s");
			$created_by_ip = "1.1.1.1";
						
			$savePath = "../backend/approveimage/";
			$new_savePath1 = "/backend/approveimage/";
			$imageName = "approve_".Date ( "YmdHis" );;
			$approve_path = $this->allKindOfFileUpload($upload_image_url, $savePath, $imageName, $new_savePath1);
									
			$sql1 = "UPDATE post_job_approved_image SET upload_image_url=?, description=?, modified_by_id=?, modified_by_ip=?, modified_by_date_time=? where post_job_order_id	 = ?";
			
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "ssissi" ,$approve_path["image_url"], $description, $created_by_id, $created_by_ip, $date, $post_job_order_id);
				$result1 = $stmt1->execute ();
				$stmt1->close ();
				if ($result1) {
					$this->conn->commit ();
					//$imagesupportinsertion = $this->insertsupportimage($post_job_order_id,$approve_path["image_url"],$created_by_id);
					
					$response ["error"] = false;
					$response ["msg"] = "DATA_UPDATED_SUCCESSFULLY";
					//$this -> getuserbyorderid($post_job_order_id);	
				} else {
					$response ['error'] = true;
					$response ['msg'] = "DATA_NOT_UPDATED";
					$response ['msgDet'] = $this->conn->error;
				}
			} else {
				$this->conn->rollback ();
				
				$response ["error"] = true;
				$response ["message"] = "QUERY_EXCEPTION3";
			}
		} catch ( Exception $e ) {
			$this->conn->rollback ();
			$response ["error"] = true;
			$response ["message"] = $e->getMessage ();
		}
		return $response;
	}
	
	
	function getAllNoticeByNoticeId($notice_id){
		
		$response = array ();
			
			$sql1 = "SELECT id,notification_type,notification_title,notification_body FROM stc_notifications WHERE id = ? ;";
				
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$notice_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				if ($num_rows1 > 0) {
					
					$stmt1->bind_result($id, $notification_type, $notification_title, $notification_body);
					$result = $stmt1->fetch ();
					
														
					$response ["id"] = $id;
					$response ["notification_type"] = $notification_type;
					$response ["notification_title"] = $notification_title;
					$response ["notification_body"] = $notification_body;
										
					
				}else {	
					$response ["id"] = "";
					$response ["notification_type"] = "";
					$response ["notification_title"] = "";
					$response ["notification_body"] = "";
										
				}
				
				
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			return $response;
		
	}
	
	/******************** Get All status by order id ********************/
    public function getAllStatusDetailsByOrderId($order_id)
	{
		
		$response = array ();
		$sql1 = "SELECT s.status_name,os.description, u.first_name,u.last_name, ur.user_role_name,os.created_date_time FROM order_status os, status s, Users u, User_roles ur WHERE u.id = os.user_id and os.status_id = s.id and u.user_role_id = ur.id and os.order_id=? ORDER BY os.created_date_time DESC;";
			
		$stmt1 = $this->conn->prepare ( $sql1 );
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$order_id);
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			
			if ($num_rows1 > 0) {
				$stmt1->bind_result($status_name, $description,$first_name,$last_name,$user_role_name,$created_date_time);
				
				$i=0;
				while($result = $stmt1->fetch ()){
					
					$old_date = date($created_date_time);              
					$old_date_timestamp = strtotime($old_date);
					$new_date = date('d-m-Y H:i:s', $old_date_timestamp);   
					
					$status_list[$i] = array(
						"status_name" => $status_name,
						"description" => $description,
						"name" => $first_name.' '.$last_name.' ('.$user_role_name.')',
						"created_date_time" => $new_date
					);
					$i++;
				}
				
				$response ["error"] = false;
    			$response ["msg"] ="DATA_FOUND";
				$response ["status_list"] = $status_list;
					
    		}else{
    			$response ["error"] = true;
    			$response ["msg"] = "DATA_NOT_FOUND";
    			$response ["status_list"] = "";
    		}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}
	
	/******************** Get distributor details by state city id ********************/
    public function getDistributorDetailsByCityId($city_id)
	{
		
		$response = array ();
		
		if($city_id == 0){
			
			$sql1 = "SELECT id,first_name,last_name FROM Users WHERE user_role_id = 2 and is_active = 1;";
			
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				//$stmt1->bind_param ( "i" ,$city_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id, $first_name,$last_name);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						$user_list[$i] = array(
							"id" => $id,
							"name" => $first_name.' '.$last_name
						);
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["user_list"] = $user_list;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["user_list"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			
		}else{
			
			$sql1 = "SELECT id,first_name,last_name FROM Users WHERE user_role_id = 2 and is_active = 1 and city_id = ?;";
			
			$stmt1 = $this->conn->prepare ( $sql1 );
			if ($stmt1) {
				$stmt1->bind_param ( "i" ,$city_id);
				$stmt1->execute ();
				$stmt1->store_result ();
				$num_rows1 = $stmt1->num_rows;
				
				if ($num_rows1 > 0) {
					$stmt1->bind_result($id, $first_name,$last_name);
					
					$i=0;
					while($result = $stmt1->fetch ()){
						$user_list[$i] = array(
							"id" => $id,
							"name" => $first_name.' '.$last_name
						);
						$i++;
					}
					
					$response ["error"] = false;
					$response ["msg"] ="DATA_FOUND";
					$response ["user_list"] = $user_list;
						
				}else{
					$response ["error"] = true;
					$response ["msg"] = "DATA_NOT_FOUND";
					$response ["user_list"] = "";
				}
			}else {
				$response ["error"] = true;
				$response ["msg"] = "QUERY_EXCEPTION";
			}
			
		}
			
		
		return $response;
	}
	
	
	/*public function getUserDetailsByparentUserId($parent_id)
	{
		
		
		$response = array ();
		$sql1 = "Select urum.user_id, urum.user_role_id, u.first_name, u.last_name, ur.user_role_name From user_role_user_mapping urum, Users u, User_roles ur Where urum.is_active = 1 and urum.user_role_id = ur.id and urum.user_id = u.id and urum.parent_user_id = ?";
			
		$stmt1 = $this->conn->prepare ( $sql1 ); 
		if ($stmt1) {
			$stmt1->bind_param ( "i" ,$parent_id);	
			$stmt1->execute ();
			$stmt1->store_result ();
			$num_rows1 = $stmt1->num_rows;
			if ($num_rows1 > 0) {
				$stmt1->bind_result($user_id, $user_role_id,$first_name,$last_name,$user_role_name);
				$result = $stmt1->fetch ();
					
						$response ["error"] = false;
						$response ["msg"] = "parent User Details Found.";
						$response ["user_id"] = $user_id;
						$response ["user_role_id"] = $user_role_id;
						$response ["parent_post"] = $user_role_name;
						$response ["parent_first_name"] = $first_name;
						$response ["parent_last_name"] = $last_name;
									
			}else{
				$response ["error"] = true;
				$response ["msg"] = "No Data Found.";
			}
		}else {
			$response ["error"] = true;
			$response ["msg"] = "QUERY_EXCEPTION";
		}
		return $response;
	}*/
	
	
	/*public function sendMail11(){
		$response = array();
		
		$to = "tuhina@aminfotrix.com";
		$subject = "Donor mail to teacher";

		$message = "Hello TZK";
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <mysupplylistapp@gmail.com>' . "\r\n";
		//$headers .= 'Cc: support@rightsoftwarewala.com' . "\r\n";
		$response["mail"] = mail($to,$subject,$message,$headers);
		return $response;
	}*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>