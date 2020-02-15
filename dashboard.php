<?php 
include("config.php");

if(!isset($_SESSION['login']))
{
	header("location:login.php");
}
if(!empty($_GET['l'])){
	// extract($_GET);
	$merchant_id=$_GET['merchant_id'];
	$l=$_GET['l'];
	$r_url="index.php?merchant_id=".$merchant_id."&l=".$l;
	header("Location:$r_url"); 		
}

if(isset($_GET['q']) && $_GET['q'] == 'getPartnersIds'){
	$mobile = "60" . $_GET['mobile'];
	$merchant_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id,user_roles FROM users WHERE mobile_number = '$mobile' ORDER BY id ASC"))['id'];
	if($merchant_id['user_roles'] == 1){
		die(json_encode('show_all'));
	}
	if(!$merchant_id)
		die(json_encode([]));
	// $sql = mysqli_query($conn, "SELECT user_id FROM unrecoginize_coin WHERE status=1 and merchant_id='$merchant_id' LIMIT 1");
	$sql = mysqli_query($conn, "select merchant_id from unrecoginize_coin inner join users on users.id=unrecoginize_coin.merchant_id where unrecoginize_coin.user_id='$merchant_id' and status=1 order by unrecoginize_coin.id desc");

	$result = [];
	while($row = mysqli_fetch_assoc($sql)){
		$result[] = $row['merchant_id'];
	}
	echo json_encode($result);
	die();
}
?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
<head>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<?php include("includes1/head.php"); ?>
	<style>
		/*.sidebar-toggle .ripple{     padding: 0 100px; }*/
		.well
		{
			min-height: 20px;
			padding: 19px;
			margin-bottom: 20px;
			background-color: #fff;
			border: 1px solid #e3e3e3;
			border-radius: 4px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
			box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
		}
		.wallet_h{
			font-size: 30px;
			color: #213669;
		}
		.spancls
		{
			font-weight:bold;
			color:red;
		}
	</style>

	<!-- Manifest -->
	<link rel="manifest" href="manifest.json">
