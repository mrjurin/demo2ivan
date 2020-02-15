<?php 
session_start();
include("config.php");

// if(!isset($_SESSION['login']))
// {
	// header("location:login.php");
// }

if(isset($_GET['page']))
{
	$page = $_GET['page'];
}
else
{
	$page = 1;
}

$limit = 50;
$date = date('Y-m-d H:i:s');
$end_dt = $date;
$filter="";
// $m_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'"));
// print_R($m_data);
// die;
$loginset=$_SESSION['login'];
 $query="select scoin.*,users.user_roles,users.name,users.mobile_number from special_coin_wallet as scoin inner join users on users.id=scoin.user_id where scoin.coin_balance>0 and scoin.merchant_id='".$_SESSION['login']."'";
$qdata=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>
    <?php include("includes1/head.php"); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="/css/dropzone.css" type="text/css" /> 
	<style>
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
	.kType_table{
	    border: 1px #aeaeae solid !important;
	}
	.kType_table th, .kType_table td{
	    border: 1px #aeaeae solid !important;
	}
	.kType_table thead th{
	    border-bottom: 1px  #aeaeae solid !important;
	} 
	.kType_table tbody .complain{
	    color: red;
	    text-decoration: underline;
	}
	.sort{
	    margin-bottom: 10px;
	}
	/*kType_table tbody tr.k_normal{
	    background: #ececec;
	}*/
	#kType_table tbody tr.k_user{
	    background: #bcbcbc;
	}
	#kType_table tbody tr.k_merchant{
	    background: #dcdcdc;
	}
	.select2-container--bootstrap{
	    width: 175px;
	    display: inline-block !important;
	    margin-bottom: 10px;
	}
	@media  (max-width: 750px) and (min-width: 300px)  {
	    .select2-container--bootstrap{
	        width: 300px;
	    }
	}
	</style>
</head>

<body class="header-light sidebar-dark sidebar-expand pace-done">

    <div id="wrapper" class="wrapper">
        <!-- HEADER & TOP NAVIGATION -->
        <?php include("includes1/navbar.php"); ?>
        <!-- /.navbar -->
        <div class="content-wrapper">
            <!-- SIDEBAR -->
            <?php include("includes1/sidebar.php"); ?>
            <!-- /.site-sidebar -->
			<?php
			   $m_data=$profile_data;
			   $a_user_id=$profile_data['id'];
  			   $totalcoin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(amount) as total_bal FROM `tranfer` WHERE `type_method` = 'topup' and receiver_id='".$_SESSION['login']."'"))['total_bal'];
  			   $walletcoin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(coin_balance) as  total_bal FROM special_coin_wallet inner join users on users.id=special_coin_wallet.user_id WHERE merchant_id='".$_SESSION['login']."'"))['total_bal'];
  			   $coininmerchant = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(coin_balance) as  total_bal FROM special_coin_wallet inner join users on users.id=special_coin_wallet.user_id and users.user_roles='2' WHERE merchant_id='".$_SESSION['login']."'"))['total_bal'];
			
			  
			?>

            <main class="main-wrapper clearfix" style="min-height: 522px;">
                <div class="container-fluid" id="main-content" style="padding-top:25px">
					<h3><?php echo $m_data['special_coin_name']; ?> <?php echo $language['user_list']; ?></h3>
						<div class="row" style="font-weight:bold;">
						  <div class="col-md-4"><?php echo $language['total_coin_created']; ?>: <?php echo number_format($totalcoin,2);?></div>
						  <div class="col-md-4"><?php echo $language['coin_in_market']; ?>: <?php echo number_format($totalcoin-$m_data['balance_usd'],2);?></div>
						  <div class="col-md-4"><?php echo "Coin in merchant hand"; ?>: <?php echo number_format($coininmerchant,2);?></div>
						 <div class="col-md-4"><?php echo $language['coin_in_wallet']; ?>: <?php echo number_format($m_data['balance_usd'],2);?></div>
						 
						</div>
						<button  style="margin-bottom:2%;" class="btn btn-primary" onclick='transfer("<?php echo $_SESSION['login'];?>","")'>Transfer</button>
								
					<table class="table table-striped kType_table" id="kType_table">
					    <thead>
					        <tr>
					        <th>User ID</th>
								<th>Name</th>
								<th>Mobile</th>
								<th>User Type</th>
								
								<th>Cur. Balance</th>
								<th>Last Trascation</th>
								<th>Total Order Amount</th>
								<th>Action</th>
                		
					        </tr>
					    </thead>
					    <tbody>
					       <?php
					
							while($row = mysqli_fetch_assoc($qdata))
							{
								$l_user_id=$row['user_id'];
								$user_roles=$row['user_roles'];
								if($user_roles==2)
								$user_t="Merchant";
								else
								$user_t="Member";
								$merchant_id=$row['merchant_id'];
								$last=mysqli_fetch_assoc(mysqli_query($conn, "SELECT created_on FROM order_list WHERE user_id='$l_user_id' and merchant_id='$merchant_id' order by id desc limit 0,1"));
								$total_amount=mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(total_cart_amount) as total_amount FROM order_list WHERE user_id='$l_user_id' and merchant_id='$merchant_id'"))['total_amount'];
								if($last)
								{
									// print_R($last);
									$last_tras=$last['created_on'];
								}
								else
								{
									$last="--";
								}
								?>
								<tr>
									<td><?php echo $row['user_id']; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['mobile_number']; ?></td>
									<td><?php echo $user_t; ?></td>
								
									<td><?php echo number_format($row['coin_balance'],2); ?></td>
									<td><?php if($last){echo $last_tras;}else { echo $last;} ?></td>
									<td><?php echo number_format($total_amount,2);?></td>
									<td>
									<button class="btn btn-primary" onclick='transfer("<?php echo $_SESSION['login'];?>","<?php echo $row['mobile_number'];?>")'>Transfer</button>
									
									</td>
									
								</tr>
								<?php
								// die;
							}
							?>
					    </tbody>
					</table>
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
						<?php 
