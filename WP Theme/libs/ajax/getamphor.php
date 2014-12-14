<?php
function checkfile(){
	header('Content-type: application/json');
$getarr = array('hasfile'=>'yes');
$jsonreturn = json_encode($getarr);
echo $jsonreturn;
exit();
}
$filename = get_template_directory() . '/libs/ajax';
$get_type = isset($_GET['type']) ? $_GET['type'] : 'none';
$amphurfile = $filename . '/amphur';
$districtfile = $filename . '/district';
chmod($amphurfile, 755);
chmod($districtfile, 755);
if ($get_type == 'provice'):
	$provice_id = $_REQUEST['proid'] ? $_REQUEST['proid'] : '1';
	$file = $amphurfile . '/' .$provice_id. '.json';  
	if(file_exists($file)):
		checkfile();
	else: 
		$amphurs = $wpdb->get_results("SELECT * FROM `amphur` where PROVINCE_ID = '{$provice_id}'");
		$getarr = NULL;
		foreach ($amphurs as $amphur):
			$getarr[] = $amphur;
		endforeach;
		header('Content-type: application/json');
		$jsonreturn = json_encode($getarr);
		file_put_contents($file,$jsonreturn);
		echo $jsonreturn;
		exit();
	endif;
elseif ($get_type == 'amphur'):
	$am_id = $_REQUEST['amid'] ? $_REQUEST['amid'] : '1';
	$file = $districtfile.'/'.$am_id. '.json';  
	if(file_exists($file)):
		checkfile();
	else:
    	$districts = $wpdb->get_results("SELECT * FROM `district` where AMPHUR_ID='{$am_id}'");
		$getarr = NULL;
		foreach ($districts as $district):
			$getarr[] = $district;
		endforeach;
		header('Content-type: application/json');
		$jsonreturn = json_encode($getarr);
		file_put_contents($file,$jsonreturn);
		echo $jsonreturn;
		exit();
	endif;
endif;
