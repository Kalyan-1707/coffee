<?php

 require 'common.php';

 $orders_temp='';//temporary variable to process orders data.
 $items_temp='';//temporary variable to process items data.

 $query="SELECT * FROM orders where  `status`='TXN_SUCCESS' ORDER BY TXNDATE DESC";
 $res=mysqli_query($con,$query) or die(mysqli_error($con));

 $orders_chart_values=array();
 $items_chart_values=array();

 while($row=mysqli_fetch_array($res))
 {
     $temp=explode(' ',$row['TXNDATE']);
     $items_temp=explode(',',$row['items']);//to get items individually.
     if(array_key_exists($temp[0],$orders_chart_values))
     {
        $orders_chart_values[$temp[0]]+=1;
     }
     else
     {
        $orders_chart_values[$temp[0]]=1;
     }
     foreach($items_temp as $x)
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

    
 }

 $chart=array('orders'=>$orders_chart_values,'items'=>$items_chart_values);//combine all chart data to single varaible.

 
echo json_encode($chart);

 
?>