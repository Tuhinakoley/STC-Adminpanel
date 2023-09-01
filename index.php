<?php
header ( "Access-Control-Allow-Origin: *" );
header ( "Access-Control-Allow-Credentials: 1" );
header ( 'content-type: application/json; charset=utf-8' );

require_once '../include/Config.php';
require_once '../include/utility.php';
require_once '../include/dbOperation.php';
require '.././libs/Slim/Slim.php';
require '../include/vendor/autoload.php';
use Mailgun\Mailgun;

\Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim ();


date_default_timezone_set ( 'Asia/Kolkata' );
//date_default_timezone_set('America/Los_Angeles');
global $date,$time;
$date = date ( "Y-m-d G:i:s" );
$date1 = date ( "m/d/Y" );
$time = date ( "G:i:s" );

$app->get ( '/serverdate', function () use ($app) {
	global $date,$time;
	echoRespnse ( 200, array (
			"date" => $date
	) );
} );

$app->get ( '/serverdates', function () use ($app) {
	global $date,$time,$date1;
	echoRespnse ( 200, array (
			"date" => $date1
	) );
} );


$app->get ( '/servertime', function () use ($app) {
	global $time;
	echoRespnse ( 200, array (
			"time" => $time
	) );
} );

// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/***** start **** dummy send notification ***** done by AMI-DEV003 *****/
$app->get ( '/dummySendNotification', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation ();
	$response = $obj->dummySendNotification();
	echoRespnse ( 201, $response );
} );

/***** start ***** GET STATE LIST **********/ 
$app->post ( '/get_state_list', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->getStateList();
	echoRespnse ( 201, $response );
} );
/***** start ***** GET DISTRICT LIST BY STATE ID **********/ 
$app->post ( '/get_district_list_by_state_id', function () use ($app) {
	
	$response = array ();
	
	$state_id = $app->request->post ( 'state_id' );
	
	$obj = new dbOperation();
	$response = $obj->getDistrictListByStateId($state_id);
	echoRespnse ( 201, $response );
} );
/***** start ***** GET CITY LIST **********/ 
$app->post ( '/get_city_list_by_district_id', function () use ($app) {
	
	$response = array ();
	
	$district_id = $app->request->post ( 'district_id' );
	
	$obj = new dbOperation();
	$response = $obj->getCityListByDistrictId($district_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_city_list_by_state_id', function () use ($app) {
	
	$response = array ();
	
	$state_id = $app->request->post ( 'state_id' );
	
	$obj = new dbOperation();
	$response = $obj->getCityListByStateId($state_id);
	echoRespnse ( 201, $response );
} );

/***** start ***** GET USER DETAILS BY USER ID **********/ 
$app->post ( '/get_user_details_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->GetUserDetailsByUserId($user_id);
	echoRespnse ( 201, $response );
} );

/***** start ***** GET USER DETAILS BY USER ID **********/ 
$app->post ( '/get_dealer_user_details_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->GetUserDetailsByUserIdAdmin($user_id);
	echoRespnse ( 201, $response );
} );

/***** start ***** GET DEALER DETAILS BY DISTRUBUTER ID **********/ 
$app->post ( '/get_dealer_details_by_distributer_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->GetDealerDetailsByDistributerIdAdmin($user_id);
	echoRespnse ( 201, $response );
} );

/***** start ***** UPDATE PASSWORD BY USER ID **********/ 
$app->post ( '/update_password_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$new_password = $app->request->post ( 'new_password' );
	$retype_password = $app->request->post ( 'retype_password' );
	$old_password = $app->request->post ( 'old_password' );
	$device_id = $app->request->post ( 'device_id' );
	$modify_by_ip = $app->request->post ( 'modify_by_ip' );
	$modify_by_id = $app->request->post ( 'modify_by_id' );
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	//$response = $obj->CheckPasswordByUserId($new_password,$retype_password,$device_id,$modify_by_ip,$modify_by_id,$user_id);
	//$response = $obj->updatePasswordById($new_password,$retype_password,$old_password,$device_id,$modify_by_ip,$modify_by_id,$user_id);
	$response = $obj->CheckPasswordByUserId($new_password,$retype_password,$old_password,$device_id,$modify_by_ip,$modify_by_id,$user_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/update_new_password_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$new_password = $app->request->post ( 'new_password' );
	$retype_password = $app->request->post ( 'retype_password' );
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	//$response = $obj->CheckPasswordByUserId($new_password,$retype_password,$device_id,$modify_by_ip,$modify_by_id,$user_id);
	//$response = $obj->updatePasswordById($new_password,$retype_password,$old_password,$device_id,$modify_by_ip,$modify_by_id,$user_id);
	$response = $obj->updateNewPasswordById($new_password,$retype_password,$user_id);
	echoRespnse ( 201, $response );
} );



/***** start ***** UPDATE PASSWORD BY USER ID **********/ 
$app->post ( '/update_password_by_user_id_admin', function () use ($app) {
	
	$response = array ();
	
	$new_password = $app->request->post ( 'new_password' );
	$retype_password = $app->request->post ( 'retype_password' );
	$old_password = $app->request->post ( 'old_password' );
	$modify_by_ip = $app->request->post ( 'modify_by_ip' );
	$modify_by_id = $app->request->post ( 'modify_by_id' );
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->CheckPasswordAdminByUserId($new_password,$retype_password,$old_password,$modify_by_ip,$modify_by_id,$user_id);
	echoRespnse ( 201, $response );
} );

/***** start ***** UPDATE PASSWORD BY USER ID **********/ 
$app->post ( '/update_forgot_password_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$new_password = $app->request->post ( 'new_password' );
	$retype_password = $app->request->post ( 'retype_password' );
	$old_password = $app->request->post ( 'old_password' );
	$modify_by_ip = $app->request->post ( 'modify_by_ip' );
	$mobile_no = $app->request->post ( 'mobile_no' );
	
	$obj = new dbOperation();
	$response = $obj->CheckForgotPasswordByUserId($new_password,$retype_password,$old_password,$modify_by_ip,$mobile_no);
	echoRespnse ( 201, $response );
} );

