<?php
include('config.php');
echo $id=$_POST['updatedid'];
echo $service_id=$_POST['service_id'];
$update=mysqli_query($conn,"UPDATE users SET `service_id`='$service_id' WHERE id='$id' ");

?>