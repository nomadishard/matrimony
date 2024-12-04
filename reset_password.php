<?php
require 'connect.php'; // Include your database connection file

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid; show reset password form
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password</title>
            <link rel="icon" href="logo.png" type="image/x-icon">
     
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>

        <div class="container mt-5">
            <h2>Reset Password</h2>
            <form action="" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="mb-3">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Enter new password">
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>

        </body>
        </html>

        <?php
    } else {
        echo "Invalid token.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token'])) {
    // Update password in the database
    $password =$_POST['password'];
    
    // Get email associated with token
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $_POST['token']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Update user password
        $stmt = $conn->prepare("UPDATE profiles SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $password, $row['email']);
        
        if ($stmt->execute()) {
            echo "<script>
            alert('Password Reset successfully!');
            window.location.href = 'login.html';
          </script>";
        } else {
            echo "Error updating password.";
        }
    }
}
?>
