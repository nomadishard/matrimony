<?php
require 'connect.php'; // Include your database connection file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT ProfileID FROM profiles WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        // Store token in the database (you should create a token table)
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        // Send email with reset link
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'fondesthorse11@gmail.com'; 
        $mail->Password   = 'wmfhzrywbdsfjzcy'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('fondesthorse11@gmail.com', 'Kokan Match');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Click this link to reset your password: http://kokanmatch.in/reset_password.php?token=$token";
        
        if ($mail->send()) {
            echo "<script>
            alert('Reset Link sent successfully!!!!!');
            window.location.href = 'login.html';
          </script>";
        } else {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "No account found with that email address.";
    }
}
?>
