<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="EDUASSIST.png"/>
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    </head>
    <body id="page-top">
         <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 position-static" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand text-dark d-flex align-items-center gap-2" href="index.php">
                    <img src="EDUASSIST.png" alt="EduAssist Logo" width="40" height="40" class="d-inline-block align-text-top">
                    EduAssist Solutions
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link text-dark" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="services.php">What We Offer</a></li>
                        <li class="nav-item"><a class="nav-link text-primary" href="login.php">Log-In</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" disabled><i class="fa-solid fa-cart-shopping"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        


        <?php
        session_start();
        include("db_connect.php");
        if ($_SERVER["REQUEST_METHOD"]=="POST"){
            $username = trim($_POST["username"]);
            $password = md5(trim($_POST["password"]));
            $result = mysqli_query($DBConnect, "SELECT * FROM customer WHERE
            username='$username' AND user_password='$password'");
            if (mysqli_num_rows($result) === 1) {
                $user = mysqli_fetch_assoc($result);
                $_SESSION['user_data'] = $user['customer_id'];
                header("Location: welcome.php");
            } else {
                echo "<div class = 'alert alert-danger' role = 'alert'>Invalid username or password.</div>";
            }
            
        }
        ?>



        <!-- login-->
        <section class="page-section" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-6 text-center">
                        <h2 class="mt-0">Log-In</h2>
                        <hr class="divider" />
                    </div>
                </div>
                <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                    <div class="col-lg-6">
                        <form id="loginForm" method="post" action="login.php">
                            <!-- Username input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" name="username"id="username" type="text" placeholder="username" data-sb-validations="required,username" required />
                                <label for="email">Username</label>
                                <div class="invalid-feedback" data-sb-feedback="username:required">An username is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="username:username">username is not valid.</div>
                            </div>
                            <!-- Password input-->
                            <div class="form-floating mb-3">
                                <input class="form-control " name="password" id="password" type="password" placeholder="example@email.com" data-sb-validations="required" required/>
                                <label for="password">Password</label>
                                <input class = "me-1 mt-3 ms-1"type="checkbox" onclick="myFunction()">Show Password
                                <script>
                                function myFunction() {
                                var x = document.getElementById("password");
                                if (x.type === "password") {
                                    x.type = "text";
                                } else {
                                    x.type = "password";
                                }
                                }
                                </script>
                                <div class="invalid-feedback" data-sb-feedback="phone:required">A Password is Required</div>
                            </div>
                            <!-- Submit success message-->
                            <!---->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    To activate this form, sign up at
                                    <br />
                                    <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                </div>
                            </div>
                            <!-- Submit error message-->
                            <!---->
                            <!-- This is what your users will see when there is-->
                            <!-- an error submitting the form-->
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            <!-- Sign up Button-->
                            <div class="d-grid gap-2">
                            <!-- Submit Button-->
                            <button class="btn btn-primary btn-x" id="submitButton" type="submit">Submit</button>
                            <a class="btn btn-link btn-x " id="signInButton" type="button" href="register.php">Register</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; 2025 - Jamil & Lansigan</div></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SimpleLightbox plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
