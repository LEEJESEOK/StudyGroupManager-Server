<?php
	class DBOperations {
		private $con;
		
		function __construct() {
			require_once dirname(__FILE__).'/DBConnect.php';

			$db = new DBConnect();
	
			$this->con = $db->connect();
		}

		/* CRUD -> C -> CREATE */
		public function createUser($username, $pass, $email, $phone) {
			if($this->isUserExist($username, $email)) {
				return 0;
			} else {
				$password = md5($pass);
				if(empty($phone))
				{
					$phone=null;
				}
				$stmt = $this->con->prepare("INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`) VALUES (NULL, ?, ?, ?, ?);");
				$stmt->bind_param("ssss", $username, $password, $email, $phone);

				if($stmt->execute()) {
					return 1;
				} else {
					return 2;
				}
			}
		}
		
		public function userLogin($email, $pass) {
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT id FROM users WHERE email = ? AND password = ?;");
			$stmt->bind_param("ss", $email, $password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
		
		public function getUserByEmail($email) {
			$stmt = $this->con->prepare("SELECT * FROM users WHERE email = ?;");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
		
		private function isUserExist($username, $email) {
			$stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR email = ?;");
			$stmt->bind_param("ss", $username, $email);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
		
		private function advertisingGroup() {
			$stmt = $this->con->prepare("SELECT studygroup_num, studygroup_name, purpose, studygrouphost_email, studygroup_contents FROM studygroup WHERE advertising = 'Y';");
			$stmt->execute();
			echo $stmt;
			$stmt->store_result();
			return $stmt->fetch_assoc();
		}
	}