$app->post ( '/update_forgot_password_by_mobile', function () use ($app) {
	
	$response = array ();
	
	$new_password = $app->request->post ( 'new_password' );
	$retype_password = $app->request->post ( 'retype_password' );
	$modify_by_ip = $app->request->post ( 'modify_by_ip' );
	$mobile_no = $app->request->post ( 'mobile_no' );
	
	$obj = new dbOperation();
	$response = $obj->CheckForgotPasswordByMobile($new_password,$retype_password,$modify_by_ip,$mobile_no);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_loginInfoByMobileAndPassword', function () use ($app) {
	$response = array ();
	
	$mobile_number = $app->request->post ( 'mobile_number' );
	$password = $app->request->post ( 'password' );
	$device_id = $app->request->post ( 'device_id' );
	
	$obj = new dbOperation();
	$response = $obj->checkingMobileNoPassword($mobile_number,$password,$device_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_loginInfoByMobileAndPassword_Pushnotification', function () use ($app) {
	$response = array ();
	
	$mobile_number = $app->request->post ( 'mobile_number' );
	$password = $app->request->post ( 'password' );
	$device_id = $app->request->post ( 'device_id' );
	$push_notification_id = $app->request->post ( 'push_notification_id' );
	
	$obj = new dbOperation();
	$response = $obj->checkingMobileNoPassword_Pushnotification($mobile_number,$password,$device_id,$push_notification_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_User_Details_By_Device_Id', function () use ($app) {
	$response = array ();
	
	$device_id = $app->request->post ( 'device_id' );
	
	$obj = new dbOperation();
	$response = $obj->FetchDeviceIdByLoginId($device_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/update_profile_details_by_id', function () use ($app) {
	$response = array ();
	
	$first_name = $app->request->post ( 'first_name' );
	$last_name = $app->request->post ( 'last_name' );
	$companyName = $app->request->post ( 'companyName' );
	$office_address = $app->request->post ( 'office_address' );
	$city_id = $app->request->post ( 'city_id' );
	$state_id = $app->request->post ( 'state_id' );
	$email_id = $app->request->post ( 'email_id' );
	$pin_code = $app->request->post ( 'pin_code' );
	$profile_picture = $app->request->post ( 'profile_picture' );
	$company_logo = $app->request->post ( 'company_logo' );
	//$modify_by_ip = $app->request->post ( 'modify_by_ip' );
	$modify_by_id = $app->request->post ( 'modify_by_id' );
	$id = $app->request->post ( 'id' );
	
	$obj = new dbOperation();
	$response = $obj->updateProfileById($first_name, $last_name, $companyName, $office_address, $city_id, $state_id, $email_id, $pin_code, $profile_picture, $company_logo, $modify_by_id, $id);
	//$response = $obj->updateProfileById($first_name, $last_name, $companyName, $office_address, $pin_code, $modify_by_ip, $modify_by_id, $id);
	echoRespnse ( 201, $response );
} );



$app->post ( '/update_profile_details_by_id_admin', function () use ($app) {
	$response = array ();
	
	$first_name = $app->request->post ( 'first_name' );
	$last_name = $app->request->post ( 'last_name' );
	$companyName = $app->request->post ( 'companyName' );
	$office_address = $app->request->post ( 'office_address' );
	$city_id = $app->request->post ( 'city_id' );
	$state_id = $app->request->post ( 'state_id' );
	$email_id = $app->request->post ( 'email_id' );
	$pin_code = $app->request->post ( 'pin_code' );
	$profile_picture = $app->request->post ( 'profile_picture' );
	$company_logo = $app->request->post ( 'company_logo' );
	//$modify_by_ip = $app->request->post ( 'modify_by_ip' );
	$modify_by_id = $app->request->post ( 'modify_by_id' );
	$id = $app->request->post ( 'id' );
	
	$obj = new dbOperation();
	$response = $obj->AdminupdateProfileById($first_name, $last_name, $companyName, $office_address, $city_id, $state_id, $email_id, $pin_code, $profile_picture, $company_logo, $modify_by_id, $id);
	
	echoRespnse ( 201, $response );
} );

$app->post ( '/update_dealer_profile_details_by_id_admin', function () use ($app) {
	$response = array ();
	
	$first_name = $app->request->post ( 'first_name' );
	$last_name = $app->request->post ( 'last_name' );
	$companyName = $app->request->post ( 'companyName' );
	$office_address = $app->request->post ( 'office_address' );
	$city_id = $app->request->post ( 'city_id' );
	$state_id = $app->request->post ( 'state_id' );
	$email_id = $app->request->post ( 'email_id' );
	$pin_code = $app->request->post ( 'pin_code' );
	$profile_picture = $app->request->post ( 'profile_picture' );
	$company_logo = $app->request->post ( 'company_logo' );
	$parent_user_id = $app->request->post ( 'parent_user_id' );
	//$modify_by_ip = $app->request->post ( 'modify_by_ip' );
	$modify_by_id = $app->request->post ( 'modify_by_id' );
	$id = $app->request->post ( 'id' );
	
	$obj = new dbOperation();
	$response = $obj->updateDealerProfileById($first_name, $last_name, $companyName, $office_address, $city_id, $state_id, $email_id, $pin_code, $profile_picture, $company_logo, $parent_user_id, $modify_by_id, $id);
	
	echoRespnse ( 201, $response );
} );


/*SEND OTP TO GIVEN MOBILE NO*/
$app->post ( '/get_user_send_otp_by_mobile_no', function () use ($app) {
	
	$response = array ();
	
	$mobile_no = $app->request->post ( 'mobile_no' );
	
	$obj = new dbOperation ();
	$response = $obj->checkingMobileNoForOtpGenerate($mobile_no);
	echoRespnse ( 201, $response );
} );
/*START CHECKING OTP */
$app->post ( '/get_user_otp_check', function () use ($app) {
	
	$response = array ();
	
	$mobile_no = $app->request->post ( 'mobile_no' );
	$otp = $app->request->post ( 'otp' );
	
	$obj = new dbOperation ();
	$response = $obj->checkingOtpByMobileNo ($mobile_no,$otp);
	echoRespnse ( 201, $response );
} );

/********* Logout By user Id **************/

$app->post ( '/logout_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$id = $app->request->post ( 'id' );
	
	$obj = new dbOperation();
	$response = $obj->LogoutByUserId($id);
	echoRespnse ( 201, $response );
} );

$app->get ( '/get_catlog_details', function () use ($app) {
	
	$response = array ();
	
	
	$obj = new dbOperation();
	$response = $obj->fetchCatlogMaster();
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_sub_catlog_details_by_catlog_master_id', function () use ($app) {
	
	$response = array ();
	
	$catlog_master_id = $app->request->post ( 'catlog_master_id' );
	
	$obj = new dbOperation();
	$response = $obj->fetchSubCatlogByCatlogMasterId($catlog_master_id);
	echoRespnse ( 201, $response );
} );

/***** start ***** GET STATE LIST **********/ 
$app->get ( '/get_sheet_list', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->getMediaSheetList();
	echoRespnse ( 201, $response );
} );

/*********************** get catlog master details by name ******************************/

$app->post ( '/get_catlog_details_by_catlog_master_name', function () use ($app) {
	
	$response = array ();
	
	$name = $app->request->post ( 'name' );
	
	$obj = new dbOperation();
	$response = $obj->getCatlogDetailsByCatlogName($name);
	echoRespnse ( 201, $response );
} );

/*********************** get catlog sub category details by name ******************************/

$app->post ( '/get_catlog_subcategory_details_by_catlog_name', function () use ($app) {
	
	$response = array ();
	
	$name = $app->request->post ( 'name' );
	$catlog_master_id = $app->request->post ( 'catlog_master_id' );
	
	$obj = new dbOperation();
	$response = $obj->getSubCatlogDetailsBysubCatlogName($name, $catlog_master_id);
	echoRespnse ( 201, $response );
} );

/*********************** get customise catlog master details by name ******************************/

$app->get ( '/get_customise_catlog_details_by_catlog_master_name', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->getCustomiseCatlogDetails();
	echoRespnse ( 201, $response );
} );

