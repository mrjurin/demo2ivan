<?php 
include("config.php");
if(isset($_POST['login']))
{
	$mobile_number = addslashes($_POST['mobile_number']);
	$password = addslashes($_POST['password']);
	$countrycode = addslashes($_POST['countrycode']);
	$user_role = addslashes($_POST['user_role']);
	$cm =	$countrycode.''.$mobile_number;
    // print_R($_POST);
	// die;
 	function updateStatus($session_id,$setup_session,$id){
		
 		$cm = $GLOBALS['cm'];
 		$password = $GLOBALS['password'];
 		// $conn = $GLOBALS['conn'];
 		$token = bin2hex(openssl_random_pseudo_bytes(64));
		if($setup_session=="y")
		$sql = "UPDATE users SET shop_open='1' WHERE mobile_number = '$cm' AND password = '$password'";
		else
		$sql = "UPDATE users SET WHERE mobile_number = '$cm' AND password = '$password'";	
		
		if(mysqli_query($conn, $sql)){
			return true;
		}else{
			return false;
		}
	}

	$error = "";
	
	if($mobile_number == "" )
	{
		$error .= "Mobile Number is not Valid.<br>";
	}
	$query1 = mysqli_query($conn, "SELECT * FROM users WHERE mobile_number='$cm' AND user_roles = '$user_role'");
	if($query1){
		$user_row1 = mysqli_num_rows($query1);
	}

	if($user_row1 == 0)
	{
			$error .= "Account not found, do you want to signup?.<br>";
	}   
	$user_row2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE mobile_number='$cm'AND password='$password'")); 
	if($user_row2 == 0)
		{
				$error .= "You have entered wrong password, please try again.<br>";
		}  

	//~ if(!($user_role === $user_row2['user_roles'])){
		
		//~ // echo $user_role . " <---> " . $user_row2['user_roles'];
		//~ $error .= "Invalid type of account.";

	//~ }

	if($user_row2['isLocked'] == "1" && $user_row2['verification_code'] != "" )
	{
		$error .= "User registration pending, Please go through the link sent to your mobile number?.<br>";
	}
	//~ if($count == 0)
	//~ {
		//~ $error .= "Account does not exists in our Database.<br>";
	//~ } 
	if(strlen($password) >= 15 || strlen($password) <= 5)
	{
		$error .= "Password must be between 6 and 15.<br>";
	}
	// echo $error;
	// die;
	if(empty($error))
	{
		$time=time();	
		$user_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_roles,id,isLocked,referral_id,name, mobile_number,setup_shop FROM users WHERE mobile_number='$cm' AND password='$password' AND user_roles = '$user_role'"));
		
		 $id = $user_row['id'];
		 $user_roles = $user_row['user_roles'];
		
		$referral_id = $user_row['referral_id'];
		$name = $user_row['name'];
		$mobile_number = $user_row['mobile_number'];
		$setup_session = $user_row['setup_shop'];
		// $_SESSION['setup_shop'] = $setup_session;
		
	     $_SESSION['login']=$id;
				$_SESSION['user_id']=$id;
			if($user_row){
				if($id)
				{
					
					if($user_row['isLocked'] == "0")
					{
						
						$_SESSION['login'] = $id;
						$_SESSION['user_id'] = $id;
						$_SESSION['setup_shop'] = $setup_shop;
						$_SESSION['referral_id'] = $referral_id;
						$_SESSION['name'] = $name;
						$_SESSION['login_user_role'] = $user_role;
						$_SESSION['mobile'] = $mobile_number;
						
					}
					else
					{
						$error .= "Sorry, the user account is blocked, please contact support.<br>";
						$_SESSION['e']=$error;
						header("location:login.php");
					}
				}
				else
				{
					$error .= "Authentication failed. You entered an incorrect username or password.<br>";
					$_SESSION['e']=$error;
					header("location:login.php");
				}
				//lucky
				if($setup_session=="y")
				$sql = "UPDATE users SET shop_open='1' WHERE mobile_number = '$cm' AND password = '$password'";
				else
				$sql = "UPDATE users SET WHERE mobile_number = '$cm' AND password = '$password'";	
				
				$insert="insert into stafflogin set staff_id='$id',logintime='$time',session_id='$session_id'";
				mysqli_query($conn,$sql);
				mysqli_query($conn,$q);
				mysqli_query($conn,$insert);
				if($user_roles==1)
		    	header("location:dashboard.php");
				else if($user_roles==2)
				header("location:dashboard.php");
			    else if($user_roles==5)

				header("location:dashboard.php");	

				header("location:dashboard.php");	 

			}else{
				$_SESSION['e']="An error occuried, please, try again later.";
				header("location:login.php");  	
				echo "An error occuried, please, try again later.";
			}
		
		
	}
	else
	{
		$_SESSION['e']=$error;
		header("location:login.php");  
	}
}  
?>