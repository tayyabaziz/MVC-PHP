<?
class ProductsModel
{
	private $dbconn;
	function __construct($dbconn)
	{
		$this->dbconn = $dbconn;
	}

	public function GetAllProducts()
	{
		$result = array();
		$query = "SELECT * FROM products ORDER BY productname ASC";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			while($obj = $results->fetch_object()) 
			{
				$result[] = $obj;
			}
		}
		return $result;
	}
}