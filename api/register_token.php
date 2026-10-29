<?php
require_once("../access_db.php");
/*

//TABLE CREATED IN THE DATABASE

CREATE TABLE api_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,

    email VARCHAR(255) NOT NULL,
    token_hash CHAR(64) NOT NULL UNIQUE,  -- SHA-256 hashed token

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    last_used DATETIME,

    -- 🔍 Indexes
    INDEX idx_token_hash (token_hash),
    INDEX idx_email (email),
    INDEX idx_is_active (is_active),
    INDEX idx_expires_at (expires_at),
    INDEX idx_last_used (last_used)
);

*/

function generateToken($length = 64) {
    return bin2hex(random_bytes($length / 2)); // returns a 64-char token
}

$email =''; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
    $email = trim($_GET['email']);
}
if($email){

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email.");
    }

    //Check if token exists in the table and if its active
    $stmt = $conn->prepare("SELECT token_hash, expires_at FROM api_tokens WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $token_valid = false;
    $plain_token = '';
    $now = new DateTime();

    $force = isset($_GET['force']) && $_GET['force'] === 'true';

    if ($row && !$force) {
	    $expires_at = new DateTime($row['expires_at']);
	    if ($expires_at > $now) {
		    echo "A valid token already exists. Please contact hcadmin@gmu.edu. Please send your email that used iniially,  as that will be used to verify and generate token. </br>";
//Please use it or force a new one with &force=true.</br>";
		    $token_valid = true;
	    }
    }

    if (!$token_valid) {
	    // Generate new token
	    $plain_token = generateToken(); // this will be emailed/displayed to the user
	    $token_hash = hash('sha256', $plain_token); // hash stored in DB
	    $created = $now->format('Y-m-d H:i:s');
	    $expires = $now->modify('+30 days')->format('Y-m-d H:i:s');

	    //make old tokens inactive
	    $update_stmt = $conn->prepare("UPDATE api_tokens SET is_active = 0 WHERE email = ?");
	    $update_stmt->bind_param("s", $email);
	    $update_stmt->execute();

	    // Insert or update token
	    $stmt = $conn->prepare("INSERT INTO api_tokens (email, token_hash, created_at, expires_at, is_active)
			    VALUES (?, ?, ?, ?, 1)
			    ON DUPLICATE KEY UPDATE token_hash = VALUES(token_hash), created_at = VALUES(created_at), expires_at = VALUES(expires_at)");
	    $stmt->bind_param("ssss", $email, $token_hash, $created, $expires);
	    $stmt->execute();
	    echo "Your token (save securely): <code>$plain_token</code> </br>";

	    echo '</br> </br> Please <a href="../index.php"> go back to index page</a> or <a href="./register_token.php"> register email page</a>';
    }

}
else{
?>
<form method="POST">
    Enter your email to generate API token: <input name="email" required />
    <button type="submit">Generate Token</button>
</form>
<?php } ?>
