<?php  
header('Content-type: application/json; charset=utf-8');
include_once('includes/config.php');
$db = new DB();
$result = array();
switch($g_requestType){
	case 'in':
		if(($g_uname != '' && $g_upass != '') || ($p_uname != '' && $p_upass != '')){
			$userName = ($g_uname !='') ? $g_uname : $p_uname;
			$userPass = ($g_upass !='') ? $g_upass : $p_upass;
			if($userName != '' && $userPass != ''){
				$userPass = md5($userPass);
				$sql = "SELECT * from user_auth where name = '".$userName."' and password = '".$userPass."'";
        		$db->Execute($sql);        
        		$row = $db->GetRow();

				if(isset($row['id'])){
					$authKey = md5(time());
					$result['Status'] = 'Success';
					$result['AuthKey'] = $authKey;
				}else{
					$result['Status'] = 'Error';
					$result['ErrorMsg'] = 'Invalid Login';
				}
			}else{
				$result['Status'] = 'Error';
				$result['ErrorMsg'] = 'Invalid Credentials';
			}	
		}else{
			$result['Status'] = 'Error';
			$result['ErrorMsg'] = 'Invalid Parameters';
		}
	break;
	case 'out':
		if($g_uname != '' || $p_uname != ''){
			$userName = ($g_uname != '') ? $g_uname : $p_uname;
			$sql = "SELECT password from user_info where name = '".$userName."'";
        	$db->Execute($sql);        
        	$row = $db->GetRow();
			$result['Status'] = 'Success';
			$result['Password'] = $row['password'];
		} else {
			$result['Status'] = 'Error';
			$result['ErrorMsg'] = 'Invalid Parameters';
		}
	break;
	default:
		$result['Status'] = 'Error';
		$result['ErrorMsg'] = 'Invalid Access';
	break;
}
echo json_encode($result);
?>