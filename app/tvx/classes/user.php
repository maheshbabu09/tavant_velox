<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	private function get_user_hash($username){

		try {
			$stmt = $this->_db->prepare('SELECT password, username, memberID FROM members WHERE username = :username AND active="Yes" ');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function isValidUsername($username){
		if (strlen($username) < 3) return false;
		if (strlen($username) > 17) return false;
		if (!ctype_alnum($username)) return false;
		return true;
	}

	public function login($username,$password){
		if (!$this->isValidUsername($username)) return false;
		if (strlen($password) < 3) return false;

		$row = $this->get_user_hash($username);

		if($this->password_verify($password,$row['password']) == 1){

		    $_SESSION['loggedin'] = true;
		    $_SESSION['username'] = $row['username'];
		    $_SESSION['memberID'] = $row['memberID'];
		    return true;
		}
	}

	public function logout(){
		session_destroy();
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}
	public function create_user($form_data) {
		$stmt = $this->_db->prepare('INSERT INTO members (username,password,email,active) VALUES (:username, :password, :email, :active)');
		$stmt->execute(array(
				':username' => $form_data['username'],
				':password' => $form_data['password'],
				':email' => $form_data['email'],
				':active' => $form_data['active']
			));
	}
	public function check_username($username) {
		$stmt = $this->_db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $username));		
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function get_memberId($username) {
		$stmt_user_details = $this->_db->prepare('SELECT memberID FROM members WHERE username = :username');
		$stmt_user_details->execute(array('username' => $username));
		return $stmt_user_details->fetch();
	}
	public function update_password($form_data) {
		$stmt = $this->_db->prepare("UPDATE members SET password = :hashedpassword, resetComplete = 'Yes'  WHERE memberID = :memberID");
		$stmt->execute(array(
					':hashedpassword' => $form_data['hashedpassword'],
					':memberID' => $form_data['memberID']
				));

	}

}


?>
