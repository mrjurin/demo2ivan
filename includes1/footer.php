<!-- Scripts -->
<script src="./Dashboard_files/popper.min.js.download"></script>
<script src="./Dashboard_files/bootstrap.min.js.download"></script>
<script src="./Dashboard_files/jquery.magnific-popup.min.js.download"></script>
<script src="./Dashboard_files/mediaelementplayer.min.js.download"></script>
<script src="./Dashboard_files/metisMenu.min.js.download"></script>
<script src="./Dashboard_files/perfect-scrollbar.jquery.js.download"></script>
<script src="./Dashboard_files/sweetalert2.min.js.download"></script>
<script src="./Dashboard_files/jquery.counterup.min.js.download"></script>
<script src="./Dashboard_files/jquery.waypoints.min.js.download"></script>
<script src="./Dashboard_files/Chart.min.js.download"></script>
<script src="./Dashboard_files/Chart.bundle.min.js.download"></script>
<script src="./Dashboard_files/utils.js.download"></script>
<script src="./Dashboard_files/jquery.knob.min.js.download"></script>
<script src="./Dashboard_files/jquery.sparkline.min.js.download"></script>
<script src="./Dashboard_files/excanvas.js.download"></script>
<script src="./Dashboard_files/mithril.js.download"></script>
<script src="./Dashboard_files/widgets.js.download"></script>
<script src="./Dashboard_files/moment.min.js.download"></script>
<script src="./Dashboard_files/underscore-min.js.download"></script>
<script src="./Dashboard_files/clndr.min.js.download"></script>
<script src="./Dashboard_files/jquery-ui.min.js.download"></script>
<script src="./Dashboard_files/morris.min.js.download"></script>
<script src="./Dashboard_files/raphael.min.js.download"></script>
<script src="./Dashboard_files/daterangepicker.min.js.download"></script>
<script src="./Dashboard_files/slick.min.js.download"></script>
<script src="./Dashboard_files/theme.js.download"></script>
<script src="./Dashboard_files/isotop.min.js"></script>
<script src="./Dashboard_files/custom.js.download"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>

<script src="./js/custom.js"></script>


