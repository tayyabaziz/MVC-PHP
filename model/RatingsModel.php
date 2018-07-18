<?
class RatingsModel
{
	private $dbconn;
	function __construct($dbconn)
	{
		$this->dbconn = $dbconn;
	}

	public function GetRating($productid)
	{
		//var_dump(phpinfo());
		$query = "SELECT AVG(ratingvalue) AS ratingvalue FROM ratings WHERE productid = '$productid'";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			while($obj = $results->fetch_object()) 
			{
				return $obj->ratingvalue;
			}
		}
		return false;
	}

	public function SetRating($productid, $ratingvalue, $ipaddress)
	{
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('Asia/Karachi'));
		$timestamp = $date->format('Y-m-d H:i:s');

		$userid = $_SESSION['userid'];
		$usersession = $_SESSION['usersession'];
		$useragent = getenv( 'HTTP_USER_AGENT' );

		$query = "INSERT INTO ratings (productid, ratingvalue, timestamp, ipaddress, usersession, useragent, userid) VALUES ('$productid', '$ratingvalue', '$timestamp', '$ipaddress', '$usersession', '$useragent', '$userid')";
		$results = $this->dbconn->query($query);
		return $results;
	}


	public function CheckRating($productid, $ipaddress) 
	{
		$userid = $_SESSION['userid'];
		$usersession = $_SESSION['usersession'];
		$useragent = getenv( 'HTTP_USER_AGENT' );

		$query = "SELECT * FROM ratings WHERE productid = '$productid' AND ipaddress = '$ipaddress' AND userid = '$userid'";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			return true;
		}
		return false;
	}
}