<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

require 'common.php';

$txn_status='';

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
        
        $txn_status='Your order is success fully placed';
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
	}
	else {
        $txn_status='Transaction status is failure';
	}

	if (isset($_POST) && count($_POST)>0 )
	{
	    if(isset($_POST['PAYMENTMODE']) && isset($_POST['TXNDATE']))
		$query="UPDATE `orders` SET `TXNAMOUNT` = '".$_POST['TXNAMOUNT']."', `PAYMENTMODE` = '".$_POST['PAYMENTMODE']."', `TXNDATE` = '".$_POST['TXNDATE']."', `STATUS` = '".$_POST['STATUS']."', `RESPMSG` = '".$_POST['RESPMSG']."' WHERE orderid='".$_POST['ORDERID']."' and amount='".$_POST['TXNAMOUNT']."' ";
		 else
      $query="UPDATE `orders` SET `TXNAMOUNT` = '".$_POST['TXNAMOUNT']."',  `STATUS` = '".$_POST['STATUS']."', `RESPMSG` = '".$_POST['RESPMSG']."' WHERE orderid='".$_POST['ORDERID']."' and amount='".$_POST['TXNAMOUNT']."' ";
 
        $row=mysqli_query($con,$query) or die(mysqli_error($con));
    }


    $query="select * from orders where orderid='".$_POST['ORDERID']."' ";
    $res=mysqli_query($con,$query) or die(mysqli_error($con));

    $row=mysqli_fetch_array($res);

    $cust_num=$row['custnum'];
    
    $cust_name=$row['custname'];

    $token_id=0;

    
    $items=$row['items'];

    $items=explode(',',$items);




  if($_POST['STATUS']=='TXN_SUCCESS')
    
   {


    $date_token=explode(' ',$_POST['TXNDATE']);

    $date_token=$date_token[0];


    if($row['tokenid']!=NULL)
    {
      $token_id=$row['tokenid'];
    }

    else
    {

      $query="select * from token";

      $row=mysqli_query($con,$query) or die(mysqli_error($con));

      $res=mysqli_fetch_array($row);

      if($res['tokendate']==$date_token)
      {
        $token_id=$res['tokenid']+1;

        $query="update token set tokenid='".$token_id."' where id=1 ";

        $row=mysqli_query($con,$query) or die(mysqli_error($con));
      }
      
      else
      {
   
        $token_id=1;
        
        $query="update token set tokenid='".$token_id."',tokendate='".$date_token."' where id=1 ";

        $row=mysqli_query($con,$query) or die(mysqli_error($con));
      }


      $query="update orders set tokenid='".$token_id."' where orderid='".$_POST['ORDERID']."' ";

      $row=mysqli_query($con,$query) or die(mysqli_error($con));

     $msg="Hey ".$cust_name.", thanks for dining with us."."Your token number is - ".$token_id;

     $field = array(
    "sender_id" => "FSTSMS",
    "language" => "english",
    "route" => "qt",
    "numbers" => "$cust_num",
    "message" => "26604",
    "variables" => "{#BB#}|{#AA#}",
    "variables_values" => "$cust_name|$token_id"
);

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($field),
          CURLOPT_HTTPHEADER => array(
            "authorization: X1iAb0ruWli6t04e32zWBLtVIcqXAu4M8Jjh1TUb1JIq7sHP3k1cSM7YIDna",
            "cache-control: no-cache",
            "accept: */*",
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          //echo "cURL Error #:" . $err;
        } else {
          //echo $response;
        }





    }
  
  }



}
else {
	$txn_status="<b>Checksum mismatched.</b>";
}

?>



<html>
<head>
<title></title>
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
         <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
         <script src="https://kit.fontawesome.com/9d2de32d23.js" crossorigin="anonymous"></script>
         

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="row h-100">
<div class="col-sm-12 my-auto">
<div class="card mx-auto align-middle" style="width: 18rem;">
  <div class="card-body justify-content-center">
    <h5 class="card-title">Order Summary</h5>

    <div class="card-text">
    <table class="table table-dark">
  <thead>
    <tr>
      
      <th scope="col">Item</th>
      <th scope="col">Quantity</th>
      
    </tr>
  </thead>
  <tbody id='cart_table'>
    <?php
            
            foreach($items as $temp)
            {
                $b=explode(':',$temp);
                $table_row='<tr>';
                $table_row=$table_row.'<td>'.$b[0].'</td>';
                $table_row=$table_row.'<td>'.$b[1].'</td>';
                $table_row=$table_row.'</tr>';
                echo $table_row;
            }
    
    ?>
  </tbody>
</table>
    <div class="float-left"><b><i>Amount : <span class="pull-right"><?php echo $_POST['TXNAMOUNT']?></span></b></i></div>
    <br>
    <div><i><?php echo $txn_status;?></i></div>
    <br>
    <div>Your token : <?php echo $token_id;?></div>
    </div>
  </div>
</div>
</div>
</div>
</body>
</html>

