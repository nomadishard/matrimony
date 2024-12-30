<?php
include 'connect.php';

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM profiles WHERE email= ?");
$stmt->bind_param("s", $_POST['email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Direct password comparison (not recommended for production)
    if (password_verify($_POST['pass'], $user['password'])) 
{      


// Store the token in the database associated with the user ID
// Example SQL: INSERT INTO users (user_id, token) VALUES (?, ?)

        session_start();
        session_set_cookie_params(60 * 60 * 24 * 7);
        // Generate a unique token
    $token = bin2hex(random_bytes(16)); // Generate a random token
    setcookie("remember_me", $token, time() + (60 * 60 * 24 * 7), "/"); // Cookie lasts for 7 days
    $sql=$conn->prepare("Insert into profiles (token) VALUES (?) Where email = ?");
    $sql->bind_param("ss",$token,$_POST['email']);
    $sql->execute();
        $_SESSION['email'] = $user['email'];
        $_SESSION["loggedin"] = true;
        $_SESSION['username'] = $user['FirstName'];
        $_SESSION['user_id'] = $user['ProfileID'];
        $_SESSION['gender']=$user['Gender'];
        $st=$user['status'];
        $_SESSION['status']=$st;
        $_SESSION['role']=$user['admin'];
        header("location:checkstatus.php?status=$st");
    } else {
        echo "<script>
    alert('Incorrect Password');
    window.location.href = 'login.html';
</script>";
    }
} else {
    echo "<script>
    alert('No profile with such Email found');
    window.location.href = 'login.html';
</script>";
}

// Close the connection
$stmt->close();
$conn->close();
?>