/*********************** get customise catlog sub category details by name ******************************/

$app->post ( '/get_customise_catlog_subcategory_details_by_catlog_name', function () use ($app) {
	
	$response = array ();
	
	$catlog_master_id = $app->request->post ( 'catlog_master_id' );
	
	$obj = new dbOperation();
	$response = $obj->getCustomiseSubCatlogDetailsBysubCatlogName($catlog_master_id);
	echoRespnse ( 201, $response );
} );

/*********************** get stock city list ******************************/

$app->post ( '/get_stock_city_list', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->getStockCityList($user_id);
	echoRespnse ( 201, $response );
} );

$app->get ( '/get_all_stock_city_list', function () use ($app) {
	
	$response = array ();
	
	//$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->getAllStockCityList();
	echoRespnse ( 201, $response );
} );

/*********************** get media list ******************************/

$app->get ( '/get_media_list', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->getMediaList();
	echoRespnse ( 201, $response );
} );

/*********************** get paper list by media id ******************************/

$app->post ( '/get_paper_list_by_media_id', function () use ($app) {
	
	$response = array ();
	
	$media_sheet_type_id = $app->request->post ( 'media_sheet_type_id' );
	
	$obj = new dbOperation();
	$response = $obj->getPaperListbymediaId($media_sheet_type_id);
	echoRespnse ( 201, $response );
} );



/*********************** get stock details by pattern no ******************************/

$app->post ( '/get_stock_details_pattern_no', function () use ($app) {
	
	$response = array ();
	
	$pattern_no = $app->request->post ( 'pattern_no' );
	$city_id = $app->request->post ( 'city_id' );
	
	$obj = new dbOperation();
	$response = $obj->getStockDetailsBypattern($pattern_no,$city_id);
	echoRespnse ( 201, $response );
} );

/*********************** get stock details by pattern no ******************************/

$app->post ( '/get_stock_city_details_by_city_id', function () use ($app) {
	
	$response = array ();
	
	$city_id = $app->request->post ( 'city_id' );
	
	$obj = new dbOperation();
	$response = $obj->getStockCityByCityId($city_id);
	echoRespnse ( 201, $response );
} );

/*********************** get message details by order id ******************************/

$app->post ( '/get_message_list_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	
	$obj = new dbOperation();
	$response = $obj->getJobMessageByOrderId($order_id);
	echoRespnse ( 201, $response );
} );

/*********************** get stock details by id ******************************/

$app->post ( '/get_stock_catlog_by_id', function () use ($app) {
	
	$response = array ();
	
	$id = $app->request->post ( 'id' );
	
	$obj = new dbOperation();
	$response = $obj->getStockQuantityDetailsById($id);
	echoRespnse ( 201, $response );
} );

/*********************** get paper details by id ******************************/

$app->post ( '/get_paper_details_by_id', function () use ($app) {
	
	$response = array ();
	
	$id = $app->request->post ( 'id' );
	
	$obj = new dbOperation();
	$response = $obj->getPaperTypeList($id);
	echoRespnse ( 201, $response );
} );

/*********************** Insert order wise message ******************************/

