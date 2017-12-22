<?php
	class DBOperations {
		private $con;

		function __construct() {
			require_once dirname(__FILE__).'/DBConnect.php';

			$db = new DBConnect();

			$this->con = $db->connect();
		}

		/* CRUD -> C -> CREATE */
		public function createUser($email, $pass, $username, $phone) {
			if($this->isUserExist($username, $email)) {
				return 0;
			} else {
				$password = md5($pass);
				if(empty($phone))
				{
					$phone=null;
				}
				$stmt = $this->con->prepare("INSERT INTO `user` (`id`, `email`, `password`, `username`, `phone`) VALUES (NULL, ?, ?, ?, ?);");
				$stmt->bind_param("ssss", $email, $password, $username, $phone);

				if($stmt->execute()) {
					return 1;
				} else {
					return 2;
				}
			}
		}

		public function userLogin($email, $pass) {
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT id FROM user WHERE email = ? AND password = ?;");
			$stmt->bind_param("ss", $email, $password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		public function getUserByEmail($email) {
			$stmt = $this->con->prepare("SELECT * FROM user WHERE email = ?;");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		private function isUserExist($username, $email) {
			$stmt = $this->con->prepare("SELECT id FROM user WHERE username = ? OR email = ?;");
			$stmt->bind_param("ss", $username, $email);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		public function getGroupByAdvertised($value) {
			$stmt = $this->con->prepare("SELECT * FROM studygroup WHERE advertising = ? ");
			$stmt->bind_param("s", $value);
			$stmt->execute();
			return $stmt->get_result();
		}
}
