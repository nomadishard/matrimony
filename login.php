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
    if ($_POST['pass'] === $user['password']) {
        session_start();
        $_SESSION['email'] = $user['email'];
        $_SESSION["loggedin"] = true;
        $_SESSION['username'] = $user['FirstName'];
        $_SESSION['user_id'] = $user['ProfileID'];
        $_SESSION['gender']=$user['Gender'];
        $st=$user['status'];
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