$app->post ( '/insert_message_order_wise', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$user_id = $app->request->post ( 'user_id' );
	$message = $app->request->post ( 'message' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->insertMessageOrderWise($order_id,$user_id,$message,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** get All Order By User Id ******************************/

$app->post ( '/get_all_job_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->getAllJobByUserId($user_id);
	echoRespnse ( 201, $response );
} );

/*********************** get In Progress Order By User Id ******************************/

$app->post ( '/get_inprogress_job_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->getInProgressJobByUserId($user_id);
	echoRespnse ( 201, $response );
} );

/*********************** get Cancelled Order By User Id ******************************/

$app->post ( '/get_cancelled_job_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->getCancelledJobByUserId($user_id);
	echoRespnse ( 201, $response );
} );

/*********************** get Completed Order By User Id ******************************/

$app->post ( '/get_completed_job_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->getCompletedJobByUserId($user_id);
	echoRespnse ( 201, $response );
} );



/*********************** get Order Status By Order Id ******************************/

$app->post ( '/get_order_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	
	$obj = new dbOperation();
	$response = $obj->getOrderStatusByOrderId($order_id);
	echoRespnse ( 201, $response );
} );

/*********************** get Order latest Status By Order Id ******************************/

$app->post ( '/get_latest_order_status_by_post_job_order_id', function () use ($app) {
	
	$response = array ();
	
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
	
	$obj = new dbOperation();
	$response = $obj->getlatestOrderStatusByPostJobOrderId($post_job_order_id);
	echoRespnse ( 201, $response );
} );

/*********************** Cancel Order Status By Order Id ******************************/

$app->post ( '/get_user_role_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	
	$obj = new dbOperation();
	$response = $obj->getUserRoleDetailsByUserId($user_id);
	echoRespnse ( 201, $response );
} );

/*********************** Cancel Order Status By Order Id ******************************/

