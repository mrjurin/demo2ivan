<?php 
include("config.php"); 
if(isset($_SESSION['login'])){
$user_id = $_SESSION['login'];
} else {   
$user_id = "";
}
$total_rows = mysqli_query($conn, "SELECT * FROM users WHERE user_roles='2' ORDER BY name ASC ");
$user_mobile =  isset($_SESSION['login']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT mobile_number FROM users WHERE id='".$_SESSION['login']."'"))['mobile_number'] : '';

$error = "";
if(isset($_GET['error_type'])){
$type = $_GET['error_type'];
if($type == 2)
$error= "The merchant you are trying to find was already introduced by another member.";
if($type == 1)
$error= "The merchant's phone number is incorrect.";
}
   ?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
   <head>
      <?php include("includes1/head.php"); ?>
      <style>
         .sidebar {
         background: #eceff1;
         }
         div#app {
         margin-bottom: 20px;
         }
         .form-control {
         display: block;
         }
         table.table {
         width: 400px;
         }
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
         .ct_ctycode {     
         margin-bottom: 12px;  
         }
         a.dropdownlivalue {
         padding: 10px;
         }
         @media (min-width: 370px) and (max-width:380px) {
         button.btn.btn-block.btn-primary.testts.merchant_nam {
         font-size: 11px!important;
         }
         button.btn.btn-block.btn-primary.testts.tele_num {
         font-size: 11px!important;
         }
         button.btn.btn-block.btn-primary.testts.scan_code {
         font-size: 11px!important;
         }
         button.btn.btn-block.btn-primary.testts.fav_list {
         font-size: 11px!important;
         }
         button.btn.btn-block.btn-primary.testts.search_shopss {
         font-size: 11px!important;
         }
         }
         @media (min-width: 328px) and (max-width:628px) {
         .navbar-nav li a
         {
         padding: 0px;
         }
         .ripple {
         padding: 3px, 10px;
         }
         div#merchant_name {
         padding: 0;
         margin-left: 2px;
         }
         div#tele_number {
         padding: 0;
         margin-left: 2px;
         }
         div#scan_qrcode {
         padding: 0;
         margin-left: 0px;
         }
         .col-md-12.test_test {
         padding: 0;
         margin: 0;
         }
         .col-md-12.test_test {
         margin-bottom: 5px!important;
         margin: 0;
         }
         button.btn.btn-block.btn-primary.testts.merchant_nam {
         font-size: 12px;
         }
         button.btn.btn-block.btn-primary.testts.tele_num {
         font-size: 12px;
         }
         button.btn.btn-block.btn-primary.testts.scan_code {
         font-size: 12px;
         }
         button.btn.btn-block.btn-primary.testts.fav_list {
         font-size: 12px;
         }
         button.btn.btn-block.btn-primary.testts.search_shopss {
         font-size: 12px;
         }
         
         }
         .col-md-12.test_test {
         display: flex;
         }
         .col-md-3.test_qwertys {
         color: #fff;
         background-color: #fb9678;
         border-color: #fb9678;
         -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
         box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075); 
         margin-left:0px;
         }
         .col-md-3.test_qwertys1 {
         color: #fff;
         background-color: #fb9678;
         border-color: #fb9678;
         -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
         box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075); 
         margin-left: 12px;
         }
         .col-md-3.test_qwertys2 {
         color: #fff;
         background-color: #fb9678;
         border-color: #fb9678;
         -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
         box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075); 
         margin-left: 12px;
         }
         button.btn.btn-block.btn-primary.testts:hover {
         border-color: #f99678;
         background-color: #f99678;
         }
         .col-md-12.test_test.dollar {
    margin-bottom: 10px;
} 

 
      </style>
   </head>
   <body class="header-light sidebar-dark sidebar-expand pace-done">
      <div class="pace  pace-inactive">
         <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
         </div>
         <div class="pace-activity"></div>
      </div>
      <div id="wrapper" class="wrapper"> 
      <!-- HEADER & TOP NAVIGATION -->
      <?php include("includes1/navbar.php"); ?>
      <!-- /.navbar -->
      <div class="content-wrapper">
         <!-- SIDEBAR -->
         <?php include("includes1/sidebar.php"); ?>
         <!-- /.site-sidebar -->
         <main class="main-wrapper clearfix" style="min-height: 522px;">
            <div class="row" id="main-content" style="">
			 <!-- <a style="text-align:center;width:100%;margin-top:2%;" href="https://play.google.com/store/apps/details?id=com.koobigfamilies.app" target="blank">
					<img style="max-width:140px;" src="google.png" alt=""></a> -->
               
				<div class="row">
				   <div class="well col-md-8 favorite_list" id="favourate_list">
                     <h3> Favorite List</h3>
                     <div class="form-group">
                        <select name= "business" class="form-control business_type" user_id="<?php echo $_SESSION['login']?>" >
                           <option>Foods and Beverage, such as restaurants, healthy foods, franchise, etc</option>
                           <option>Motor Vehicle, such as car wash, repair, towing, etc</option>
                           <option>Hardware, such as household, building, renovation to end users</option>
                           <option>Grocery Shop such as bread, fish, etc retails shops</option>
                           <option>Clothes such as T-shirt, Pants, Bra, socks,etc</option>
                           <option>Business to Business (B2B) including all kinds of businesses</option>
                        </select>
                     </div>
                     <?php 
					 // echo "SELECT users.name, user_id, favorite_id
                             // FROM favorities INNER JOIN users ON favorities.favorite_id = users.id
                             // WHERE user_id=".$_SESSION['login']." AND (users.business1 = 'Foods and Beverage, such as restaurants, healthy foods, franchise, etc' OR users.business2 = 'Foods and Beverage, such as restaurants, healthy foods, franchise, etc')";
							
                         $result = mysqli_query($conn,
                             "SELECT users.mobile_number,users.name, user_id, favorite_id
                             FROM favorities INNER JOIN users ON favorities.favorite_id = users.id
                             WHERE user_id=".$_SESSION['login']." group by user_id"
                            );
                        ?>
					<table class="table table table-striped kType_table">
					<thead>
					<tr>
					<th>No</th>
					<th>Name</th>
					<th>Mobile</th>
					</tr>
					</thead>
					<tbody class="favorite_tr">
					    <?php $j=1;while($fd = mysqli_fetch_assoc($result)){ ?>
						<th><?php echo $j; ?></th>
						<th><a style="color:#80dc71;" href="<?php echo $site_url; ?>/view_merchant.php?sid=<?php echo $fd['mobile_number'];?>">
						<?php echo $fd['name']; ?></a></th>
					<th><?php echo $fd['mobile_number']; ?></th>
						<?php } ?>
					</tbody>
					</table>
					<button type="button" class='btn btn-default nearby_restaurant_btn' user_id="<?php echo $user_id;?>">Click here to seach nearby shops.</button>
					<div id="map" style="height: 400px; display:none;"></div>
					<table class="table" id="nearby_restaurant">
                     <div id="map" style="height: 400px; display:none;"></div>
                     <table class="table" id="nearby_restaurant">
                        <thead>
                           <tr>
                              <th>id</th>
                              <th>Name</th>
                              <th>Distance</th>
                           </tr>
                        </thead>
                        <tbody class="nearby_tr">
                        </tbody>
                     </table>
                  </div>
				</div>
         </div>
         <!-- /.widget-body badge -->
      </div>
      <!-- /.widget-bg -->
      <!-- /.content-wrapper -->
      <?php include("includes1/footer.php"); ?>
   </body>
