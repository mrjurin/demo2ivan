<?php
include("config.php");

if( isset( $_POST['method']) && ( $_POST['method'] == "updatePrinted" )  ) {
    $id= $_POST['id'];
    $printed = $_POST['printed'];
    mysqli_query($conn, "UPDATE order_list SET printed='$printed' WHERE id='$id'");
    echo('update printed.');
} else {
    $id= $_POST['id'];
    $oid= $_POST['oid'];
    $orid= $_POST['orid'];
    $status= $_POST['status'];
    $_SESSION['mm_id'] = $id;
    $_SESSION['o_id'] = $oid;
    $_SESSION['orid'] = $orid;
    $merchant_id = $_SESSION['login'];
    $invoice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT max(invoice_no) no FROM order_list WHERE merchant_id='$merchant_id'"));
    $invoice_no += $invoice['no'] + 1;
    mysqli_query($conn, "UPDATE order_list SET status='$status', status_change_date = CURDATE() WHERE id='$id'");
    // echo $status;
    //die;
    if($status==1)
    {
        $order_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id  FROM order_list WHERE id='".$id."'"));
        $user_id=$order_data['user_id'];
        $user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT moengage_unique_id FROM users WHERE id='".$user_id."'"));
        $push_id=$user_data['moengage_unique_id'];

        if ($push_id) {
            $result=exec("/usr/bin/python myscript.py");
            $resultarray=explode(",",$result);
            if (count($resultarray)>0) {
                // code...
                $data['camp_name']=$camp_name=$resultarray[0];
                $data['sign']=$sign=$resultarray[1];
                $data['push_email']=$push_id;
                $data['title']='Order Done';
                $data['message']='Your food is ready. Please enjoy your foods.';
                $data['redirectURL']= $site_url.'/orderlist.php';
                include 'push.php';
                $user = new Push();
                $resultpush = $user->send_push($data);
                // print_R($resultpush);
                // die;
            }
        }
    }
}
?>