$app->post ( '/order_Cancelled_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$user_id = $app->request->post ( 'user_id' );
	$description = $app->request->post ( 'description' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->getUserRoleDetailsById($order_id,$user_id,$description,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** Approve Order Status By Order Id Distributor ******************************/

$app->post ( '/distributor_approve_order_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$user_id = $app->request->post ( 'user_id' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->InsertDistributorApproveStatusByOrderId($order_id,$user_id,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** get stock details by wallpaper type ******************************/

$app->post ( '/get_stock_details_all_wallpaper', function () use ($app) {
	
	$response = array ();
	
	$flag = $app->request->post ( 'flag' );
	
	$obj = new dbOperation();
	$response = $obj->getStockDetailsByAllWallpaperType($flag);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_stock_details_all_wallpaper_by_distributer', function () use ($app) {
	
	$response = array ();
	
	$flag = $app->request->post ( 'flag' );
	$city_id = $app->request->post ( 'city_id' );
	
	$obj = new dbOperation();
	$response = $obj->getStockDetailsByAllWallpaperTypeDistributor($flag,$city_id);
	echoRespnse ( 201, $response );
} );

$app->get ( '/get_stock_details_wallpaper_platinum', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->getStockDetailsByWallpaperTypePlatinum();
	echoRespnse ( 201, $response );
} );

$app->get ( '/get_customise_catlog_details_by_catlog_id', function () use ($app) {
	
	$response = array ();
	
	$catlog_sub_category_id = $app->request->post ( 'catlog_sub_category_id' );
	
	$obj = new dbOperation();
	$response = $obj->getCustomiseSubCatlogDetailsById($catlog_sub_category_id);
	echoRespnse ( 201, $response );
} );

$app->get ( '/get_stock_details_wallpaper_economical', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->getStockDetailsByWallpaperTypeEconomical();
	echoRespnse ( 201, $response );
} );
/*********************** Insert order wise message ******************************/

$app->post ( '/insert_post_job_order', function () use ($app) {
	
	$response = array ();
	
	//$order_id = $app->request->post ( 'order_id' );
	$catlog_sub_category_id = $app->request->post ( 'catlog_sub_category_id' );
	$pattern_image_url = $app->request->post ( 'pattern_image_url' );
	$width = $app->request->post ( 'width' );
	$height = $app->request->post ( 'height' );
	$quantity = $app->request->post ( 'quantity' );
	$description = $app->request->post ( 'description' );
	$audio_url = $app->request->post ( 'audio_url' );
	$media_sheet_type_id = $app->request->post ( 'media_sheet_type_id' );
	$paper_type_id = $app->request->post ( 'paper_type_id' );
	$order_by_user_id = $app->request->post ( 'order_by_user_id' );
	$support_image_list = $app->request->post ( 'support_image_list' );
	$img_flag = $app->request->post ( 'img_flag' );
	
	$obj = new dbOperation();
	$response = $obj->insertPostJobOrder($catlog_sub_category_id,$pattern_image_url,$width,$height,$quantity,$description,$audio_url,$media_sheet_type_id,$paper_type_id,$order_by_user_id,$support_image_list,$img_flag);
	echoRespnse ( 201, $response );
} );




/***********************************************************************************  ADMIN  ***********************************************************************************/

$app->post ( '/get_Admin_loginInfoByMobileAndPassword', function () use ($app) {
	$response = array ();
	
	$mobile_number = $app->request->post ( 'mobile_number' );
	$password = $app->request->post ( 'password' );
	
	$obj = new dbOperation();
	$response = $obj->checkingAdminMobileNoPassword($mobile_number,$password);
	echoRespnse ( 201, $response );
} );

/*********************** get All Order By User Id ******************************/

$app->post ( '/get_all_user_list_by_user_role_id', function () use ($app) {
	
	$response = array ();
	
	$user_role_id = $app->request->post ( 'user_role_id' );
	
	$obj = new dbOperation();
	$response = $obj->getListAllUserByUserRole($user_role_id);
	echoRespnse ( 201, $response );
} );


$app->post ( '/update_is_active_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$status = $app->request->post ( 'status' );
	$user_id = $app->request->post ( 'user_id' );
	
	$obj = new dbOperation();
	$response = $obj->updateIsActiveByUserId($status,$user_id);
	echoRespnse ( 201, $response );
} );

/*********************** get All Order By User Id ******************************/

$app->get ( '/get_all_job_by_admin', function () use ($app) {
	
	$response = array ();
	
	//$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	$response = $obj->getAllJobByAdmin();
	//$response = $obj->GetUserRoleByUserId($user_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_all_job_distributer', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	//$response = $obj->GetUserRoleByUserId($user_id);
	$response = $obj->getAllJobByDistributer($user_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_job_details_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
		
	$obj = new dbOperation();
	//$response = $obj->GetUserRoleByUserId($user_id);
	$response = $obj->getAllJobByOrderUserId($post_job_order_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_approve_image_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
		
	$obj = new dbOperation();
	//$response = $obj->GetUserRoleByUserId($user_id);
	$response = $obj->getApproveImagePreviewDetails($post_job_order_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_preview_remarks_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
		
	$obj = new dbOperation();
	$response = $obj->getPreviewRemarksDetailsOrderId($post_job_order_id);
	echoRespnse ( 201, $response );
} );


/*********************** get In Progress Order By User Id ******************************/

$app->get ( '/get_inprogress_job_by_admin', function () use ($app) {
	
	$response = array ();
	
	//$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	$response = $obj->getInptogressJobByAdmin();
	//$response = $obj->GetUserRoleByUserId($user_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_inprogress_job_distributer', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	//$response = $obj->GetUserRoleByUserId($user_id);
	$response = $obj->getInprogressJobByDistributer($user_id);
	echoRespnse ( 201, $response );
} );

/*********************** get Cancelled Order By User Id ******************************/

$app->get ( '/get_cancelled_job_by_admin', function () use ($app) {
	
	$response = array ();
	
	//$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	$response = $obj->getCancelledJobByAdmin();
	//$response = $obj->GetUserRoleByUserId($user_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_cancelled_job_distributer', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	//$response = $obj->GetUserRoleByUserId($user_id);
	$response = $obj->getCancelledJobByDistributer($user_id);
	echoRespnse ( 201, $response );
} );

/*********************** get Completed Order By User Id ******************************/

$app->get ( '/get_completed_job_by_admin', function () use ($app) {
	
	$response = array ();
	
	//$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	$response = $obj->getCompletedJobByAdmin();
	//$response = $obj->GetUserRoleByUserId($user_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_completed_job_distributer', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
		
	$obj = new dbOperation();
	//$response = $obj->GetUserRoleByUserId($user_id);
	$response = $obj->getCompletedJobByDistributer($user_id);
	echoRespnse ( 201, $response );
} );


/*************** get supported image by id *************/

$app->post ( '/get_supported_image_by_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
		
	$obj = new dbOperation();
	$response = $obj->getSupportImageByOrderId($order_id);
	echoRespnse ( 201, $response );
} );

/************************* insert user details *********************************/

$app->post ( '/insert_user_details', function () use ($app) {
	
	$response = array ();
	
	$first_name = $app->request->post ( 'first_name' );
	$last_name = $app->request->post ( 'last_name' );
	$companyName = $app->request->post ( 'companyName' );
	$profilePicture = $app->request->post ( 'profilePicture' );
	$company_logo = $app->request->post ( 'company_logo' );
	$email_id = $app->request->post ( 'email_id' );
	$mobile_number = $app->request->post ( 'mobile_number' );
	$password = $app->request->post ( 'password' );
	$office_address = $app->request->post ( 'office_address' );
	$city_id = $app->request->post ( 'city_id' );
	$state_id = $app->request->post ( 'state_id' );
	$pin_code = $app->request->post ( 'pin_code' );
	$user_role_id = $app->request->post ( 'user_role_id' );
	$parent_user_id = $app->request->post ( 'parent_user_id' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	
	$obj = new dbOperation();
	$response = $obj->checkUserDetails($first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$state_id,$pin_code,$user_role_id,$parent_user_id,$created_by_id);
	//$response = $obj->insertUserDetails($first_name,$last_name,$companyName,$profilePicture,$company_logo,$email_id,$mobile_number,$password,$office_address,$city_id,$state_id,$pin_code,$user_role_id,$parent_user_id,$created_by_id);
	echoRespnse ( 201, $response );
} );

/***************************** update is active by stock catlog master id **************************/

$app->post ( '/update_is_active_by_stock_catlog_master_id', function () use ($app) {
	
	$response = array ();
	
	$status = $app->request->post ( 'status' );
	$stock_catlog_master_id = $app->request->post ( 'stock_catlog_master_id' );
	
	$obj = new dbOperation();
	$response = $obj->updateIsActiveByStockCatlogMasterId($status,$stock_catlog_master_id);
	echoRespnse ( 201, $response );
} );

/************************* insert stock catlog master details *********************************/

$app->post ( '/insert_stock_catlog_master_details', function () use ($app) {
	
	$response = array ();
	
	$catalog_name = $app->request->post ( 'catalog_name' );
	$catalog_image = $app->request->post ( 'catalog_image' );
	$wallpaper_type = $app->request->post ( 'wallpaper_type' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	
	$obj = new dbOperation();
	$response = $obj->checkStockCatlogMasterDetails($catalog_name,$catalog_image,$wallpaper_type,$created_by_id);
	//$response = $obj->insertCatlogMasterDetails($catalog_name,$catalog_image,$wallpaper_type,$created_by_id);
	
	echoRespnse ( 201, $response );
} );

$app->post ( '/update_stock_catlog_master_details', function () use ($app) {
	
	$response = array ();
	
	$catalog_name = $app->request->post ( 'catalog_name' );
	$catalog_image = $app->request->post ( 'catalog_image' );
	$wallpaper_type = $app->request->post ( 'wallpaper_type' );
	$stock_catlog_master_id = $app->request->post ( 'stock_catlog_master_id' );
	
	$obj = new dbOperation();
	$response = $obj->updateStockCatlogMasterByStockCatlogMasterId($catalog_name,$catalog_image,$wallpaper_type, $stock_catlog_master_id);
	//$response = $obj->insertCatlogMasterDetails($catalog_name,$catalog_image,$wallpaper_type,$created_by_id);
	
	echoRespnse ( 201, $response );
} );

/*************** get stock catlog deatils by stock catlog master id *************/

$app->post ( '/get_stock_catlog_details_by_stock_catlog_master_id', function () use ($app) {
	
	$response = array ();
	
	$stock_catlog_master_id = $app->request->post ( 'stock_catlog_master_id' );
	$city_id = $app->request->post ( 'city_id' );
		
	$obj = new dbOperation();
	$response = $obj->getStockCatlogDetailsByStockCatlogMasterId($stock_catlog_master_id, $city_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_stock_catlog_master_details_by_id', function () use ($app) {
	
	$response = array ();
	
	$catlog_master_id = $app->request->post ( 'catlog_master_id' );
	//$city_id = $app->request->post ( 'city_id' );
		
	$obj = new dbOperation();
	$response = $obj->getStockCatlogMasterDetailsById($catlog_master_id);
	echoRespnse ( 201, $response );
} );

/***************************** update is active by stock catlog id **************************/

$app->post ( '/update_is_active_by_stock_catlog_id', function () use ($app) {
	
	$response = array ();
	
	$status = $app->request->post ( 'status' );
	$stock_catlog_id = $app->request->post ( 'stock_catlog_id' );
	
	$obj = new dbOperation();
	$response = $obj->updateIsActiveByStockCatlogId($status,$stock_catlog_id);
	echoRespnse ( 201, $response );
} );

/************************* insert stock catlog details *********************************/

$app->post ( '/insert_stock_catlog_details', function () use ($app) {
	
	$response = array ();
	
	$stock_catalog_master_id = $app->request->post ( 'stock_catalog_master_id' );
	$stock_catalog_master_name = $app->request->post ( 'stock_catalog_master_name' );
	$city_id = $app->request->post ( 'city_id' );
	$pattern_no = $app->request->post ( 'pattern_no' );
	$pattern = $app->request->post ( 'pattern' );
	$paper_type_id = $app->request->post ( 'paper_type_id' );
	$roll_size = $app->request->post ( 'roll_size' );
	$total_sq_ft = $app->request->post ( 'total_sq_ft' );
	$color = $app->request->post ( 'color' );
	$latest_qty = $app->request->post ( 'latest_qty' );
	$image_url = $app->request->post ( 'image_url' );
	$mock_image_url = $app->request->post ( 'mock_image_url' );
	$country_of_origin = $app->request->post ( 'country_of_origin' );
	$stock_status = $app->request->post ( 'stock_status' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	
	$obj = new dbOperation();
	$response = $obj->checkStockCatlogDetails($stock_catalog_master_id, $stock_catalog_master_name,$city_id,$pattern_no,$pattern,$paper_type_id,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$mock_image_url,$country_of_origin,$stock_status,$created_by_id);
	
	echoRespnse ( 201, $response );
} );

/*********** update stock catlog details *****************/

$app->post ( '/update_stock_catlog_details_by_id', function () use ($app) {
	
	$response = array ();
	
	$stock_catalog_master_id = $app->request->post ( 'stock_catalog_master_id' );
	$stock_catalog_master_name = $app->request->post ( 'stock_catalog_master_name' );
	$city_id = $app->request->post ( 'city_id' );
	$pattern_no = $app->request->post ( 'pattern_no' );
	$pattern = $app->request->post ( 'pattern' );
	$paper_type_id = $app->request->post ( 'paper_type_id' );
	$roll_size = $app->request->post ( 'roll_size' );
	$total_sq_ft = $app->request->post ( 'total_sq_ft' );
	$color = $app->request->post ( 'color' );
	$latest_qty = $app->request->post ( 'latest_qty' );
	$image_url = $app->request->post ( 'image_url' );
	$mock_image_url = $app->request->post ( 'mock_image_url' );
	$country_of_origin = $app->request->post ( 'country_of_origin' );
	$stock_status = $app->request->post ( 'stock_status' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	$stock_catlog_id = $app->request->post ( 'stock_catlog_id' );
	
	$obj = new dbOperation();
	$response = $obj->updateStockCatlogDetailsByStockCatlogId($stock_catalog_master_id,$stock_catalog_master_name,$city_id,$pattern_no,$pattern,$paper_type_id,$roll_size,$total_sq_ft,$color,$latest_qty,$image_url,$mock_image_url,$country_of_origin,$stock_status,$created_by_id,$stock_catlog_id);
	
	echoRespnse ( 201, $response );
} );

$app->get ( '/get_customise_stock_catlog_master_details', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->getcsutomisestockcatalogdeatils();
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_customise_stock_catlog_master_details_by_id', function () use ($app) {
	
	$response = array ();
	
	$customise_stock_catlog_master_id = $app->request->post ( 'customise_stock_catlog_master_id' );
	
	$obj = new dbOperation();
	$response = $obj->getcsutomisestockcatalogdeatilsbyid($customise_stock_catlog_master_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_customise_stock_catlog_details_by_id', function () use ($app) {
	
	$response = array ();
	
	$customise_stock_catlog_id = $app->request->post ( 'customise_stock_catlog_id' );
	
	$obj = new dbOperation();
	$response = $obj->getcsutomisestockcatalogdeatilbyid($customise_stock_catlog_id);
	echoRespnse ( 201, $response );
} );

/***************************** update is active by customise stock catlog master id **************************/

$app->post ( '/update_is_active_by_customise_stock_catlog_master_id', function () use ($app) {
	
	$response = array ();
	
	$status = $app->request->post ( 'status' );
	$customise_stock_catlog_master_id = $app->request->post ( 'customise_stock_catlog_master_id' );
	
	$obj = new dbOperation();
	$response = $obj->updateIsActiveByCustomiseStockCatlogMasterId($status,$customise_stock_catlog_master_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/update_is_active_by_customise_stock_catlog_id', function () use ($app) {
	
	$response = array ();
	
	$status = $app->request->post ( 'status' );
	$customise_stock_catlog_id = $app->request->post ( 'customise_stock_catlog_id' );
	
	$obj = new dbOperation();
	$response = $obj->updateIsActiveByCustomiseStockCatlogId($status,$customise_stock_catlog_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/insert_customise_stock_catlog_master_details', function () use ($app) {
	
	$response = array ();
	
	$catalog_name = $app->request->post ( 'catalog_name' );
	$catalog_image = $app->request->post ( 'catalog_image' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	
	$obj = new dbOperation();
	$response = $obj->insertCustomiseCatlogMasterDetails($catalog_name,$catalog_image,$created_by_id);
	
	echoRespnse ( 201, $response );
} );

$app->post ( '/insert_customise_stock_catlog_details', function () use ($app) {
	
	$response = array ();
	
	$catlog_master_name = $app->request->post ( 'catlog_master_name' );
	$customise_catlog_master_id = $app->request->post ( 'customise_catlog_master_id' );
	$customise_catlog_sub_category_name = $app->request->post ( 'customise_catlog_sub_category_name' );
	$sub_category_img_url = $app->request->post ( 'sub_category_img_url' );
	$pattern_no = $app->request->post ( 'pattern_no' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	
	$obj = new dbOperation();
	$response = $obj->insertCustomiseCatlogDetails($catlog_master_name,$customise_catlog_master_id,$customise_catlog_sub_category_name,$sub_category_img_url,$pattern_no,$created_by_id);
	
	echoRespnse ( 201, $response );
} );

$app->post ( '/update_customise_stock_catlog_details_by_stock_catlog_master_id', function () use ($app) {
	
	$response = array ();
	
	$catalog_name = $app->request->post ( 'catalog_name' );
	$catalog_image = $app->request->post ( 'catalog_image' );
	$customise_stock_catlog_master_id = $app->request->post ( 'customise_stock_catlog_master_id' );
		
	$obj = new dbOperation();
	$response = $obj->updateCustomiseStockCatlogMasterByStockCatlogMasterId($catalog_name,$catalog_image, $customise_stock_catlog_master_id);
	echoRespnse ( 201, $response );
} );


$app->post ( '/update_customise_stock_catlog_details_by_stock_catlog_id', function () use ($app) {
	
	$response = array ();
	
	$catlog_master_name = $app->request->post ( 'catlog_master_name' );
	$customise_catlog_master_id = $app->request->post ( 'customise_catlog_master_id' );
	$customise_catlog_sub_category_name = $app->request->post ( 'customise_catlog_sub_category_name' );
	$sub_category_img_url = $app->request->post ( 'sub_category_img_url' );
	$pattern_no = $app->request->post ( 'pattern_no' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	$customise_stock_catlog_id = $app->request->post ( 'customise_stock_catlog_id' );
		
	$obj = new dbOperation();
	$response = $obj->updateCustomiseStockCatlogByStockCatlogId($catlog_master_name,$customise_catlog_master_id, $customise_catlog_sub_category_name, $sub_category_img_url, $pattern_no, $created_by_id, $customise_stock_catlog_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/get_customises_stock_catlog_details_by_master_id', function () use ($app) {
	
	$response = array ();
	
	$customise_stock_catlog_master_id = $app->request->post ( 'customise_stock_catlog_master_id' );
	
	
	$obj = new dbOperation();
	$response = $obj->getCustomiseStockCatlogDetails($customise_stock_catlog_master_id);
	echoRespnse ( 201, $response );
} );

/************** get notification details by user id ***************/

$app->post ( '/get_notification_details_by_user_id', function () use ($app) {
	
	$response = array ();
	
	$user_id = $app->request->post ( 'user_id' );
	
	
	$obj = new dbOperation();
	$response = $obj->getnotificationbyuserid($user_id);
	echoRespnse ( 201, $response );
} );

/************** get all notification ***************/

$app->get ( '/get_all_notification_details', function () use ($app) {
	
	$response = array ();
	
	
	$obj = new dbOperation();
	$response = $obj->getAllnotificationAdmin();
	echoRespnse ( 201, $response );
} );

/*********** get current month order ******************/

$app->get ( '/get_current_month_order_details', function () use ($app) {
	
	$response = array ();
	
		
	$obj = new dbOperation();
	$response = $obj->getcurrentmonthorder();
	echoRespnse ( 201, $response );
} );

/*********** get current month completed order ******************/

$app->get ( '/get_current_month_completed_order_details', function () use ($app) {
	
	$response = array ();
	
		
	$obj = new dbOperation();
	$response = $obj->getcurrentmonthcompletedorder();
	echoRespnse ( 201, $response );
} );

/*********** get current month order distributer wise ******************/

$app->get ( '/get_current_month_order_distributer', function () use ($app) {
	
	$response = array ();
	
		
	$obj = new dbOperation();
	$response = $obj->getcurrentmonthtopdistributer();
	echoRespnse ( 201, $response );
} );

/*********** get current month order distributer wise ******************/

$app->get ( '/get_current_month_order_media', function () use ($app) {
	
	$response = array ();
	
		
	$obj = new dbOperation();
	$response = $obj->getcurrentmonthtopMedia();
	echoRespnse ( 201, $response );
} );



/*********************** Approved Preview Order Status By Order Id ******************************/

$app->post ( '/order_preview_approved_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$user_id = $app->request->post ( 'user_id' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->InsertApprovedPreviewStatusByOrderId($order_id,$user_id,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** Upload Preview Order Status By Order Id ******************************/

$app->post ( '/order_preview_upload_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$user_id = $app->request->post ( 'user_id' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->InsertUploadPreviewStatusByOrderId($order_id,$user_id,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** Sent printing Order Status By Order Id ******************************/

$app->post ( '/order_sent_printing_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$user_id = $app->request->post ( 'user_id' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->InsertPrintingStatusByOrderId($order_id,$user_id,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** Sent printing Order Status By Order Id ******************************/

$app->post ( '/order_packed_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$user_id = $app->request->post ( 'user_id' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->InsertPackedandPrintStatusByOrderId($order_id,$user_id,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** All Status By Order Id ******************************/

$app->post ( '/get_all_order_status_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
		
	$obj = new dbOperation();
	$response = $obj->getAllStatusDetailsByOrderId($order_id);
	echoRespnse ( 201, $response );
} );

$app->post ( '/order_packed_test', function () use ($app) {
	
	$response = array ();
	
	
	$user_id = $app->request->post ( 'user_id' );
	$parent_user_id = $app->request->post ( 'parent_user_id' );
	$order_id = $app->request->post ( 'order_id' );
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
	
	$obj = new dbOperation();
	$response = $obj->SentPackedSendNotification($user_id,$parent_user_id,$order_id,$post_job_order_id);
	echoRespnse ( 201, $response );
} );

/*********************** Order Accept Reject By Order Id ******************************/

$app->post ( '/order_accep_reject_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$order_id = $app->request->post ( 'order_id' );
	$status_id = $app->request->post ( 'status_id' );
	$description = $app->request->post ( 'description' );
	$user_id = $app->request->post ( 'user_id' );
	$created_by_ip = $app->request->post ( 'created_by_ip' );
	
	$obj = new dbOperation();
	$response = $obj->InsertAcceptRejectStatusByOrderId($order_id,$status_id,$description,$user_id,$created_by_ip);
	echoRespnse ( 201, $response );
} );

/*********************** Sent printing Order Status By Order Id ******************************/

$app->post ( '/insert_order_approve_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
	$upload_image_url = $app->request->post ( 'upload_image_url' );
	$description = $app->request->post ( 'description' );
	$created_by_id = $app->request->post ( 'created_by_id' );
	
	$obj = new dbOperation();
	$response = $obj->checkapproveimagebyorderid($post_job_order_id,$upload_image_url,$description,$created_by_id);
	//$response = $obj->insertapproveimagebyorserid($post_job_order_id,$upload_image_url,$created_by_id);
	echoRespnse ( 201, $response );
} );

/*********************** Sent printing Order Status By Order Id ******************************/

$app->post ( '/get_user_list_by_order_id', function () use ($app) {
	
	$response = array ();
	
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
	
	
	$obj = new dbOperation();
	$response = $obj->getuserbyorderid($post_job_order_id);
	
	echoRespnse ( 201, $response );
} );

/*********************** insert notification ****************************/

$app->post ( '/insert_job_notification', function () use ($app) {
	
	$response = array ();
	
	$user_id_list = $app->request->post ( 'user_id_list' );
	$notification_title = $app->request->post ( 'notification_title' );
	$notification_body = $app->request->post ( 'notification_body' );
	$post_job_order_id = $app->request->post ( 'post_job_order_id' );
	$user_id = $app->request->post ( 'user_id' );
	
	
	$obj = new dbOperation();
	$response = $obj->insertnotification($user_id_list,$notification_title,$notification_body,$post_job_order_id,$user_id);
	
	echoRespnse ( 201, $response );
} );

/*********************** Get Distributor Details by city id ******************************/

$app->post ( '/get_distributor_list_by_city_id', function () use ($app) {
	
	$response = array ();
	
	$city_id = $app->request->post ( 'city_id' );
	
	
	$obj = new dbOperation();
	$response = $obj->getDistributorDetailsByCityId($city_id);
	
	echoRespnse ( 201, $response );
} );

/**************************end***************************************/
$app->post ( '/file_upload_test', function () use ($app) {
	$response = array ();
	$file = $app->request->post ( 'file' );
	$obj = new dbOperation ();
	$response = $obj->uploadFileTest($file);
	//$response = $obj->uploadFileTest11($file);
	echoRespnse ( 201, $response );
} );


/*$app->get ( '/send_mail1', function () use ($app) {
	
	$response = array ();
	
	$obj = new dbOperation();
	$response = $obj->sendMail11();
	echoRespnse ( 201, $response );
} );*/

/***** end **** *****/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
	$error = false;
	$error_fields = "";
	$request_params = array ();
	$request_params = $_REQUEST;
	
	// Handling PUT request params
	
	if ($_SERVER ['REQUEST_METHOD'] == 'PUT') {
		$app = \Slim\Slim::getInstance ();
		parse_str ( $app->request ()->getBody (), $request_params );
	}
	
	foreach ( $required_fields as $field ) {
		if (! isset ( $request_params [$field] ) || strlen ( trim ( $request_params [$field] ) ) <= 0) {
			$error = true;
			$error_fields .= constant ( strtoupper ( $field ) ) . ', ';
		}
	}
	
	if ($error) {
		// Required field(s) are missing or empty
		
		// echo error json and stop the app
		
		$response = array ();
		$app = \Slim\Slim::getInstance ();
		$response ["error"] = true;
		$response ["message"] = substr ( $error_fields, 0, - 2 ) . ' required';
		echoRespnse ( 400, $response );
		$app->stop ();
	}
}

/**
 *
 * Echoing json response to client
 *
 *
 *
 * @param String $status_code
 *        	Http response code
 *        	
 * @param Int $response
 *        	Json response
 *        	
 */
function echoRespnse($status_code, $response) {
	$app = \Slim\Slim::getInstance ();
	
	// Http response code
	
	$app->status ( $status_code );
	
	// setting response content type to json
	
	$app->contentType ( 'application/json; charset=utf-8' );
	//$app->response->headers->set ( 'Access-Control-Allow-Origin', '*' );
	
	echo json_encode ( $response );
}

$app->run ();

?>