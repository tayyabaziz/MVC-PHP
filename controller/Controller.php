<?php
include __DIR__ . '/../config/dbConn.php';
class Controller extends dbConn
{

	private $mysqli;

	public function SetDbConn($mysqli)
	{
		$this->mysqli = $mysqli;
	}

	public function GetDbConn()
	{
		return $this->mysqli;
	}

	public function GetSystemIPAddress()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;
	}

	public function __construct() 
	{
		$db = dbConn::getInstance();
		$this->SetDbConn($db->getConnection());

		date_default_timezone_set('Asia/Karachi');

		$ipaddress = $this->GetSystemIPAddress();
		$computername = $ipaddress;
		if(function_exists('gethostbyaddr'))
		{
		  $computername = gethostbyaddr($ipaddress);
		}

		$usersession = base64_encode(md5(time().$computername));
		if (!isset($_SESSION["usersession"]))
		{
			$_SESSION['usersession'] = $usersession;
		}
		else 
		{
			$usersession = $_SESSION["usersession"];
		}
		
		$sesionmodel = $this->model('SessionModel');
		$_SESSION['userid'] = $sesionmodel->getUserID($usersession, $computername);

	}

	public function view($value, $data = "")
	{
		require_once "view/$value.php";
	}

	public function model($value)
	{
		require_once "model/$value.php";
		return new $value($this->GetDbConn());
	}
}