</head>
<body class="header-light sidebar-dark sidebar-expand pace-done">
	<div id="wrapper" class="wrapper">
		<!-- HEADER & TOP NAVIGATION -->
		<?php include("includes1/navbar.php"); ?>
		<?php
		   // print_R($profile_data);
				// die;
			 $login_user_id=$_SESSION['login'];
			$lastt="select t.sender_id,t.amount,t.created_on,s.name as sender_name,s.mobile_number as sender_mobile,r.name as receiver_name,r.mobile_number as reciver_mobile,w.special_coin_name from tranfer as t inner join users as s on s.id=t.sender_id 
			inner join users as r on r.id=t.receiver_id inner join users as w on w.id=t.coin_merchant_id where (t.sender_id='$login_user_id' or t.receiver_id='$login_user_id') order by t.id desc limit 0,1";
            $lastq=mysqli_query($conn,$lastt);
			$l=mysqli_fetch_assoc($lastq);
			if($l)
			{
				if($l['sender_name']=='')
					$l['sender_name']=$l['sender_mobile'];
				if($l['receiver_name']=='')
					$l['receiver_name']=$l['reciver_mobile'];
				$date_label=$l['created_on'];
				$time_label=date('h:i A',$date_label)." on ".date('d/m/Y',$date_label);
				if($login_user_id==$l['sender_id'])
				{
					if($_SESSION['langfile']=="chinese")
					$s_msg="RM <span class='spancls'>".$l['amount']."</span> 的 <span class='spancls'>".$l['special_coin_name']."</span> 已经成功装入 <span class='spancls' style='color:#51d2b7;'>".$l['receiver_name']."</span> 于 ".$time_label;
					else
					$s_msg="RM <span class='spancls'>".$l['amount']."</span> of <span class='spancls'>".$l['special_coin_name']."</span> has been successfully transfer to <span class='spancls' style='color:#51d2b7;'>".$l['receiver_name']."</span> at ".$time_label;
				
				}
				else
				{
					if($_SESSION['langfile']=="chinese")
					// $s_msg="RM <span class='spancls'>".$l['amount']."</span> 的 <span class='spancls'>".$l['special_coin_name']."</span> 已经成功装入 <span class='spancls' style='color:#51d2b7;'>".$l['receiver_name']."</span> 于 ".$time_label;
				    $s_msg="RM <span class='spancls'>".$l['amount']."</span> 的 <span class='spancls'>".$l['special_coin_name']."</span> 已成功从 <span class='spancls' style='color:#51d2b7;'>".$l['receiver_name']."</span>在 ".$time_label." 加载";
					else
					$s_msg="RM <span class='spancls'>".$l['amount']."</span> of <span class='spancls'>".$l['special_coin_name']."</span> has been successfully Received From  <span class='spancls' style='color:#51d2b7;'>".$l['sender_name']."</span> at ".$time_label;   
				}
			}
			if($_SESSION['login'])
		//if($_COOKIE['PHPSESSID'])
			{
				$user_id=$_SESSION['login'];
				//$user_id=$_COOKIE['PHPSESSID'];
				
				$name=$profile_data['name'];
				$email=$profile_data['email'];
				$mobile_number=$profile_data['mobile_number'];
				$a_user_id=$profile_data['id'];
				$user_name=$profile_data['name'];   
				$a_mboile_no=$profile_data['mobile_number'];
				// file_put_contents("./sessioned-user.txt", $user_id);
				$moengage_unique_id=$profile_data['moengage_unique_id'];
				if($moengage_unique_id=='')
				{
					function generateRandomString($length = 4) {
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$charactersLength = strlen($characters);
						$randomString = '';
						for ($i = 0; $i < $length; $i++) {
							$randomString .= $characters[rand(0, $charactersLength - 1)];
						}
						return $randomString;
					}
					$unique_id=generateRandomString();
					$unique=$unique_id."mk2".$mobile_number;       
				}   
		?>
		<?php if($moengage_unique_id=='')
			{ include('mpush.php'); ?>   
			<link rel="manifest" href="manifest.json">
			<script type="text/javascript">
				(function(i,s,o,g,r,a,m,n){
					i['moengage_object']=r;t={}; q = function(f){return function(){(i['moengage_q']=i['moengage_q']||[]).push({f:f,a:arguments});};};
					f = ['track_event','add_user_attribute','add_first_name','add_last_name','add_email','add_mobile',
					'add_user_name','add_gender','add_birthday','destroy_session','add_unique_user_id','moe_events','call_web_push','track','location_type_attribute'];
					for(k in f){t[f[k]]=q(f[k]);}
						a=s.createElement(o);m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m);
					i['moe']=i['moe'] || function(){n=arguments[0];return t;}; a.onload=function(){if(n){i[r] = moe(n);}};
				})(window,document,'script','https://cdn.moengage.com/webpush/moe_webSdk.min.latest.js','Moengage');
				Moengage = moe({
					app_id:"HOT17PGXBYB243EJS2DSNW7U",
					debug_logs: 0
				});     
				<?php if($moengage_unique_id==''){
					mysqli_query($conn, "UPDATE users SET moengage_unique_id='".$unique."' WHERE id='".$_SESSION['login']."'");
					?>
					Moengage.add_user_attribute("koo_id", "<?php echo $user_id; ?>");
					<?php if($name){  ?> Moengage.add_first_name("<?php echo $name; ?>"); <?php } ?>
					<?php if($name){  ?> Moengage.add_user_name("<?php echo $name; ?>"); <?php } ?>
					<?php if($email){  ?> Moengage.add_email("<?php echo $email; ?>"); <?php } ?>
					<?php if($mobile_number){  ?> Moengage.add_user_name("<?php echo $mobile_number; ?>"); <?php } ?>
					Moengage.add_unique_user_id("<?php echo $unique; ?>"); // UNIQUE_ID is used to uniquely identify a user.       
				<?php } ?>  
			</script>   
			<?php
		}
	}

	?>
		<!-- /.navbar -->
		<div class="content-wrapper">
			<!-- SIDEBAR -->
			<?php include("includes1/sidebar.php"); ?>
			<!-- /.site-sidebar -->
			<?php
				// who accept the c&m coin_active
			if($profile_data['special_coin_name'] && $profile_data['user_roles']=="2")
			{
				$merchant_id=$profile_data['id'];
				$puery="select unrecoginize_coin.*,users.name as merchant_name,users.special_coin_name from unrecoginize_coin inner join users on users.id=unrecoginize_coin.merchant_id where unrecoginize_coin.merchant_id='$merchant_id' and status=1 order by unrecoginize_coin.id desc";
				$p_query = mysqli_query($conn,$puery);
				$ppartner=mysqli_num_rows($p_query);
			}
			?>
			<main class="main-wrapper clearfix" style="min-height: 522px;">
				<div class="container-fluid" id="main-content" style="padding-top:25px">
				<!--span class="btn btn-primary"  data-toggle="modal" data-target="#qrmodel"><?php echo $language['my_qr_code'];?></span!-->
				<span class="btn btn-primary last_tras"><?php echo $language['last_tras'];?></span>
				<button class="btn btn-primary" onclick='transfer("<?php echo $_SESSION['login'];?>")'><?php echo $language['transfer'];?></button>
				<a href="transaction_history.php" class="btn btn-primary"><?php echo $language['transaction_history']; ?></a>
				<?php if($balance['user_roles']==2){ ?>
				<button class="btn btn-primary"   onclick='topup("<?php echo $_SESSION['login'];?>")' id="top_up"><?php echo $language['top_up'];?></button>   
				 
				 <?php if($ppartner>0){ ?>
				 <a class="btn btn-primary" href="coinpartner.php?m_id=<?php echo $balance['id'];?>"><?php echo $language['accept_partner_list'];?></a>   
				 
				 <?php } ?>
				<?php } ?>      
				
					<h2 class="text-center wallet_h"><?php echo $language['wallet_balance'];?></h2>
					<div class="row">
					   <?php if($balance['balance_myr']){ ?>
						<div class="col-md-4 well text-center">
						<a href="transaction_history.php?coin_type=MYR">
							<h3 style="color:#51d2b7;">MYR</h3>
							<h4><?php if($balance['balance_myr']){echo number_format($balance['balance_myr'],2);} else{ echo "0.00";} ?></h4>
						    <img src="<?php echo $site_url."/img/touch.png";?>" style="width:125px;"/>
						</a>
						
						</div>
					   <?php }  if($balance['balance_usd']>0) { ?>  
						<div class="col-md-4 well text-center">
							<a href="transaction_history.php?coin_type=<?php if($_SESSION['login_user_role']==2){ echo $balance['special_coin_name'];}else { echo "CF";} ?>"><h3 style="color:#51d2b7;">
							<?php if($balance['user_roles']==2){ echo $balance['special_coin_name'];} ?>  
							</h3>
							
							<h4><?php if($balance['balance_usd']){echo number_format($balance['balance_usd'],2);} else{ echo "0.00";} ?></h4>
							<img src="<?php echo $site_url."/img/touch.png";?>" style="width:125px;"/>
							</a>
						
							
						</div>
					   <?php } if($balance['balance_inr']){ ?>
						<div class="col-md-4 well text-center">
						
						<a href="transaction_history.php?coin_type=INR">
							<h3 style="color:#51d2b7;">Koo Coin</h3>
							<h4><?php if($balance['balance_inr']){echo number_format($balance['balance_inr'],2);} else{ echo "0.00";} ?></h4>
						
							<img src="<?php echo $site_url."/img/touch.png";?>" style="width:125px;"/>
							</a>
						
						</div>
					   <?php }
						 
						      $sq="select special_coin_wallet.*,m.special_coin_name from special_coin_wallet  inner join users as m on

							  m.id=special_coin_wallet.merchant_id where user_id='$a_user_id' and special_coin_wallet.coin_balance>0 
							  and special_coin_wallet.coin_active='y'";
								$totalwallet=0;
							$sub_rows = mysqli_query($conn,$sq);
						  if(mysqli_num_rows($sub_rows)>0){
							 
							while ($swallet=mysqli_fetch_assoc($sub_rows)){
								// print_R($swallet);
								// die;
								$s_merchant_id=$swallet['merchant_id'];
								if($swallet['coin_balance']>0)
								$totalwallet++;
								$m_url="structure_merchant.php?merchant_id=".$swallet['merchant_id'];
							
								
							
					?>
						<div class="col-md-4 well text-center">
						<a href="<?php echo $m_url;?>">
						<h3 style="color:#51d2b7;">
						
						<?php echo $swallet['special_coin_name'];?></h3> 
						
						<h4><?php if($swallet['coin_balance']){echo number_format($swallet['coin_balance'],2);} else{ echo "0.00";} ?></h4>
						<img src="<?php echo $site_url."/img/touch.png";?>" style="width:125px;"/>
						</a>
						<?php if($s_merchant_id=="5062"){
							$defalut_plan="select count(plan.id) as total_count,u.created from membership_plan as plan inner join user_membership_plan as u on u.plan_id=plan.id where plan.user_id='$s_merchant_id' and plan.default_plan='y'
							and u.user_mobile='$a_mboile_no'";
							$defalutarray = mysqli_fetch_assoc(mysqli_query($conn,$defalut_plan));
							$defalutplan=$defalutarray['total_count'];
							if($defalutplan>0)
							{
								$created_date=$defalutarray['created'];
								$local_coin=mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(local_coin) as local_coin FROM local_coin_sync WHERE user_mobile='$b_mobile_number' and merchant_id='$s_merchant_id' and order_date>='$created_date'"))['local_coin'];
								$total_amount=mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(total_cart_amount) as total_amount FROM order_list WHERE user_id='$a_user_id' and merchant_id='$s_merchant_id' and created_on>='$created_date'"))['total_amount'];
							    $total_p=number_format(($local_coin+$total_amount),2); ?>
								<h3 style="font-size:16px;">M. Point: <?php echo $total_p; ?></h3>
							<?php }
						}?>
						</div>   
							<?php }}  ?>   
					</div>
					<h2 class="wallet_h text-center"><?php echo $language['notification'];?></h2> 
					<div class="row">
						<table class="table table-striped">
							<tr>   
								<th><?php echo $language['type'];?></th>
								<th><?php echo $language['notification'];?></th>
								<th><?php echo $language['arrived_on'];?></th>
								
							</tr>
							<?php
							$notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id=".$_SESSION['login']." AND readStatus='0' ORDER BY id DESC LIMIT 10");
							while($notification = mysqli_fetch_assoc($notifications))
							{
								?>
								<tr>
									<td><?php echo $notification['type']; ?></td>
									<td><?php echo $notification['notification']; ?></td>
									<td><?php echo date("d-m-Y h:i A",$notification['created_on']); ?></td>
								</tr>
								<?php
							}
							mysqli_query($conn, "UPDATE notifications SET readStatus='1' WHERE user_id=".$_SESSION['login']);
							?>
						</table>
						<?php
						if(mysqli_num_rows($notifications) == 0)
						{
							echo "<div style='text-align:center; color: red; font-size: 17px;'>".$language['no_more_notification']."</div>";
						}
						?>
					</div>
				</div>

