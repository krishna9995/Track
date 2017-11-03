<html>
<head>
</head>
<body>
<center><br/><br/><br/><br/><br/>
<form action="dp.php" method="POST">
Your Email :<input type="text" name="email" size="30"/>
<input type="submit" name="submit" value="submit"/>
</form>
</center>
<?php
if(isset($_POST['email']))
{
	$_POST = array_map("strip_tags", $_POST);
	 if(count($erors)<1) {
    $conn = new mysqli('localhost', 'root', '', 'notebook');

    if (mysqli_connect_errno()) 
	{
      exit('Connect failed: '. mysqli_connect_error());
    }
    $adds['email'] = mysqli_real_escape_string($conn,$_POST['email']);
	
    $sql ="SELECT * FROM users WHERE email='". $adds['email']. "'  "; 
	
   $run_user = mysqli_query($conn, $sql);
                                                                                                  
   $check_user = mysqli_num_rows($run_user);
   
   if($check_user>0) 
   {
		
		$message = $adds['pass'];
		//send the password to the user_error
		$subject="Login information";
		$message="your password has been changed to $email_password";
		$from="From: imamsaidas@gmail.com";
		
		mail($email,$subject,$message,$from);
		echo "your new password has been emailed to you...";
	}
	else{
		echo "this email doesnt exist.";
	}
}
}
?>
</body>
</html>