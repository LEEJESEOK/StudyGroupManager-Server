<?php
	class DBConnect{
		private $con;
		
		function __construct()
		{
		}
		
		function connect()
		{
			include_once dirname(__FILE__).'/constraints.php';
			$this->con = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
			
			if(mysqli_connect_errno())
			{
				echo "Failed to connect with DataBase".mysqli_connect_error();
			}
			
			return $this->con;
		}
	}
