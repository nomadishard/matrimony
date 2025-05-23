<?php

include 'connect.php';
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $sql = $conn->prepare("SELECT * FROM profiles WHERE token = ?");
    $sql->bind_param("s", $token); // Bind the token parameter

    // Execute the query
    if ($sql->execute()) {
        $res = $sql->get_result(); // Get the result set from the executed statement
        $user = $res->fetch_assoc(); // Fetch the user data as an associative array

        // Check if a user was found
        if ($user) {
            // Log the user in by setting session variables
            $_SESSION['email'] = $user['email'];
            $_SESSION["loggedin"] = true;
            $_SESSION['username'] = $user['FirstName'];
            $_SESSION['user_id'] = $user['ProfileID'];
            $_SESSION['gender'] = $user['Gender'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['role'] = $user['admin'];

            // Redirect to home.php
            header("Location: home/");
            exit();
        }
    }
}

?>



<!doctype html>
<html lang="en">

<head>
    <title>Kokani Rishta - Find Your Perfect Match</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta property="og:title" content="Kokani Rishta - Find Your Perfect Match">
    <meta property="og:description" content="Join Kokani Rishta to find your perfect match with verified profiles and advanced matching features. Sign up today!
        Free For first 100 users">
    <meta property="og:image" content="KOKAN_CONNECT.png">
    <link rel="icon" href="logo.png" type="image/x-icon">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="style2.css">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center ms-1 p-0" href="#">
                    <img src="../images/navlogo.png" class="d-none d-sm-block d-inline-block align-top ms-2" alt="" style="max-height: 20vh;">
                    <span style="font-family: Montserrat, sans-serif; font-weight: 800; font-style: italic; color: white;" class="ms-2">KOKANI RISHTA</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item active">
                            <a class="nav-link p-3" href="#" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-3" href="aboutus.html" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">About Us</a>
                        </li>
                        <a class="nav-link p-3" href="pricing/" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-3" href="login/" style="font-family: Montserrat, sans-serif;
                    font-weight: 500;
                    color: white;">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="pf1 pb-3">


            <div
                class="row">
                <div class="col">
                    <img src="images/couple2.png" alt="" style="max-height:80vh; margin-top: -50px;max-width: 100vw;">
                </div>
                <div class="col">
                    <img src="images/rose1.png" alt="">
                    <div style="text-align: center;padding-bottom: 10vh;"><span class="pfm">Find <br>Your Perfect <br>Match</span><img src="images/rose2.png" alt="" class=""><br>
                        <a
                            name=""
                            id=""
                            class="gs"
                            href="login/"
                            role="button">GET STARTED
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </a>
                        <br>

                    </div>

                </div>
            </div>
        </section>
        <section class="sec2" style="width: 100%;">
            <div class="image-container">
                <img src="images/test3.png" alt="" class="sec2img">
                <div class="text-overlay">
                    Begin your journey to a <br> blessed union. Together, <br>let's complete your deen.

                </div>
            </div>
            </div>
        </section>
        <section class="sec3">
            <div
                class="row justify-content-center align-items-center g-2 pt-3 pb-3">
                <div class="col">
                    <div class="rounded-rectangle">
                        <span class="sec3t">Verified profiles</span><br>
                        <span class="sec3p">Profiles you can trust. Verified for your peace of mind
                    </div>
                </div>
                <div class="col">
                    <img src="images/cp1.png" class="img-fluid mx-auto d-block" alt="">
                </div>

            </div>

            <div
                class="row justify-content-center align-items-center g-2">
                <div class="col"><img src="images/cp2.png" alt="" class="img-fluid mx-auto d-block"></div>
                <div class="col">
                    <div class="rounded-rectangle2">
                        <span class="sec3t">Advanced Matching</span><br>
                        <span class="sec3p">Discover your perfect match using our advanced and meaningful filters</span>
                    </div>
                </div>
            </div>

            <div
                class="row justify-content-center align-items-center g-2 pt-3 pb-3">
                <div class="col">
                    <div class="rounded-rectangle">
                        <span class="sec3t">Privacy Control</span><br>
                        <span class="sec3p">Your information, your rules-complete control at every step</span>
                    </div>
                </div>
                <div class="col"><img src="images/cp3.png" alt="" class="img-fluid mx-auto d-block"></div>
            </div>




        </section>



    </main>
    <footer class="footer">
        <p style="background: #72001F; color: white; padding-bottom: 0px; margin-bottom: 0px; text-align: center;">
            <a href="privacy/" style="color: white; margin: 0 10px;">Privacy Policy</a> |
            <a href="terms.html" style="color: white; margin: 0 10px;">Terms and Conditions</a> |
            <a href="refundpolicy.html" style="color: white; margin: 0 10px;">Refund Policy</a><br>
            &copy; <span id="currentYear"></span> KOKANIRISHTA.IN. All rights reserved.
        </p>
    </footer>

    <script>
        // Get the current year
        const currentYear = new Date().getFullYear();
        // Set the current year in the footer
        document.getElementById('currentYear').textContent = currentYear;
    </script>
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