$old_phone = 'SELECT users.mobile_number FROM users inner join transfer on transfer.receiver_id = users.id where transfer.user_id = '.$_SESSION["login"];;
?>
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
							  	<input type="hidden" id="merchant_send" value="y"/>
							  	
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
									<h5 class="card-title user_name" id="user_name" style="text-align:center;"></h5>
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
									$all_wallet=mysqli_fetch_all($sub_rows,MYSQLI_ASSOC); if(count($all_wallet)>0){
										// print_R($all_wallet);
										
							foreach($all_wallet as $wal){ if($wal['coin_balance']){?>
									<option  s_merchant_id="<?php echo $wal['merchant_id'];?>" wallet_label="dynamic" merchant_no="<?php echo $wal['merchant_no']; ?>"  value="<?php  echo $wal['special_coin_name'];?>"><?php  echo $wal['special_coin_name']."- <b>".number_format($wal['coin_balance'],2)."</b>";?></option>  
							<?php }} } ?>
								</select>
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
				</div>
			</main>
        </div>
      
        <!-- /.widget-body badge -->
    </div>
    <!-- /.widget-bg -->

    <!-- /.content-wrapper -->
	<?php include("includes1/footer.php"); ?>
	<script type="text/javascript" src="/js/dropzone.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	



   <?php $user_name=$profile_data['name']; ?>   
   <script>
    function transfer(user_id,mobile_number) {
		
		$('#fund_user_id').val(user_id);
		$('#reciver_mobile_number').val(mobile_number);
		$('#transfer_to').val(mobile_number);
	    
		var user_name="<?php echo $user_name; ?>";
		// alert(usser_name);
		var db_fb_password="<?php echo $profile_data['fund_password']; ?>";
		var totalwallet="<?php echo $totalwallet; ?>";
		var u_role_id="<?php echo $u_role_id; ?>";
		// alert(user_name);
		if(u_role_id!=1)
			var totalwallet=1;
		$('#fund_user_id').val(user_id);
		if(totalwallet>0)
		{
			if(user_name)
			{
				var mobile_number = $('#transfer_to').val();
				// alert(number);
				if(mobile_number.length >= 9 && mobile_number.length <= 12){
					$('.error-block-for-mobile').hide();
					$.ajax({
								url :'functions.php',
								type:'POST',
								dataType : 'json',
								data:{mobile_number:mobile_number,method:"userdetail"},   
								success:function(response){
									var data = JSON.parse(JSON.stringify(response));
									if(data.status==true)
									{
										var user_name=data.data.name;
										// alert(user_name);
										if(user_name)
										{   
											$('.user_info').show();
											$('.user_name').html("Transfer to "+user_name);
										}
									}
									}		  
							});
				
				}
			}
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
	$('.cancel_transfer').click(function (){
		location.reload();
		$('#fund_wallet_input_modal').modal('hide');
		$('#fund_user_model').modal('hide');
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
	

	
</script>  

	<script>
	    $(document).ready(function(){
	        jQuery(".dropzone").dropzone({
                sending : function(file, xhr, formData){
                },
                success : function(file, response) {
                    $(".complain_image").val(file.name);
                    
                }
            });
            $('#kType_table').DataTable({
				"bSort": false,
				"pageLength":50,
				dom: 'Bfrtip',
				 buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
				});
				
	});
	  
	  
	</script>
		
	
</body>

</html>
