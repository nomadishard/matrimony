<?php
include '../connect.php';

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM profiles WHERE email= ?");
$stmt->bind_param("s", $_POST['email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Direct password comparison (not recommended for production)
    if (password_verify($_POST['pass'], $user['password'])) {      
        // Secure token generation
        $token = bin2hex(random_bytes(16)); // Cryptographically secure token
    
        // Set session parameters
        session_set_cookie_params([
            'lifetime' => 60 * 60 * 24 * 7,
            'path' => '/',
            'secure' => true,  // HTTPS only
            'httponly' => true // Prevent JavaScript access
        ]);
        session_start();
    
        // Set remember me cookie
        setcookie("remember_me", $token, [
            'expires' => time() + (60 * 60 * 24 * 7),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict' // CSRF protection
        ]);
    
        // Update token in database
        $sql = $conn->prepare("UPDATE profiles SET token = ? WHERE Email = ?");
        $sql->bind_param("ss", $token, $_POST['email']);
        $sql->execute();
    
        // Set session variables
        $_SESSION['email'] = $user['email'];
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['FirstName'];
        $_SESSION['user_id'] = $user['ProfileID'];
        $_SESSION['gender'] = $user['Gender'];
        $_SESSION['status'] = $st = $user['status'];
        $_SESSION['role'] = $user['admin'];
        header("location:../profilestatus/");
    }
     else {
        echo "<script>
    alert('Incorrect Password');
    window.location.href = '../login';
</script>";
    }
} else {
    echo "<script>
    alert('No profile with such Email found');
    window.location.href = '../login';
</script>";
}

// Close the connection
$stmt->close();
$conn->close();
?>