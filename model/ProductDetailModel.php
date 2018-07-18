<?
class ProductDetailModel
{
	private $dbconn;
	function __construct($dbconn)
	{
		$this->dbconn = $dbconn;
	}

	public function GetProduct($productid)
	{
		$query = "SELECT * FROM products WHERE productid = '$productid'";
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

	public function GetProductName($productid)
	{
		$query = "SELECT productname FROM products WHERE productid = '$productid'";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			while($obj = $results->fetch_object()) 
			{
				return $obj->productname;
			}
		}
		return false;
	}

	public function GetProductPrice($productid)
	{
		$query = "SELECT productprice FROM products WHERE productid = '$productid'";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			while($obj = $results->fetch_object()) 
			{
				return $obj->productprice;
			}
		}
		return false;
	}

	public function GetProductImage($productid)
	{
		$query = "SELECT productimage FROM products WHERE productid = '$productid'";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			while($obj = $results->fetch_object()) 
			{
				return $obj->productimage;
			}
		}
		return false;
	}
}