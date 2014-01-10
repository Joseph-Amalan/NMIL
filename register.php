<?php  
header('Content-type: application/json; charset=utf-8');
include_once('includes/config.php');
include_once('includes/classValidate.php');
$db = new DB();
$result = array();
switch($g_requestType){
	case 'new':
		$rName = $p_name;
		$rPass = $p_password;
		$rContact = $p_contact;
		$rEmail = $p_email;
		$validator = new validator();
		if($rName != ''){
			if($validator->isAlphaSpace($rName)){
				$result['Status'] = 'Success';
			}else{
				$result['Status'] = 'Error';
				$result['name'] = 'Invalid field';
			}
		}else{
			$result['Status'] = 'Error';
			$result['name'] = 'Name is a mandatory field';
		}
		
		if( $rPass != '' ){
			if($validator->checkLength( $rPass, '5,15' )){
				$result['Status'] = 'Success';
			}else{
				$result['Status'] = 'Error';
				$result['password'] = 'Invalid password';
			}
		}else{
			$result['Status'] = 'Error';
			$result['password'] = 'Password is a mandatory field';
		}
		
		if( $rEmail != '' ){
			if($validator->checkEmail( $rEmail )){
				$result['Status'] = 'Success';
			}else{
				$result['Status'] = 'Error';
				$result['email'] = 'Invalid email address';
			}
		}else{
			$result['Status'] = 'Error';
			$result['email'] = 'Email is a mandatory field';
		}
		
		if( $rContact != '' ){
			if($validator->isAlphaNumeric( $rContact )){
				$result['Status'] = 'Success';
			}else{
				$result['Status'] = 'Error';
				$result['contact'] = 'Invalid contact number';
			}
		}
	break;
	
}
$countResult = count($result);
if($countResult > 1){
	$result['Status'] = 'Error';
}
echo json_encode($result);
?>