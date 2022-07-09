<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=webprojectfinal','root', 'test');

class Auth {

  function __construct() {
        $this->conn = $this->connectDB();
  }

  function connectDB() {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=webprojectfinal','root', 'test');
    // See the "errors" folder for details...
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }

	function getTokenByEmail($email,$expired) {
	    $query = "Select * from tbl_token_auth where email = :email and is_expired = :expired";
      $stmt = $this->conn -> prepare($query);
      $stmt->execute(array(':email' => $email,
                           ':expired' => $expired));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    return $row;
    }

    function markAsExpired($tokenId) {
        $query = "UPDATE tbl_token_auth SET is_expired = 1 WHERE id = :id";
        $stmt = $this->conn -> prepare($query);
        $stmt->execute(array(':id' => $tokenId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function insertToken($email, $random_password_hash, $random_selector_hash, $expiry_date) {
        $query = "INSERT INTO tbl_token_auth (email, password_hash, selector_hash, expiry_date) values (:email, :password, :selector, :exdate)";
        $stmt = $this->conn -> prepare($query);
        $stmt->execute(array(':email' => $email,
                             ':password' => $random_password_hash,
                             ':selector' => $random_selector_hash,
                             ':exdate' => $expiry_date));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
?>