<!--a href="transaction_history.php" class="btn btn-primary"><?php echo $language['transaction_history']; ?></a!-->
<div id="fund_user_model" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<p><?php echo $language['transfer']; ?> <span id="total_wallet_amount"></span></p>
				<button type="button" class="close"data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="text-align: left;padding:0px;">
				<div class="credentials-container">
					<div>
							<?php if($profile_data['name']==''){ ?>
							 <h5><?php echo "Please create your username, which is recognised by your friend"; ?></h5>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
							   <input type="text" autocomplete="tel" id="fund_username"  class="form-control" style="min-width:225px;" placeholder="Username" name="fund_username" required="" />
							</div>   
							<?php }  else {?>
							 <input type="hidden" autocomplete="tel" id="fund_username"  class="form-control" style="min-width:225px;" placeholder="Username" name="fund_username" value="<?php echo $profile_data['name'];?>" />
						    <?php } if($u_role_id==1){?>
							
							<input type="hidden" id="merchant_send" value="n"/>
							<?php }  else {?>
							  	<input type="hidden" id="merchant_send" value="n"/>
							  	     
							<?php } ?>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<span class="error-block-fund-username" for="fund_pass" style="display: none; color: red"></span>
							</div>
								<input type="hidden" id="fund_user_id"/>
								
							<?php if($profile_data['fund_password']==''){ ?>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<div class="input-group-prepend">
									<div class="input-group-text" style="background-color:#51D2B7;border-radius: 5px 0 0 5px;height: 100%;padding: 0 10px;display: grid;align-content: center;"><?php echo "Password"; ?></div>
								</div>
								<input type="password" autocomplete="tel"   oninput="this.value = this.value.replace(/[^0-9.]/g, '');"   maxlength="8"  id="new_fund_password" class="form-control" style="min-width:250px;" placeholder="Create Fund Password" name="new_fund_password" required />
								
									 
							</div> 
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<i  onclick="myFunction()" id="eye_slash" class="fa fa-eye-slash" aria-hidden="true"></i>
								<span onclick="myFunction()" id="eye_pass"> <?php echo $language['show_password']; ?> </span>   
							</div>
							<?php } else { ?>
							<input type="hidden" id="new_fund_password" value="<?php echo $profile_data['fund_password']; ?>"/>
							<?php } ?>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<span class="error-block-for-newfundpassword" style="display: none;color: red"></span>
							</div>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<input type="button" id="create_fund" class="btn btn-primary" value="<?php echo "Create"; ?>" style="width: 40%;" />
								<input type="button"  class="btn btn-primary cancel_transfer" value="<?php echo $language['cancel']; ?>" style="width: 40%; margin-left:20%;">
							</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="fund_wallet_model" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<p><?php echo $language['transfer']; ?> <span id="total_wallet_amount"></span></p>
				<button type="button" class="close"data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="text-align: left;">
				<div class="credentials-container">
					<h5><?php echo $language['enter_fund_password']; ?></h5>
					<div>
						<div class="input-group mb-2" style="margin-bottom:5px !important;">
							<input type="password" autocomplete="tel" id="fund_pass" class="fund_pass form-control" style="min-width:250px;" placeholder="" name="fund_pass" required="" />
							<input type="submit" id="confirm_fund" class="btn btn-primary" value="<?php echo $language['confirm']; ?>"/>  

						
						</div>
						<div class="input-group mb-2" style="margin-bottom:5px !important;">
							<i  onclick="myFunctionfund()" id="eye_slash_fund" class="fa fa-eye-slash" aria-hidden="true"></i>
							<span onclick="myFunctionfund()" id="eye_pass_fund"> <?php echo $language['show_password']; ?>  </span>
			 
							<span class="error-block-fund-pass" for="fund_pass" style="display: none; color: red"><?php echo $language['fund_password_wrong']; ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="topup_model" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->  
		<div class="modal-content">
			<div class="modal-header">
				<h3><?php echo $language['self_topup']; ?></h3>
				<button type="button" class="close"data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="text-align: left;padding:0px;">
				<div class="credentials-container">
					<h5 class="top_pass"><?php echo $language['enter_password']; ?></h5>
					<div>
						<div class="input-group mb-2 top_pass" style="margin-bottom:5px !important;">
							<input type="password" autocomplete="tel" id="topup_pass" class="form-control" style="min-width:250px;" placeholder="" name="topup_pass" required="" />
							<input type="submit" id="topup_submit" class="btn btn-primary" value="<?php echo $language['confirm'];?>"/>
						</div>
					
						<div class="input-group mb-2" style="margin-bottom:5px !important;">
							<span class="error-block-topup-pass" for="fund_pass" style="display: none; color: red"><?php echo $language['password_wrong']; ?></span>
						</div>
							<div class="input-group mb-2 top_pass_2" style="margin-bottom:5px !important;display:none;">
								<div class="input-group-prepend">
									<div class="input-group-text" style="background-color:#51D2B7;border-radius: 5px 0 0 5px;height: 100%;padding: 0 10px;display: grid;align-content: center;"><?php echo $language['amount']; ?></div>
								</div>
								<input type="text" maxlength="8" autocomplete="tel" id="topup_amount"  oninput="this.value = this.value.replace(/[^0-9.]/g, '');" class="topup_amount form-control" style="min-width:250px;" placeholder="Top up amount" name="topup_amount" required="" />
							</div>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<span class="error-block-for-topup-amount" style="display: none;color: red"><?php echo $language['please_trasfer_amount']; ?></span>
							</div>
							<div class="input-group mb-2 top_pass_2" style="margin-bottom:5px !important;display:none;">
								<input type="button" id="self_topup" class="btn btn-primary" value="<?php echo $language['confirm'];?>" style="width: 40%;" />
								<input type="button" id="cancel_topup" class="btn btn-primary" value="<?php echo $language['cancel'];?>" style="width: 40%; margin-left:20%;">
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
$old_phone = 'SELECT users.mobile_number FROM users inner join transfer on transfer.receiver_id = users.id where transfer.user_id = '.$_SESSION["login"];;
?>
<div id="fund_wallet_input_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<p><?php echo $language['trasfer_info']; ?><p>
				<button type="button" class="close"data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="text-align: left;">
				<div class="credentials-container">
					<div>
						<form action="dashboard.php" method="post" id="form-transfer">
							<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['login']; ?>" />
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<div class="input-group-prepend">
									<div class="input-group-text" style="background-color:#51D2B7;border-radius: 5px 0 0 5px;height: 100%;padding: 0 10px;display: grid;align-content: center;">Transfer To +60</div>
								</div>
								<input type="number" autocomplete="tel" id="transfer_to" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" maxlength="12" class="transfer_to form-control"  placeholder="mobile phone number" name="transfer_to" required="" />
							</div>
							<div class="card user_info" style="display:none;border:1px solid #51D2B7">
								
								  <div class="card-body">
									<h5 class="card-title user_name" id="user_name" style="text-align:center;color:red;"></h5>
								</div>
							</div>
							<h4 class="intro_user" style="display:none;font-size: 16px;color: red;">Number Look's New </h4>
							<div class="input-group mb-2 intro_user" style="display:none;margin-bottom:5px !important;">
								
								<div class="input-group-prepend">
									<div class="input-group-text" style="background-color:#51D2B7;border-radius: 5px 0 0 5px;height: 100%;padding: 0 10px;display: grid;align-content: center;"><?php echo "Reffer As"; ?></div>
								</div>
								<!-- <input type="text" id="transfer_wallet_type" class="transfer_wallet_type form-control" style="min-width:250px;" placeholder="Wallet Type" name="transfer_wallet_type" required="" /> -->
								<select id="reffer_as" class="form-control"  name="reffer_as" required="">
									<option value="member">Member</option>
									<option value="merchant">Merchant</option>
								</select>
							</div>
							
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<span class="error-block-for-mobile" style="display: none;color: red"><?php echo $language['invalid_mobile']; ?></span>
							</div>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<div class="input-group-prepend">
									<div class="input-group-text" style="background-color:#51D2B7;border-radius: 5px 0 0 5px;height: 100%;padding: 0 10px;display: grid;align-content: center;"><?php echo $language['amount']; ?></div>
								</div>  
								<input type="text" autocomplete="tel"  oninput="this.value = this.value.replace(/[^0-9.]/g, '');"   maxlength="8"  id="transfer_amount" class="transfer_amount form-control"  placeholder="amount of transfer" name="transfer_amount" required="" />
							</div>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<span class="error-block-for-amount" style="display: none;color: red"><?php echo $language['please_trasfer_amount']; ?></span>
							</div>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<div class="input-group-prepend">
									<div class="input-group-text" style="background-color:#51D2B7;border-radius: 5px 0 0 5px;height: 100%;padding: 0 10px;display: grid;align-content: center;"><?php echo $language['wallet']; ?></div>
								</div>
								<!-- <input type="text" id="transfer_wallet_type" class="transfer_wallet_type form-control" style="min-width:250px;" placeholder="Wallet Type" name="transfer_wallet_type" required="" /> -->
								<select id="transfer_wallet_type" class="transfer_wallet_type form-control"  name="transfer_wallet_type" required="">
									<option value=""><?php echo $language['select_wallet']; ?></option>
									<?php if($balance['balance_myr']) {?>
									<option value="MYR">MYR</option> <?php }  if(($balance['balance_usd']>0) && $profile_data['user_roles']=='2' && $profile_data['special_coin_name']) { ?>     
									<option s_merchant_id="<?php echo $balance['id'];?>" wallet_label="dynamic" merchant_no="<?php echo $balance['mobile_number']; ?>"  value="CF"><?php echo $balance['special_coin_name']."- <b>".number_format($profile_data['balance_usd'],2)."</b>";?></option> <?php } if($balance['balance_inr']) { ?>
									<option value="INR">KOO Coin</option><?php } 
									 $sq="select special_coin_wallet.*,m.special_coin_name,m.mobile_number as merchant_no from special_coin_wallet  inner join users as m on m.id=special_coin_wallet.merchant_id where user_id='$a_user_id'";
						  
									$sub_rows = mysqli_query($conn,$sq);
									$all_wallet=mysqli_fetch_all($sub_rows,MYSQLI_ASSOC); 
									if(count($all_wallet)>0){
										// print_R($all_wallet);
										
							foreach($all_wallet as $wal){ if($wal['coin_balance']){?>
									<option  s_merchant_id="<?php echo $wal['merchant_id'];?>" wallet_label="dynamic" merchant_no="<?php echo $wal['merchant_no']; ?>"  value="<?php  echo $wal['special_coin_name'];?>"><?php  echo $wal['special_coin_name']."- <b>".number_format($wal['coin_balance'],2)."</b>";?></option>  
							<?php }} } ?>
								</select>
							</div>

							<div class="input-group mb-2" style="display: none;">
								<select multiple id="transfer_wallet_type_multiple" style="width:100%">
								<?php 
								
								if($balance['balance_myr']) {?>
									<option value="MYR" data-amount="<?=number_format($balance['balance_myr'], 2) ?>">MYR</option> <?php }  if(($balance['balance_usd']>0) && $profile_data['user_roles']=='2' && $profile_data['special_coin_name']) { ?>     
									<option s_merchant_id="<?php echo $balance['id'];?>" data-amount="<?=number_format($balance['balance_usd'], 2) ?>" wallet_label="dynamic" merchant_no="<?php echo $balance['mobile_number']; ?>"  value="CF"><?php echo $balance['special_coin_name']."- <b>".number_format($profile_data['balance_usd'],2)."</b>";?></option> <?php } if($balance['balance_inr']) { ?>
									<option value="INR" data-amount="<?=number_format($balance['balance_inr'], 2) ?>">KOO Coin</option><?php } 
									if(count($all_wallet)>0){

									foreach($all_wallet as $wal){ 
										if($wal['coin_balance']){?>
										<option  s_merchant_id="<?php echo $wal['merchant_id'];?>" data-amount="<?=number_format($wal['coin_balance'],2) ?>" data-wallet-id="<?=$wal['id'] ?>" wallet_label="dynamic" merchant_no="<?php echo $wal['merchant_no']; ?>"  value="<?php  echo $wal['special_coin_name'];?>"><?php  echo $wal['special_coin_name']."- <b>".number_format($wal['coin_balance'],2)."</b>";?></option>  
								<?php } } }  ?>
							</select>
							</div>

							<div class="mb-2">
								<div class="row" id="wallet_amounts">
									<!-- It will be auto-filled -->
								</div>
							</div>

							<div class="mb-2">
								<input type="checkbox" name="multiple_wallet" id="multiple_wallet">
								<label for="multiple_wallet">Use more than one wallet</label>
							</div>
							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<div class="input-group-prepend">
									<div class="input-group-text" style="background-color:#51D2B7;border-radius: 5px 0 0 5px;height: 100%;padding: 0 10px;display: grid;align-content: center;"><?php echo "Remark"; ?></div>
								</div>  
								<textarea name="remark" id='remark' rows='4' cols='4'  class='form-control'></textarea>   
								
							</div>
							<div class="input-group mb-2" style="margin-bottom:20px !important;">
								<span class="error-block-for-wallet-type" style="display: none;color: red"><?php echo $language['plz_select_wallet']; ?></span>
							</div>

							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<span class="current-balance" style="display: none;color: #595d70;display: none;"><?php echo $language['cur_bal']; ?>:<b></b></span>
							</div>

							<div class="input-group mb-2" style="margin-bottom:5px !important;">
								<input type="button" id="confirm_transfer" class="btn btn-primary" value="<?php echo $language['confirm']; ?>" style="width: 40%;" />
								<input type="button"  class="btn btn-primary cancel_transfer"  value="<?php echo $language['cancel']; ?>" style="width: 40%; margin-left:20%;">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

			</main>
		</div>
		<!-- /.widget-body badge -->
	</div>
	<!-- /.widget-bg -->
	<input type="hidden" id="private" style="position: fixed;right: 0; bottom: 50px;">

    <!-- /.content-wrapper -->
	<?php include("includes1/footer.php"); ?>
	<div class=" modal fade" id="AlerModel" role="dialog" style="width:80%;min-height: 200px;text-align: center;margin:8%;">
        <div class="element-item modal-dialog modal-dialog-centered" style="position: absolute;top: 0;bottom: 0;left: 0;right: 0;display: grid;align-content: center;">
            <!-- Modal content-->
            <div class="element-item modal-content">
                <div class="element-item modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                            
                    
                              </div>   
                                    <p id="show_msg" style="font-size:22px;font-weight:bold;"><?php echo $language['the_product_added']; ?></p>
                    
                                </div>
                            </div>
    </div>
	
	<div class="modal fade" id="TModel" role="dialog" style="">  
   <div class="modal-dialog">
          

            <!-- Modal content-->
            <div class="modal-content">
              
                <div class="modal-header">
                    <button type="button" class="close final_done" data-dismiss="modal">&times;</button>
					
                </div>
                 
                    <div class="modal-body" style="padding-bottom:0px;">
					     <p id="show_msg_t" style="font-size:22px;font-weight:bold;"><?php echo $s_msg; ?></p>
                    
						
                    </div>
                    <div class="modal-footer" style="padding-bottom:2px;">
                        <div class="row" style="margin: 0;">
			 
						<div class="input-group mb-2" style="margin-bottom:5px !important;">
								
								<input type="button"  class="btn btn-primary final_done"  value="<?php echo "DONE"; ?>" style="width: 40%; margin-left:20%;">
							</div>
						 
						         
					   
						</div>
						  
						
                    </div>
                  
            </div>
        </div>
  </div>         
