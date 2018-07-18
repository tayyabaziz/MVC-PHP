<?
class SessionModel
{
	private $dbconn;
	function __construct($dbconn)
	{
		$this->dbconn = $dbconn;
	}

	function getUserID($usersession, $computername)
	{
		$query = "SELECT * FROM users WHERE usersession = '$usersession'";
		$results = $this->dbconn->query($query);
		if(mysqli_num_rows($results))
		{
			while($obj = $results->fetch_object()) 
			{
				return $obj->userid;
			}
		}
		else 
		{
			$query = "INSERT INTO users (username, usersession, prevbalance, newbalance) VALUES ('$computername', '$usersession', '100', '100')";
			$results = $this->dbconn->query($query);
			return $this->dbconn->insert_id;
		}
		return false;
	}
}