</html>
<style>
   select.ct_ctycode.text_name {
   width: 100%;
   }
   a:not([href]):not([tabindex]):hover {
   color: #6a6a6a;
   text-decoration: none;
   }
</style>
<script type="text/javascript">
   var $ = jQuery; 
   $(function() 
   {
    $( "#txtname" ).autocomplete({
    source: 'auto_complete.php'
    });
    
   });
   
   //~ var TitleAttr = $("#stl_scan").attr('title');
   //~ alert(TitleAttr);
   
   $(document).ready(function () {
       
       $("#mr_name").keyup(function () {
           $.ajax({
               type: "POST",
               url: "auto_complete.php",
               data: {
                   keyword: $("#mr_name").val()
               },
               dataType: "json",
               success: function (data) {
                   if (data.length > 0) {
                       $('#Dropdown_name').empty();
                       $('#mr_name').attr("data-toggle", "dropdown");
                       $('#Dropdown_name').dropdown('toggle');
                   }
                   else if (data.length == 0) {
                       $('#mr_name').attr("data-toggle", "");
                   }
                   $.each(data, function (key,value) {
   
                       if (data.length >= 0)
                           $('#Dropdown_name').append('<li role="presentation" ><a class="dropdownlivalue">' + value + '</a></li>');
                   });
               }
           });
       });
       
       $('ul.txtname').on('click', 'li a', function () {
           $('#mr_name').val($(this).text());
           $("#Dropdown_name").css("display", "none");
   
       });
       
       var latitude = 0;
       var longitude = 0;
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log("current location");
           latitude = position.coords.latitude;
           longitude = position.coords.longitude;
           getFavorite("Foods and Beverage, such as restaurants, healthy foods, franchise, etc", $(".business_type").attr('user_id'));
           //getNearbyRestaurant("Foods and Beverage, such as restaurants, healthy foods, franchise, etc", $(".business_type").attr('user_id'));
        });
        
        var map = new google.maps.Map(document.getElementById('map'), {
             center: { lat: latitude, lng: longitude },
             zoom: 15
       }); 
        $(".business_type").change(function(e){
           var data = {method: "getFavoriteByBusiness", type:e.target.value, user_id: $(this).attr('user_id')};
           
           getFavorite(e.target.value, $(this).attr('user_id'));
           
           $("#nearby_restaurant tbody").html("");
       });
       
       function getNearbyRestaurant(business, id){
           var data = {method: "getNearbyRestaurants", type:business, user_id: id};
           $.ajax({
               url:"functions.php",
               type:"post",
               data:data, 
               dataType: 'json',
               success:function(data){
                   var html = "";
                   $("#nearby_restaurant tbody").html(html);
                   for (var i = 0; i < data.length; i++){
                       var distance = getDistanceNearby(latitude, longitude, data[i]['latitude'], data[i]['longitude'], 'K');
                       data[i].distance = distance;
                   }
                   data.sort(function(a, b){
                       return a['distance'] - b['distance'];
                   });
                   for (var i = 0; i < data.length; i++){
                       html += "<tr>";
                       html += "<td>"+(i+1)+"</td>";
                       html += "<td><a href=structure_merchant.php?merchant_id="+data[i]['id']+">"+data[i]['name']+" ( "+data[i]['order_num']+", "+ data[i]['favorite_num']+")</a></td>";
                       
                       
                       html += "<td>"+data[i].distance+" km</td>";
                       html += "</tr>";
                   }
                   $("#nearby_restaurant tbody").html(html);
               }
           });
       } 
       
       function getFavorite(business, id){
           var data = {method: "getFavoriteByBusiness", type:business, user_id: id};
           $.ajax({
               url:"functions.php",
               type:"post",
               data:data, 
               dataType: 'json',
               success:function(data){
                   console.log(data);
                   var html = "";
                   $(".favorite_tr").html(html);
                   for (var i = 0; i < data.length; i++){
                       var distance = getDistance(latitude, longitude, data[i]['latitude'], data[i]['longitude'], 'K');
                       console.log(distance);
                       data[i].distance = distance;
                   }
                   data.sort(function(a, b){
                       return a['distance'] - b['distance'];
                   });
                   for (var i = 0; i < data.length; i++){
                       console.log(data);
                       html += "<tr>";
                       html += "<td>"+(i+1)+"</td>";
                       html += "<td><a href=structure_merchant.php?favorite_id="+data[i]['favorite_id']+">"+data[i]['name']+" ( "+data[i]['order_num']+", "+ data[i]['favorite_num']+")</a></td>";
                       
                       html += "<td>"+data[i].distance+" km</td>";
                       html += "</tr>";
                   }
                   $(".favorite_tr").html(html);
                   //getNearbyRestaurant(business, $(this).attr('user_id'));
               }
           });
       } 
       
       function getDistance(lat1, lon1, lat2, lon2, unit) {
       	var radlat1 = Math.PI * lat1/180
       	var radlat2 = Math.PI * lat2/180
       	var theta = lon1-lon2
       	var radtheta = Math.PI * theta/180
       	var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
       	if (dist > 1) {
       		dist = 1;
       	}
       	dist = Math.acos(dist)
       	dist = dist * 180/Math.PI
       	dist = dist * 60 * 1.1515
       	if (unit=="K") { dist = dist * 1.609344 }
       	if (unit=="N") { dist = dist * 0.8684 }
       	return dist.toFixed(1);
       }
       
       function getDistanceNearby(lat1, lon1, lat2, lon2, unit) {
       	var radlat1 = Math.PI * lat1/180
       	var radlat2 = Math.PI * lat2/180
       	var theta = lon1-lon2
       	var radtheta = Math.PI * theta/180
       	var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
       	if (dist > 1) {
       		dist = 1;
       	}
       	dist = Math.acos(dist)
       	dist = dist * 180/Math.PI
       	dist = dist * 60 * 1.1515
       	if (unit=="K") { dist = dist * 1.609344 }
       	if (unit=="N") { dist = dist * 0.8684 }
       	return dist.toFixed(1);
       }
       
       $(".nearby_restaurant_btn").click(function(e){
           e.preventDefault();
           
           getNearbyRestaurant($(".business_type").val(), $(this).attr('user_id')); 
           
       });
       
   });