<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'QCJcJ4Qb9Q';var d=document;var w=window;function l(){ var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>

<!-- {/literal} END JIVOSITE CODE -->
	<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript' async='async' defer='defer'>
(function(){ var widget_id = 'QCJcJ4Qb9Q';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = 'https://code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<script type="text/javascript">
function myFunctionfund() {
  var x = document.getElementById("fund_pass");
  if (x.type === "password") {
    x.type = "text";
	    $("#eye_pass_fund").html('Hide Password');
			 $('#eye_slash_fund').removeClass( "fa-eye-slash" );
            $('#eye_slash_fund').addClass( "fa-eye" );
			
  } else {
    x.type = "password";   
	 $("#eye_pass_fund").html('Show Password');
	  $('#eye_slash_fund').addClass( "fa-eye-slash" );
            $('#eye_slash_fund').removeClass( "fa-eye" );
  }
}
$(document).ready(function(){
	
	 $("input[type='submit']").on("click", function(){
        $(this).removeClass(" btn-primary").addClass("btn-default");
		setTimeout(function() {
			
         $(this).removeClass("btn-default").addClass("btn-primary");
			}.bind(this), 5000);
	}); 
	$('#confirm_transfer').click(function(){
		var number=$('#transfer_to').val();
		var multiwallet = $("#multiple_wallet").is(":checked");
		if(multiwallet){
			var transfer_wallet_type 	= 	{};
			var wallet_merchant_id 		= 	{};
			$("#wallet_amounts input").each(function(){
				var name = $(this).parent().attr("data-name");
				var value = $(this).val();
				wallet_merchant_id[name] = $(this).attr("s_merchant_id");
				transfer_wallet_type[name] = $(this).val();
			});

		}else{
			var transfer_wallet_type=$('#transfer_wallet_type').val();
			var wallet_merchant_id=$("#transfer_wallet_type option:selected").attr("s_merchant_id");
		}
		var reffer_as=$('#reffer_as').val();
		// alert(wallet_merchant_id);
		var transfer_amount=$('#transfer_amount').val();
		// alert(reffer_as);   
		// alert(transfer_amount);
		var low_bal_label="<?php echo $language['low_bal'] ?>";
		// alert(low_bal_label);
		if (parseFloat(transfer_amount) >= 1.00)    
		{
			$('span.error-block-for-amount').hide();	
				// if(number.length >= 9 && number.length <= 14){
				if(number.length >= 9 && number.length <= 12 && (number[0] == 1 || number[0]==6)){
				$('.error-block-for-mobile').hide();
				if(transfer_amount)
				{
					$('span.error-block-for-amount').hide();
					if(transfer_wallet_type)
					{
						$('.error-block-for-wallet-type').hide();
						var btn = document.getElementById('confirm_transfer');
						// btn.disabled = true;     
						$(this).removeClass(" btn-primary").addClass("btn-default");
						btn.innerText = 'Posting...';
						$('.error-block-for-mobile').hide();
						$.post('transfer_module.php', {
							reff_as:reffer_as,
							wallet_merchant_id:wallet_merchant_id,
							transfer_amount:transfer_amount,
							wallet_type:transfer_wallet_type,
							mobile_number: number, 
							sender_id: "<?php echo $_SESSION['login'];?>",
							multi_wallet: multiwallet
						}, function (data){
						 var objresult = JSON.parse(data);
						 console.log(objresult);
						 $('.error-block-for-wallet').hide();
						if (objresult.status==true) {
							
							var data=objresult.data;
							// var balance_data = JSON.parse(data);
							var balance_data = data;  

							var postdata = {};
							postdata.created = new Date();
							postdata.created = postdata.created.getTime();
							postdata.sender_name = '<?php echo $profile_data["name"] ?>';
							postdata.sender_mobile = '<?php echo $profile_data["mobile_number"] ?>';
							postdata.sender_id = $('#sender_id').val();
							postdata.receiver_id = balance_data['id'];
							postdata.amount = $('#transfer_amount').val();
							postdata.remark = $('#remark').val();   
							postdata.merchant_send =$('#merchant_send').val();
							postdata.new_coin_trasfer =balance_data['new_coin_trasfer']; 
							// postdata.login_token =balance_data['login_token']; 
							var reciver_label=balance_data['reciver_label'];
							var time_label=balance_data['time_label'];
							var sender_label=balance_data['sender_label'];

							// postdata.wallet_type = $('#transfer_wallet_type').val();
							// postdata.wallet_merchant_id = wallet_merchant_id;

							postdata.wallet_type = transfer_wallet_type;
							postdata.wallet_merchant_id = wallet_merchant_id;

							postdata.multi_wallet = multiwallet;

							if (postdata.sender_id == postdata.receiver_id) {
							
								$('.error-block-for-mobile').html('Cant able to send amount to self no');
								
									$('.error-block-for-mobile').show();
									btn.disabled = false;
								// btn.innerText = 'Posting...';
								   $('#confirm_transfer').removeClass("btn-default").addClass("btn-primary");
							}
							else {
								$('.error-block-for-mobile').hide();
								if (postdata.amount == '') {
									$('.error-block-for-amount').show();
								}else {
									$('.error-block-for-amount').hide();
									if (postdata.wallet_type == '') {
										$('.error-block-for-wallet-type').show();
									} else {
										$('span.current-balance>b').html(parseFloat(balance_data[postdata.wallet_type]));
										$('span.current-balance').show();

										$('.error-block-for-wallet-type').hide();
										// alert(parseFloat(postdata.amount));
										// alert(parseFloat(balance_data[postdata.wallet_type]));
										if (parseFloat(postdata.amount) > parseFloat(balance_data[postdata.wallet_type])) {
											$('span.error-block-for-amount').html(low_bal_label);
											$('span.error-block-for-amount').show();
												btn.disabled = false;
											$('#confirm_transfer').removeClass("btn-default").addClass("btn-primary");
										}
										else {
											$('span.error-block-for-amount').html('Please type amount to transfer');
											$('span.error-block-for-amount').hide();
											// alert('success');
										    $.ajax({
													url :'transfer_module.php',
													type:'POST',
													dataType : 'json',
													data:postdata,   
													success:function(response){
														var data = JSON.parse(JSON.stringify(response));
														$('span.current-balance>b').html(parseFloat(balance_data[postdata.wallet_type]+" "+data.coin_name));  
														if(data.status==true)
														{
															
															// var msg="Fund Trasfer Successfully";
															var trasfer_lang="<?php echo $_SESSION['langfile']; ?>";  
															// alert(trasfer_lang);
															if(multiwallet){
																if(trasfer_lang=="chinese"){
																	var msg="RM <span class='spancls'>"+transfer_amount+"</span> 的  <span class='spancls'>"+sender_label+"</span> 已经成功装入 <span class='spancls' style='color:#51d2b7;'>"+reciver_label+"</span> 于 "+time_label;	
																	for(var key in transfer_wallet_type){
																		msg += "<br>" + key + " => " + transfer_wallet_type[key];
																	}
																}else{
																	var msg="RM <span class='spancls'>"+transfer_amount+"</span> of <span class='spancls'>"+sender_label+"</span> has been successfully transfer to <span class='spancls' style='color:#51d2b7;'>"+reciver_label+"</span> at "+time_label;
																	msg += "<table id='wallet_sent_table'>";
																	for(var key in transfer_wallet_type){
																		msg += "<tr><td>" + key + "</td><td>" + transfer_wallet_type[key] + "</td></tr>";
																	}
																	msg += "</table>";
																}
															}else{
																if(trasfer_lang=="chinese")
																	var msg="RM <span class='spancls'>"+transfer_amount+"</span> 的  <span class='spancls'>"+sender_label+"</span> 已经成功装入 <span class='spancls' style='color:#51d2b7;'>"+reciver_label+"</span> 于 "+time_label;	
																else
																	var msg="RM <span class='spancls'>"+transfer_amount+"</span> of <span class='spancls'>"+sender_label+"</span> has been successfully transfer to <span class='spancls' style='color:#51d2b7;'>"+reciver_label+"</span> at "+time_label;
															}
															
															$('#show_msg_t').html(msg);
															$('#fund_wallet_input_modal').modal('hide'); 
															$('#TModel').modal('show');
															// $('form#form-transfer').submit();   
															
															 
														  
														}
														else
														{
															btn.disabled = false;
															$('#confirm_transfer').removeClass("btn-default").addClass("btn-primary");
															// alert(data.msg);
															if($("#multiple_wallet").is(":checked")){
																$(this).removeClass(" btn-default").addClass("btn-primary");
																$('.error-block-for-wallet[data-wallet="' + data.coin_name + '"]').html(data.msg).show();
															}else{
																$(this).removeClass(" btn-default").addClass("btn-primary");
																$('.error-block-for-mobile').html(data.msg);
																$('.error-block-for-mobile').show();
															}
															// $('.error-block-for-wallet-type').html(data.msg);	
															// $('.error-block-for-wallet-type').show();	  
														}   
														}		  
												});
											
										}
									}
								}
							}
							
						}
						else {
							btn.disabled = false;
						// btn.innerText = 'Posting...';
							if($("#multiple_wallet").is(":checked")){
								$(this).removeClass(" btn-default").addClass("btn-primary");
								$('.error-block-for-wallet[data-wallet="' + objresult.coin_name + '"]').html(objresult.msg).show();
							}else{
								$(this).removeClass(" btn-default").addClass("btn-primary");
								$('.error-block-for-mobile').html(objresult.msg);
								$('.error-block-for-mobile').show();
							}
						}
					});
					}
					else
					{
						$('.error-block-for-wallet-type').show();
					}
				}
				else
				{
					$('span.error-block-for-amount').html('Enter Transfer Amount');
					$('span.error-block-for-amount').show();
				}
				
				
			}
			else
			{
				$('.error-block-for-mobile').html('Invalid Mobile Number');
				$('.error-block-for-mobile').show();
			}
		}
		else
		{
		   $('span.error-block-for-amount').html('Min Transfer  Amount is 1.00');
			$('span.error-block-for-amount').show();	
		}
		
	});
	$('.logout').click(function(e) {
		 e.preventDefault();
		var logout_type = $(this).attr('type');
		// alert(logout_type);   
		var local_id=localStorage.getItem("login_live_id");
		var data = {logout_type:logout_type,user_id:local_id};
		$.ajax({
					 url:"logout.php",
					 type:"post",
					 data:data,
					 dataType:'json',
					 success:function(result){
						var data = JSON.parse(JSON.stringify(result));
						if(data.status==true)
						{
						    localStorage.clear();
							localStorage.removeItem("login_live_id");
							localStorage.removeItem("login_live_role_id");   
							window.location = "login.php"
						}
						else
						{		 alert('Failed to logout');	}
						
					}
			});
	});  

	function is_in_array(value, array){
		for(var i = 0; i < array.length; i++){
			if(array[i] == value)
				return true;
			else
				return false;
		}
	}
	function makeid(length) {
		var result           = '';
		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ ) {
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}
		return result;
	}

	$("#transfer_to").focusout(function(){
		var number = $('#transfer_to').val();
		// alert(number.length);
		// if(number.length >= 9 && number.length <= 14){
		if(number.length >= 9 && number.length <= 12 && (number[0] == 1 || number[0]==6)){
			$('.error-block-for-mobile').hide();
			var partners = [];
			
			if(number.substring(0,2) == 60){
				number = number.substring(2);
			}

			$.get("./dashboard.php",{
				q: 'getPartnersIds',
				mobile: number,
				id: makeid(16)
			}, function(data){
				partners = JSON.parse(data);
				console.log(partners);
				if(partners == 'show_all'){
					$("#transfer_wallet_type_multiple option").each(function(){
						var name = $(this).val();
						$(".ms-drop input[value='" + name + "']").parent().parent().show();
					});
					$("#transfer_wallet_type_multiple").multipleSelect("enable");
				}else{
					var foundValues = 0;
					$("#transfer_wallet_type_multiple option").each(function(){
						var merchant = $(this).attr("s_merchant_id");
						var is_in = ($.inArray(merchant, partners) == -1) ? false : true;
						var name = $(this).val();
						console.log(merchant);
						if(is_in){
							$(".ms-drop input[value='" + name + "']").parent().parent().show();
							console.log($(this).val() + " is now showing");
							foundValues++;
						}else{
							$(".ms-drop input[value='" + name + "']").parent().parent().hide();
							console.log($(this).val() + " is now hidden");
						}
						if(foundValues != 0){
							$("#transfer_wallet_type_multiple").multipleSelect("enable");
						}else{
							$("#transfer_wallet_type_multiple").multipleSelect("disable");
						}
						console.log("-------------");
					});
				}

			});

			$.ajax({  
						url :'functions.php',
						type:'POST',
						dataType : 'json',
						data:{mobile_number:number,method:"userdetail"},   
						success:function(response){
								var data = JSON.parse(JSON.stringify(response));
								if(data.status==true)
								{
									var user_name=data.data.name;
									if(user_name)
									{
										$('.intro_user').hide();
										$('.user_info').show();
										$('.user_name').html("Transfer to "+user_name);

									}
									else
									{
										$('.intro_user').hide();
										$('.user_info').hide();
									}
								}
								else
								{
									$('.user_info').hide();
									$('.intro_user').show();
								}								
						}		  
					});
		
		}
		else
		{ 
			$('.error-block-for-mobile').html("Wrong mobile no. entered");
			$('.error-block-for-mobile').show();
		}
    });
	$('.final_done').click(function (){
		location.reload();
	});
	$(".Logoutpop").on('click', function(event){
		  // alert(3);
       $('#LoginModel').modal('show');
	});
});
</script>