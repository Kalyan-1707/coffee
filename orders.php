<?php

require 'common.php';

$item_list_db=array();

$item_list=array();

$cust_name = strip_tags(mysqli_real_escape_string($con,$_POST['customer_name']));
$items = strip_tags(mysqli_real_escape_string($con,$_POST['items']));

if(!(preg_match('/^[a-zA-z0-9-.@_] $/',$cust_name)))
{
	header('location:http://localhost/coffee/index.php?name=invalid_name');
}

else
{

if($items==NULL || $cust_name==NULL)
	header('location:http://localhost/coffee/index.php?items=cart_is_empty');

else
{
$query="select * from items";

$res=mysqli_query($con,$query) or die(mysqli_error($con));

while($row=mysqli_fetch_array($res))
{
	$item_list_db[$row['name']]=$row['price'];

}


$items=substr($items,0,-1);

$temp=explode(',',$items);


foreach($temp as $res)
{
	$b=explode(':',$res);
	$item_list[$b[0]]=$b[1];
}

$amount=0;

foreach($item_list as $name => $val)
{
	$amount+=$item_list_db[$name]*$val;	
}




$orderid="ORDS" . rand(10000,99999999);



$query="INSERT INTO `orders` (`id`, `items`, `custname`, `amount`, `orderid`) VALUES (NULL, '$items', '$cust_name', $amount, '$orderid')";

$res=mysqli_query($con,$query) or die(mysqli_error($con));

}

}
?>


<?php
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Merchant Check Out Page</title>
<meta name="GENERATOR" content="Evrsoft First Page">
</head>
<body>
<center><h1>Please do not refresh this page...</h1></center>
	

    <div style="display:none;">
    <h1>Merchant Check Out Page</h1>
	<pre>
	</pre>
	<form method="post" action="pgRedirect.php" name="f1">
		<table border="1">
			<tbody>
				<tr>
					<th>S.No</th>
					<th>Label</th>
					<th>Value</th>
				</tr>
				<tr>
					<td>1</td>
					<td><label>ORDER_ID::*</label></td>
					<td><input id="ORDER_ID" tabindex="1" maxlength="20" size="20"
						name="ORDER_ID" autocomplete="off"
						value="<?php echo  $orderid?>">
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td><label>CUSTID ::*</label></td>
					<td><input id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php echo $cust_name?>"></td>
				</tr>
				<tr>
					<td>3</td>
					<td><label>INDUSTRY_TYPE_ID ::*</label></td>
					<td><input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"></td>
				</tr>
				<tr>
					<td>4</td>
					<td><label>Channel ::*</label></td>
					<td><input id="CHANNEL_ID" tabindex="4" maxlength="12"
						size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
					</td>
				</tr>
				<tr>
					<td>5</td>
					<td><label>txnAmount*</label></td>
					<td><input title="TXN_AMOUNT" tabindex="10"
						type="text" name="TXN_AMOUNT"
						value="<?php echo $amount?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					
				</tr>
			</tbody>
		</table>
		* - Mandatory Fields
	</form>

    </div>
    <script type="text/javascript">
			document.f1.submit();
		</script>

</body>
</html>