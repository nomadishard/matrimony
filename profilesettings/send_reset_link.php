<?php
require '../connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT ProfileID FROM profiles WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));

        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();

        $mail = new PHPMailer(true); // Enable exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;  // Enable verbose debug output (was SMTP::DEBUG_SERVER)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'fondesthorse11@gmail.com'; // Your Gmail address
            $mail->Password   = 'wmfhzrywbdsfjzcy';  // Use an App Password!
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('fondesthorse11@gmail.com', 'Kokani Rishta');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $token = urlencode($token); // URL encode the token
            $mail->Body    = "Click this link to reset your password: http://kokanirishta.in/reset_password.php?token=$token";

            $mail->send();
            echo "<script>
                alert('Reset Link sent successfully!');
                window.location.href = '../login/';
              </script>";

        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo . "<br>"; // PHPMailer's error message
            echo "Exception message: " . $e->getMessage(); //  Detailed exception message
            // Log the error to a file or database (recommended)
        }

    } else {
        echo "<script>alert('No account found with that email address.');
        window.location.href='../profilesettings/';
        </script>";
    }
}
?>