</script>
<script src="https://use.fontawesome.com/ff2be4c29f.js"></script>
<style>
   .qrcode-text {
   padding-right:1.7em;
   margin-right:0
   }
   .qrcode-text-btn {
   background: url(https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg) 50% 50% no-repeat;
   height: 37px;
   width: 30px;
   margin-left: -32px;
   cursor: pointer;
   z-index: 999;
   }
   .qrcode-text-btn > input[type=file] {
   position:absolute; 
   width:1px; 
   height:1px; 
   opacity:0;
   cursor: pointer;
   }
   @media only screen and (max-width: 760px) and (min-width: 360px)  {
   div#app {
   width: 290px!important;
       height: 90%;
   }
   #app {
   display: block!important;
   }
   div#main-content {
   width: 355px;
   }
   .test {
   display: block!important;
   float: left;
   }
   table.table {
   width: 280px;
   }
   .form-control {
   display: block;
   width: 260px!important;
   }
   }
</style>
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script>
   function openQRCamera(node) {
     var reader = new FileReader();
     reader.onload = function() {
   	node.value = "";
   	qrcode.callback = function(res) {
   	  if(res instanceof Error) {
   		alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
   	  } else {
   		node.parentNode.previousElementSibling.value = res;
   	  }
   	};
   	qrcode.decode(reader.result);
     };
     reader.readAsDataURL(node.files[0]);
   }
