<?php
$fxrootpath = $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
echo $rootpath;
if(file_exists($fxrootpath)){
include_once($fxrootpath);
registerEmp();
exit();
}else{
	echo 'Set value $fxrootpath in file : pages/apply-employer-register.php ';
	exit();
}
function registerEmp(){
	$username = isset($_POST['employerUsername'])?$_POST['employerUsername']:false;
	$pass = isset($_POST['employerPassword'])?$_POST['employerPassword']:false;
	$repass = isset($_POST['employerConfirmPassword'])?$_POST['employerConfirmPassword']:false;
	$email = isset($_POST['employerEmail'])?$_POST['employerEmail']:false;
	$website = isset($_POST['employerContactWebsite'])?$_POST['employerContactWebsite']:'';
$userdata = array(
    'user_login'  =>  $username,
    'user_pass'   =>  $pass,
	'user_email'=>$email
);

$user_id = wp_insert_user( $userdata ) ;

//On success
if( !is_wp_error($user_id) ) {
 $secure_cookie = is_ssl();
 $secure_cookie = apply_filters('secure_signon_cookie', $secure_cookie, array());
 global $auth_secure_cookie;
 $auth_secure_cookie = $secure_cookie;
 wp_set_current_user($user_id);
 wp_set_auth_cookie($user_id, true, $secure_cookie);
 header('Location: '.get_site_url().'/edit-resume/');
}else{
	echo 'create user error :<a href="'.get_site_url().'/apply-employer-register/">Click for retry</a>';	
}
}
