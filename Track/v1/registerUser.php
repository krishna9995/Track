<?php
	require_once '../includes/DbOperations.php';
	$response=array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['password']) and isset($_POST['confirmpassword']) and isset($_POST['email'])){
		$db=new DbOperations();
		$result=$db->createUser($_POST['firstname'],$_POST['lastname'],$_POST['password'],$_POST['confirmpassword'],$_POST['email']);
			if($result==1){
				$response['error']=false;
				$response['message']="User Registered Successfully";
			}elseif($result==2){
				$response['error']=true;
				$response['message']="entered password and confirm password are not same";
			}elseif($result==0){
				$response['error']=true;
				$response['message']="It seems you are already registered,Please choose a different email and username" ;
			}
		}else{
			$response['error']=true;
			$response['message']="Required fields are missing";
		}
	}else{
		$response['error']=true;
		$response['message']="Invalid Request";
	}
echo json_encode($response);