</script>
<link rel="stylesheet" href="html5qrcodereader-master/css/reset.css">
        <link rel="stylesheet" href="html5qrcodereader-master/css/styles.css">
<!-- adding new---->
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="<?php echo $site_url;?>/instascan-master/docs/style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="https://www.koofamilies.com/instascan-master/docs/app.js"></script> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEr0LmMAPOTZ-oxiy9PoDRi3YWdDE_vlI&libraries=places" async defer></script> 
<style>
   div#app {
   margin-bottom:20px;
   }
   .mejs__controls {
   display: none;
   }
   #app {
   background: #263238;
   display: flex;
   align-items: stretch;
   justify-content: stretch;
   height: 85%;
   }
   .text_mobile{
   font-size: 18px;
   }
   .test {
   display: flex;
   float: left;
   }
   h4#scan_qrcode {
   cursor: pointer;
   }

   button.btn.btn-block.btn-primary.testts.scan_code {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}
   button.btn.btn-block.btn-primary.testts.tele_num {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}
   button.btn.btn-block.btn-primary.testts.merchant_nam {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}
.col-md-3.test_qwertys {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}
.col-md-3.test_qwertys1 {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}
.col-md-3.test_qwertys2 {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}
button.btn.btn-block.btn-primary.testts.search_shopss {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}
button.btn.btn-block.btn-primary.testts.fav_list {
    color: #000;
    background-color: #34caab;
    border-color: #34caab;
}

.preview-container {
    width: 35%!important;
    margin: 0 auto;
    margin-top: 12px;
}
.preview-container:before {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: 19px;
    left: -150px;
    border-top: 3px solid #fff;
    border-left: 3px solid #fff;
}
.preview-container:after {
   
   
       display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: 19px;
    right: -150px;
    border-bottom: 3px solid #fff;
    border-right: 3px solid #fff;
    
}
.mejs__mediaelement:before {
   display: block;
    float: right;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: -4px;
    right: -4px;
    border-top: 3px solid #fff;
    border-right: 3px solid #fff;
}
.mejs__mediaelement:after {
   
     display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: -22px;
    left: -2px;
    border-bottom: 3px solid #fff;
    border-left: 3px solid #fff;
    
}
@media (min-width: 760px) and (max-width:800px) {
.preview-container {
    width: 53%!important;
    margin: 0 auto;
    margin-top: 12px;
}
.mejs__mediaelement:after {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: -55px;
    left: -3px;
}
}
@media (min-width: 328px) and (max-width:750px) {
.preview-container:before {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: 10px;
    left: -110px;
    border-top: 3px solid #fff;
    border-left: 3px solid #fff;
}
.preview-container {
    width: 85%!important;
    margin: 0 auto;
    margin-top: 12px;
    height: 230px;
}
.preview-container:after {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: 16px;
    right: -108px;
}
.mejs__mediaelement:after {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: -3px;
    left: -3px;
}
.preview-container:before {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: 15px;
    left: -110px;
}
.mejs__mediaelement:before {
    display: block;
    float: right;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: -4px;
    right: -2px;
}


}


