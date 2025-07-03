<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Home</title>
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
         <?php
        session_start();
        include('db_connect.php');
        if (isset($_SESSION["user_data"])){
            $customer_id = $_SESSION['user_data'];
             // Prepare and execute query safely
            $stmt = $DBConnect->prepare("SELECT * FROM customer WHERE customer_id = ?");
            $stmt->bind_param("i", $customer_id); // assuming customer_id is integer
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $userData = $result->fetch_assoc(); // fetch as associative array

                // Assign data
                $fullName = $userData['customer_name'];
                $gender = $userData['gender'];
                $bday = str_replace(" ", "", $userData['birthday']);
                $pnum = $userData['phone_num'];
                $email = $userData['email'];
                $address = $userData['customer_address'];
                $username = $userData['username'];
            }

            $user_id = $_SESSION['user_data'] ?? null;
            $stmt = $DBConnect->prepare("SELECT SUM(quantity) AS total FROM cart WHERE (customer_id = ? OR session_id = ?) AND status = 'ACTIVE'");
            $stmt->bind_param("is", $user_id, $session_id);
            $stmt->execute();
            $cart_count = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
           
        } else{
            header("Location: login.php");
        }
        

        
        // Get cart count
       

        
        ?>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 bg-dark position-static" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand d-flex align-items-center gap-2" href="#page-top">
                    <img src="EDUASSIST.png" alt="EduAssist Logo" width="40" height="40" class="d-inline-block align-text-top">
                    <span class="text-white">EduAssist Solutions</span>
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link text-primary" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link " href="aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.php">What We Offer</a></li> 
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i>(<?php echo $cart_count?>)</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Log-out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        






        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end mb-5">

                        <?php 
                         echo '<h1 class="text-white font-weight-bold">Welcome back, '. substr($fullName, 0, strpos($fullName, " ")).'!</h1><h1 class = "fs-3 text-light"><br> We are here to assist you one assignment at a time.</h1>';
                        ?>
                        <hr class="divider" />


                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75 mb-5">We offer personalized help with homework, projects, and study skills—making schoolwork easier and more effective for students at all levels.</p>
                        <a class="btn btn-primary btn-xl" href="#profile">View Profile</a>
                    </div>
                    
                    
                </div>
            </div>
            
            
        </header>
        <div class="container px-4 px-lg-5 my-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="fw-bold text-primary">User Profile</h1>
                        <img src="assets/no_profile.png" class="rounded-circle mt-3 shadow-sm" width="150" alt="User Profile">
                        <p class="text-muted mt-2 fs-5">@<?php echo $username ?></p>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush text-start">
                                <li class="list-group-item"><strong>Name:</strong> <?php echo $fullName ?></li>
                                <li class="list-group-item"><strong>Gender:</strong> <?php echo ucwords($gender) ?></li>
                                <li class="list-group-item"><strong>Date of Birth:</strong>
                                    <?php 
                                        $date = new DateTime($bday);
                                        echo $date->format('F j, Y'); 
                                    ?> 
                                </li>
                                <li class="list-group-item"><strong>Phone Number:</strong>  
                                    <?php echo "(".substr($pnum, 0, 4).") ".substr($pnum, 4, 3)." ".substr($pnum, 7, 7); ?> 
                                </li>
                                <li class="list-group-item"><strong>Email:</strong> <?php echo $email ?></li>
                                <li class="list-group-item"><strong>Home Address:</strong> <?php echo $address ?></li>
                            </ul>

                            <div class="text-center mt-4">
                                <a href="logout.php" class="btn btn-outline-danger px-4 py-2">
                                    <i class="bi bi-box-arrow-right me-1"></i> Log Out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>







        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; 2025 - Precious Lansigan</div></div>
        </footer>


        <!-- <div class="bg-light py-5">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; 2025 - Precious Lansigan</div></div>
        </div> -->
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
