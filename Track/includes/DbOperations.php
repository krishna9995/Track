<?php
	class DbOperations{
		private $con;
		function __construct(){
			require_once dirname(__FILE__).'/DbConnect.php';
			$db=new DbConnect();
			$this->con=$db->connect();
		}
		
		//registration function
		public function createUser($firstname,$lastname,$pass,$confirmpass,$email){
			if($this->isUserExist($email)){
				return 0;
			}else if($pass==$confirmpass){
				$password=md5($pass);
				$stmt = ($this->con)->prepare("INSERT INTO `track` (`id`, 				`firstname`,`lastname`,`password`,`confirmpassword`, `email`) VALUES ('', ?, ?, ?, ?, ?);");
				$stmt->bind_param("sssss",$firstname,$lastname,$pass,$confirmpass,$email);
				if($stmt->execute()){
				return 1;
				}					
			}else{
				return 2;
			}
		}
		private function isUserExist($email){
			$stmt=$this->con->prepare("SELECT id FROM `track` WHERE email=?");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
		//used for retreiving data from database
		public function getUserByUsername($email){
			$stmt=$this->con->prepare("SELECT * FROM `track` WHERE email=?");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
		//used for validating username and password in login page
		public function userLogin($email,$pass){
			$password=md5($pass);
			$stmt=$this->con->prepare("SELECT id FROM `track` WHERE email=? AND password=?");
			$stmt->bind_param("ss",$email,$pass);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
		//forgot password
		public function userForgot($username){
			$con=mysqli_connect('localhost', 'root', '', 'android');
			if(isset($_POST) & !empty($_POST)){
				$username=mysqli_real_escape_string($con,$username);
				$sql="SELECT *FROM users WHERE username='$username'";
				$res=mysqli_query($con,$sql);
				$count=mysqli_num_rows($res);
				ini_set("SMTP","smtp.nyu.edu");
				
				$r=mysqli_fetch_assoc($res);
				$password=$r['password'];
				$to=$r['email'];
				$subject="your recovery password";
				$message="Please use this password to login".$password;
				$headers="From:pannalaprasadnlg@gmail.com";
				if(mail($to, $subject, $message, $headers))
				return $count;
				
			}
		}
}