.mejs__container {
    max-width: 95%;
   
}.preview-container:before




</style>
<!-- newly added qr code-->
<script>
	
	$(document).ready(function() {
	var x = setInterval(function() {
			var test_qwertyss= $('.scans-enter-to').attr('title');
		if(test_qwertyss != null ){
			 //~ alert(test_qwertyss);
        //~ window.location.href = "https://koofamilies.com/structure_merchant.php?sid="+test_qwertyss; 
         // window.location.href = "<?php echo $site_url;?>/structure_merchant.php?sid="+test_qwertyss;
         window.location.href = test_qwertyss;
		}
		else {
		//~ alert('please scan the code');
			}
		
				 }, 1000); 
	});
</script>
<script>
   document.getElementById('scan_qrcode').onclick = function() {
       document.getElementById('qr_cursor').focus();
   };
   document.getElementById('tele_number').onclick = function() {
       document.getElementById('merchant').focus();
   };
   document.getElementById('merchant_name').onclick = function() {
       document.getElementById('txtname').focus();
   };
</script>

 <style>
a.btn.btn-block.testts.fav_list {
    color: black;
}  
.preview-container {
    width: 35%!important;
    margin: 0 auto;
    margin-top: 12px;
}
.preview-container:before {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: 79px;
    left: -94px;
    z-index:999;
    border-top: 3px solid red;
    border-left: 3px solid red;
}
.preview-container:after {
   
   
       display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: 110px;
    right: -83px;
    border-bottom: 3px solid red;
    border-right: 3px solid red;
    
}
.mejs__mediaelement:before {
   display: block;
    float: right;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: 20px;
    right: -3px;
    border-top: 3px solid red;
    border-right: 3px solid red;
}
.mejs__mediaelement:after {
   
     display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: 26px;
    left: -3px;
    border-bottom: 3px solid red;
    border-left: 3px solid red;
    
}
		  
		  
.sidebar {
    background: #eceff1;
}
div#app {
    margin-bottom: 20px;
}

.form-control {
    display: block;
    width: 350px;
}
table.table {
    width: 400px;
}

         .well
         {
         min-height: 20px;
         padding: 7px;
         margin-bottom: 20px;
         background-color: #fff;
         border: 1px solid #e3e3e3;
         border-radius: 4px;
         -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
         box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
         }
         .ct_ctycode {     
         margin-bottom: 12px;  
         }
    
 a.dropdownlivalue {
    padding: 10px;
}

@media (min-width: 328px) and (max-width:628px) {
.navbar-nav li a
{
	padding: 0px;
}
.ripple {
	
	padding: 3px, 10px;
}

}
@media (min-width: 760px) and (max-width:800px) {
.preview-container {
    width: 53%!important;
    margin: 0 auto;
    margin-top: 12px;
}
.mejs__mediaelement:after {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    bottom: -55px;
    left: -3px;
}
}
@media (min-width: 328px) and (max-width:750px) {
.preview-container:before {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
    top: 155px;
    left: -50px;
    
}

.preview-container {
    width: 85%!important;
    margin: 0 auto;
    margin-top: 12px;
    height:350px;
        

}
.preview-container:after {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
       bottom: 77px !important;
    right: -40px;
        z-index:999;


}
.mejs__mediaelement:after {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
        top: -77px !important;
    left: 55px !important;
    z-index: 999999 !important;

}
.preview-container:before {
    display: block;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
   top: 153px;
    left: -40px;
        z-index:999;


}
.mejs__mediaelement:before {
    display: block;
    float: right;
    content: "";
    width: 23px;
    height: 23px;
    position: relative;
      top: 130px;
    right: 55px;	
        z-index:999;

}
#preview_from_mejs {
   height:240px;
}


.mejs__container {
    max-width: 85%;
   
}
.mejs__overlay-play
{
	
    height: 190px !important;
}
}


.mejs__container {
    max-width: 95%;
   
}
.mejs__mediaelement {
    width: 90% !important;
    float: right;
    text-align: center;
        margin-left: 12px;
}

    
      </style>
