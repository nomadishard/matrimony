<?php
include '../connect.php';
session_start();

$st = $_SESSION['status'];
?>
<!doctype html>
<html lang="en">

<head>
    <title>Profile Status</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <style>
        .message-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message-container h1 {
            color: #ff9800;
            /* Orange color */
        }

        .message-container p {
            color: #555;
            /* Darker grey for text */
        }

        .message-container a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .message-container a:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }
    </style>
    <link rel="icon" href="logo.png" type="image/x-icon">

</head>

<body>
    <header>
        <?php include '../navbar.php'; ?>
    </header>
    <main>

        <?php
        if ($st == 0) {
            echo '<section class="container" style="text-align: center;">
    <div class="message-container w-50 mt-5 container" style="margin: 0 auto;">
        <h1>Profile Under Verification</h1>
        <p>Your profile is currently under verification. Please check back later.</p>
    </div>
</section>
';
            echo '<form>
  <a href="https://payments.cashfree.com/forms/kokan" target="_parent">
    <div class="button-container" style="background: #000">
      <div>
        <img src="https://cashfreelogo.cashfree.com/cashfreepayments/logosvgs/Group_4355.svg" alt="logo" class="logo-container">
      </div>
      <div class="text-container">
        <div style="font-family: Arial; color: #fff; margin-bottom: 5px; font-size: 14px;">
          Pay Now
        </div>
        <div style="font-family: Arial; color: #fff; font-size: 10px;">
            <span>Powered By Cashfree</span>
            <img src="https://cashfreelogo.cashfree.com/cashfreepayments/logosvgs/Group_4355.svg" alt="logo" class="seconday-logo-container">
        </div>
      </div>
    </div>
  </a>
 <style>
  .button-container{
      border: 1px solid black;
      border-radius: 15px;
      display: flex;
      padding: 10px;
      width: fit-content;
      cursor: pointer;
  }
  .text-container{
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-left: 10px;
      justify-content: center;
      margin-right: 10px;
  }
  .logo-container{
      width: 40px;
      height: 40px;
  }
  .seconday-logo-container{
    width: 16px;
    height: 16px;
    vertical-align: middle;
  }
  a{
    text-decoration:none;
  }
</style>
</form>';
        } else if ($st == 1 || $st == 2 || $st == 3) {
            echo '<script>window.location.href = "../home/";
</script>';
        }
        ?>


    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>