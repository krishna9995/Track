<?php
	require_once '../includes/DbOperations.php';
	$response=array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['username'])){
			$db=new DbOperations();
			$result=$db->userForgot($_POST['username']);
			if($result==1){
				$response['error']=false;
				$response['message']="Email sent";
			}else{
				$response['error']=true;
				$response['message']="Invalid username";
			}
		}else{
			$response['error']=true;
			$response['message']="Required fields are missing";
		}
	}
echo json_encode($response);