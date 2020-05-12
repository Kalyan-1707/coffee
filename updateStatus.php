<?php

 require 'common.php';

 $today_date=date("Y-m-d");
 $today_date=date("2020-04-25");//value hard coded to show functionality has to removed when set up in production
 if(isset($_POST['date']))
  $today_date=$_POST['date'];
 $item_token=$_POST['token'];
 $item_status=$_POST['status'];//	enum('Pending', 'Delivered', 'Cancelled', '')

 

 $query=" Update orders set `orderSTATUS`='$item_status'  where  `TXNDATE` like '$today_date%' and `tokenid`='$item_token'  ";
 $res=mysqli_query($con,$query) or die(mysqli_error($con));

 echo($res);



?>
