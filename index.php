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
        <?php
        session_start();
        $view = "";
        include("db_connect.php");
        // Get cart count
        $user_id = $_SESSION['user_data'] ?? null;
        $stmt = $DBConnect->prepare("SELECT SUM(quantity) AS total FROM cart WHERE (customer_id = ? OR session_id = ?) AND status = 'ACTIVE'");
        $stmt->bind_param("is", $user_id, $session_id);
        $stmt->execute();
        $cart_count = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

        if (!isset($_SESSION['user_data'])) {
            $log = '
            <li class="nav-item"><a class="nav-link" href="login.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Log-in</a></li>';
                    
        } else{
            // $cart_count =mysqli_query($DBConnect,"SELECT SUM(quantity) AS total FROM cart WHERE customer_id = ? OR session_id = ?");
            $log = '
            <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i>('.$cart_count.')</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Log-out</a></li>';
            $view = '<br><a class="btn btn-primary btn-xl mt-2" href="welcome.php">View Profile</a>' ;      
        }
        ?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 bg-dark position-static" id="mainNav">
            <div class="container px-4 px-lg-5">
                 <a class="navbar-brand d-flex align-items-center gap-2" href="#page-top">
                    <img src="EDUASSIST.png" alt="EduAssist Logo" width="40" height="40" class="d-inline-block align-text-top">
                    <span class="text-white">EduAssist Solutions</span>
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link  border-bottom border-3 border-primary text-primary" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link " href="aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.php">What We Offer</a></li> 
                        <?php echo $log?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h1 class="text-white font-weight-bold"> We are here one Assignment at a Time.</h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75 mb-5">We offer personalized help with homework, projects, and study skills—making schoolwork easier and more effective for students at all levels.</p>
                        <a class="btn btn-primary btn-xl" href="#products">Find Out More</a>
                        <?php echo $view?>
                    </div>
                    
                </div>
            </div>
        </header>
         <section class="page-section bg-light" id="products">
    <div class="container px-4 px-lg-5">
        <h2 class="text-center">Featured products</h2>
        <hr class="divider" />

      
        <!-- Tab Contents -->
        <div class="tab-content" id="productTabsContent">

            <!-- Services Tab -->
            <div class="tab-pane fade show active" id="services" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <!-- Bronze Member -->
                    <div class="col">
                        <div class="card h-100">
                             <img src="Services/bronze.png" class="card-img-top" alt="College Prep">
                            <div class="card-body">
                                <h5 class="card-title">Bronze Member</h5>
                                <p class="card-text">Basic access to study resources and updates.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Silver Member -->
                    <div class="col">
                        <div class="card h-100">
                            <img src="Services/silver.png" class="card-img-top" alt="College Prep">
                            <div class="card-body">
                                <h5 class="card-title">Silver Member</h5>
                                <p class="card-text">Includes refresher courses and basic test kits.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gold Member -->
                    <div class="col">
                        <div class="card h-100">
                             <img src="Services/gold.png" class="card-img-top" alt="College Prep">
                            <div class="card-body">
                                <h5 class="card-title">Gold Member</h5>
                                <p class="card-text">All-access membership with premium kits and exams.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            


        
    </div>
    <div class="align-items-center justify-content-center text-center mt-3">
                <a class="btn btn-primary btn-xl" href="services.php">View More</a> 
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