</body>
	<!-- <script>
		
		// It has been commented because it does not exist such file service-worker.js and it throws an error on console
	  if ('serviceWorker' in navigator) {
	    navigator.serviceWorker.register('/service-worker.js')
	      .then(function(reg){
	        console.log("Service Worker loaded correctly");
	      }).catch(function(err) {
	        console.log("Service Worker error: ", err)
	      });
	  }
	</script> -->
<script>
 $(document).ready(function(){
        var local_id=localStorage.getItem("login_live_id");
	    // alert(local_id);
		if(local_id=='' || local_id==null)
		{
			localStorage.setItem('login_live_id','<?php echo $_SESSION['login'];?>');
			localStorage.setItem('login_live_role_id','<?php echo $_SESSION['login_user_role'];?>');
			// localStorage.setItem('login_live_role_id','<?php echo "2";?>');
		}   

		$("#transfer_wallet_type_multiple").multipleSelect({
			selectAll: false
		});
		$("#transfer_wallet_type_multiple").multipleSelect("disable");

		$("#multiple_wallet").on("change", function(){
			var val = $(this).is(":checked");
			$(".transfer_amount").prop("disabled", val);
			if(val == true){
				$("#transfer_wallet_type").parent().hide();
				$("#transfer_wallet_type_multiple").parent().show();
				$("#wallet_amounts").show();
			}else{
				$("#transfer_wallet_type").parent().show();
				$("#wallet_amounts").hide();
				$("#transfer_wallet_type_multiple").parent().hide();
			}
		});

		$("#transfer_wallet_type_multiple").on("change", function(){
			var selected = $(this).find("option:selected");
			var values = $(this).val();
			var merchant_id = '';
			
			
			// Add the item from the list to the UI if it's not there already
			selected.each(function(i, val){
				let name = $(this).val();
				let merchant_id = $(this).attr("s_merchant_id");
				if($("#wallet_amounts div[data-name='" + name + "']").length == 0){
					var len = $("#wallet_amounts div[data-name='" + name + "']").length;
					$("#wallet_amounts").append(`
						<div class="col-md-12 form-group" data-name="${name}" data-amount="${$(this).attr("data-amount")}">
							<label for="wallet-${$(i)}">${name} <small>(${$(this).attr("data-amount")})</small></label>
							<input type="number" class="form-control" s_merchant_id="${merchant_id}" id="wallet-1" name="wallet_val">
						</div>
					`);
				}
			});

			// Remove a element from the UI if it's not in the list 
			$("#wallet_amounts > div.col-md-12").each(function(){
				// console.log($(this));
				if(!values.includes($(this).attr("data-name"))){
					$(this).remove();
				}
			});
			 
		});

		$(document).on("change", "input[name='wallet_val']", function(){
			var total = 0;
			if($(this).val() < 0){
				$(this).val(0);
			}
			$("input[name='wallet_val']").each(function(){
				total += parseFloat(($(this).val() == '') ? 0 : $(this).val());
			});
			// console.log("Total: " + total)
			$("#transfer_amount").val(total);
			// console.log("--------------")
		});

 });


	function transfer(user_id) {
		var user_name="<?php echo $user_name; ?>";
		// alert(user_name);
		var db_fb_password="<?php echo $profile_data['fund_password']; ?>";
		var totalwallet="<?php echo $totalwallet; ?>";
		var u_role_id="<?php echo $u_role_id; ?>";
		// alert(user_name);
		if(u_role_id!=1)
			var totalwallet=1;
		$('#fund_user_id').val(user_id);
		if(totalwallet>0)
		{
			if(user_name=='')
			{
				$('.error-block-fund-username').hide();
				$('#fund_user_model').modal('show');
			}   
			else
			{
				if(db_fb_password=='')
				{
				   $('#fund_user_model').modal('show');	
				}  
				else
				{
					if(totalwallet>0)
					{
						$('.error-block-fund-username').html('Username is Required');
						$('.error-block-fund-username').show();
						$('#fund_user_id').val(user_id);
						$('#fund_wallet_model').modal('show');
						// $('#fund_wallet_input_modal').modal('show');
					}
					
				}
				
				
			}
		}
		else
		{
			var msg="To Trasfer Atleast Has to be some Amount in wallet";
			$('#show_msg').html(msg);
			$('#AlerModel').modal('show'); 
			setTimeout(function(){ $("#AlerModel").modal("hide"); },2000);
		}
		
	}
	
	$('#create_fund').click(function () {
		//fund_engine();
		var fund_username=$('#fund_username').val();
		var new_fund_password=$('#new_fund_password').val();
		var user_id=$('#fund_user_id').val();
		// alert(user_id);
		if(fund_username!='')
		{
			$('.error-block-fund-username').hide();
			if(new_fund_password!='')
			{
				$.ajax({
					  
					  url: "functions.php",
					 type:'POST',
					  dataType : 'json',
					  data: {user_id:user_id,fund_username:fund_username,method:"savename",fund_password:new_fund_password},   
					  success:function(response){
							var btn = document.getElementById('create_fund');
							btn.disabled = true;
							$(this).removeClass("btn-primary").addClass("btn-default");
						  var data = JSON.parse(JSON.stringify(response));
						  if(data.status==true)
						  {
							   $('#fund_user_model').modal('hide');
							$('#fund_wallet_input_modal').modal('show');  
						  }
						  else
						  {
							alert(data.msg);
							btn.disabled = false;
							$('#').removeClass("btn-default").addClass("btn-primary"); 
						  }
						 
						}
				}); 	
			}
			else
			{
			   $('.error-block-for-newfundpassword').html('Fund Password is Required');
				$('.error-block-for-newfundpassword').show();	
			}
			
		}
		else
		{
			$('.error-block-fund-username').html('Username is Required');
			$('.error-block-fund-username').show();
		}
	});   
	$('#fund_pass').keyup(function (){
		// fund_engine();
	});
	$('.last_tras').click(function (){
		$('#TModel').modal('show');  
	});
	$('.cancel_transfer').click(function (){
		location.reload();
		$('#fund_wallet_input_modal').modal('hide');
		$('#fund_user_model').modal('hide');
	});
	$('#cancel_topup').click(function (){
		$('#topup_model').modal('hide');
	});
	$('.final_done').click(function (){
		location.reload(true);
	});
	$('#confirm_fund').click(function () {
		fund_engine();
	});
	function fund_engine(){
		if ($('#fund_pass').val() == '<?php echo $profile_data["fund_password"];?>') {
			$('.error-block-fund-pass').hide();
			// alert('success');
			$('#fund_wallet_model').modal('hide');
			$('#fund_wallet_input_modal').modal('show');
			// $('#fund_pass').val('');

		}else {
			$('.error-block-fund-pass').show();
		}
	}
	// top up process 
	function topup(user_id) {
	
		$('.error-block-topup-pass').hide();
		$('#top_user_id').val(user_id);
		$('#topup_model').modal('show');
	}
		function myFunction() {
		  var x = document.getElementById("new_fund_password");
		  if (x.type === "password") {
			x.type = "text";
				$("#eye_pass").html('Hide Password');
					 $('#eye_slash').removeClass( "fa-eye-slash" );
					$('#eye_slash').addClass( "fa-eye" );
					
		  } else {
			x.type = "password";
			 $("#eye_pass").html('Show Password');
			  $('#eye_slash').addClass( "fa-eye-slash" );
					$('#eye_slash').removeClass( "fa-eye" );
		  }
		}
	$('#topup_submit').click(function () {
		if ($('#topup_pass').val() == '<?php echo $profile_data["fund_password"];?>') {
			$('.top_pass').hide();
			$('.top_pass_2').show();
		}
		else {
			$('.error-block-topup-pass').show();
		}
		
	});
	// $('#transfer_wallet_type').on("change",function() {
	  // var wallet_label = $('#transfer_wallet_type option:selected').attr('wallet_label');
	  // if(wallet_label=="dynamic")
	  // {
		// var merchant_no = $('#transfer_wallet_type option:selected').attr('merchant_no');
		// $('#transfer_to').val(merchant_no);
	  // }
	  // else
	  // {
		  
	  // }
	// });
	$('#self_topup').click(function () {
		$('#self_topup', this).attr('disabled', 'disabled');      
		var topup_amount=$('#topup_amount').val();
		var top_user_id="<?php echo $_SESSION['login'];?>";
		// alert(top_user_id);
		if(topup_amount)
		{
			if(topup_amount>99000)
			{
				alert('You cannot do top up more than 99000$ at once');
			}
			else
			{
				var btn = document.getElementById('self_topup');
				btn.disabled = true;
				$(this).removeClass(" btn-primary").addClass("btn-default");
				$.ajax({
					  
					  url: "functions.php",
					 type:'POST',
					  dataType : 'json',
					  data: {topup_amount:topup_amount,user_id:top_user_id,method:"topupmerchant"},
					  success:function(response){
						  var data = JSON.parse(JSON.stringify(response));
						  if(data.status==true)
						  {
							  alert('Topup Successfully');
							location.reload();  
						  }
						  else
						  {
							  
							  alert(data.msg);
							  btn.disabled = false;
							$('#self_topup').removeClass("btn-default").addClass("btn-primary");
						  }
						 
						}
					  });
			}
		}
		else
		{
			$('.error-block-for-topup-amount').show();
		}
		
	});
	
</script>
<script>
	$('#private').click(function (){
		$.post('private.php', {'sender_id':"<?php echo $_SESSION['login'];?>"}, function(data) {
			console.log(data);
		});
	});
</script>  
</html>
