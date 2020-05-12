<?php

 require 'common.php';
 
 
//enum('Pending', 'Delivered', 'Cancelled', '')
 $order_status="Pending";

 $today_date=date("Y-m-d");
 $today_date=date("2020-04-25");
 if(isset($_POST['date']))
   $today_date=$_POST['date'];
 if(isset($_POST['status']))
   $order_status=$_POST['status'];
 $orders_temp='';//temporary variable to process orders data.
 $items_temp='';//temporary variable to process items data.
 $pending_orders_date_temp='';//to extract date from txndate of order.

 $query="SELECT * FROM orders where  `status`='TXN_SUCCESS' ORDER BY tokenid";
 $res=mysqli_query($con,$query) or die(mysqli_error($con));

 $orders_chart_values=array();
 $items_chart_values=array();
 $pending_orders=array();

 while($row=mysqli_fetch_array($res))
 {
     $temp=explode(' ',$row['TXNDATE']);
     $items_temp=explode(',',$row['items']);//to get items individually.
     $pending_orders_date_temp=explode(' ',$row['TXNDATE']);
     if(array_key_exists($temp[0],$orders_chart_values))
     {
        $orders_chart_values[$temp[0]]+=1;
     }
     else
     {
        $orders_chart_values[$temp[0]]=1;
     }
     foreach($items_temp as $x)//to get all items of customer and store in associative array
     {
         $x=explode(":",$x);
         if(array_key_exists($x[0],$items_chart_values))
         {
            $items_chart_values[$x[0]]+=$x[1];
         }
         else{
            $items_chart_values[$x[0]]=$x[1];
         }
     }
     if($pending_orders_date_temp[0]==$today_date && $row['orderStatus']==$order_status)
     {

         $pending_orders[$row['custname'].' '.$row['tokenid']]=$row['items'];//adding data in form 'custname tokenid=items'
     }

    
 }


 krsort($orders_chart_values);

 $chart=array('orders'=>$orders_chart_values,'items'=>$items_chart_values,'pendingOrders'=>$pending_orders);//combine all chart data to single varaible.

 
echo json_encode($chart);

 
?>