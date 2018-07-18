<?
class CheckoutModel
{
	private $dbconn;
	function __construct($dbconn)
	{
		$this->dbconn = $dbconn;
	}

	public function AddOrder($orderdata, $userid) 
	{
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('Asia/Karachi'));
		$orderdate = $date->format('Y-m-d H:i:s');

		$firstname = $orderdata['firstname'];
		$lastname = $orderdata['lastname'];
		$phonenumber = $orderdata['phonenumber'];
		$email = $orderdata['email'];
		$address = $orderdata['address'];
		$address2 = $orderdata['address2'];
		$shippingmethod = $orderdata['shippingmethod'];
		$cart_items = $orderdata['cart_items'];
		$totalamount = 0;
		foreach ($cart_items as $productid => $cart_item) 
		{
			$totalamount += $cart_item['productprice'];
		}

		if($shippingmethod == "pickup")
		{
			$shippingcharges = 0;
		} 
		else 
		{
			$shippingcharges = 5;
		}

		$query = "INSERT INTO orders (orderdate, firstname, lastname, email, address, address2, phonenumber, totalamount, shippingmethod, shippingcharges, userid) VALUES ('$orderdate', '$firstname', '$lastname', '$email', '$address', '$address2', '$phonenumber', '$totalamount', '$shippingmethod', '$shippingcharges', '$userid')";
		$results = $this->dbconn->query($query);
		$orderid = $this->dbconn->insert_id;
		if($results) 
		{
			$finaltotalamount = $shippingcharges + $totalamount;
			$query2 = "SELECT * FROM users WHERE userid = '$userid'";
			$results2 = $this->dbconn->query($query2);
			if(mysqli_num_rows($results2))
			{
				while($obj2 = $results2->fetch_object()) 
				{
					$prevbalance = $obj2->prevbalance;
					$newbalance = $obj2->newbalance;
				}
			}
			$prevbalance = $newbalance;
			//$prevbalance = 100;
			$newbalance = $prevbalance - $finaltotalamount;
			$query2 = "UPDATE users SET prevbalance = '$prevbalance', newbalance = '$newbalance' WHERE userid = '$userid'";
			$results2 = $this->dbconn->query($query2);

			foreach ($cart_items as $productid => $cart_item) 
			{
				$query = "INSERT INTO order_details (orderid, productid, productqty, productprice) VALUES ('$orderid', '$productid', '".$cart_item['productqty']."', '".$cart_item['productprice']."')";
				$results = $this->dbconn->query($query);
			}
		}
		if($results) 
		{
			return $orderid;
		}
		return $results;
	}

	public function getOrderAmountDetails($orderid) 
	{
		$query = "SELECT (O.totalamount + O.shippingcharges) AS totalamount, U.prevbalance, U.newbalance FROM orders O, users U WHERE O.orderid = '$orderid' AND O.userid = U.userid";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			while($obj = $results->fetch_object()) 
			{
				return $obj;
			}
		}
		return false;
	}
}