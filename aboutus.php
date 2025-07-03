<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>About Us</title>
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
                        <li class="nav-item"><a class="nav-link " href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link  border-bottom border-3 border-primary text-primary" href="aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.php">What We Offer</a></li> 
                        <?php echo $log?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- About-->
       <section class="page-section bg-primary text-white" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <i class="bi-mortarboard-fill intro-icon"></i> 
                    <h2 class="mt-0 fade-in fade-in-1">We've got what you need!</h2>
                    <hr class="divider divider-light fade-in fade-in-2" />
                    
                    <p class="mb-4 text-white lead-intro fade-in fade-in-3">
                        At <strong class="text-light">EduAssist Solutions</strong>, we are dedicated to empowering students by providing the tools, resources, and guidance they need to excel academically. Founded with a passion for education and a deep understanding of the challenges students face, our mission is to make schoolwork less stressful and more rewarding.
                    </p>

                    <p class="mb-4 text-white fade-in fade-in-3">
                        We offer personalized assistance across a wide range of subjects, from homework help to project guidance and test preparation. Our team of experienced tutors and academic coaches works closely with each student to ensure they fully understand the material, improve their study habits, and achieve their academic goals.
                    </p>

                    <p class="mb-4 text-white fade-in fade-in-3">
                        Whether you're a high school student struggling with tough assignments or a college student juggling multiple courses, EduAssist Solutions is here to help. We provide flexible, tailored services to meet the unique needs of every learner, allowing them to work at their own pace while gaining the skills and confidence they need to succeed.
                    </p>

                    <div class="core-values-card fade-in fade-in-4">
                        <h3 class="text-center">Our Core Values:</h3>
                        <ul>
                                <li>
                                    <i class="bi-check-circle-fill"></i> 
                                    <span>Personalized Support: We focus on each student’s individual needs, ensuring they receive the attention and guidance required to thrive.</span>
                                </li>
                                <li>
                                    <i class="bi-lightbulb-fill"></i> 
                                    <span>Academic Excellence: Our goal is not only to help students complete their work but to foster a deeper understanding of the subject matter.</span>
                                </li>
                                <li>
                                    <i class="bi-award-fill"></i> 
                                    <span>Confidence Building: We believe that the right support can unlock every student’s full potential, boosting both their academic performance and self-confidence.</span>
                                </li>
                        </ul>
                    </div>
                    <p class="text-white fade-in fade-in-3">
                        Whether it's catching up on missed lessons, preparing for an exam, or tackling a difficult project, EduAssist Solutions is here to make learning simpler, more enjoyable, and ultimately, more successful.
                    </p>
                    <h1>Meet the Team:</h1>
                    <div class="col-md">
                    <img src="assets/JAMIL.png" class="rounded-circle mt-3 shadow-sm mb-2" width="150" alt="User Profile">
                    <p>Jamil, Earl Edward G.</p>
                    </div>
                    <div class="col-md">
                    <img src="assets/LANSIGAN.png" class="rounded-circle mt-3 shadow-sm mb-2" width="150" alt="User Profile">
                    <p>Lansigan, Precious Leona G.</p>
                    </div>
                </div>
            </div>
        </div>
        <section id="contact-us" class="bg-light py-5">
            <div class="container px-4 px-lg-5">
                <div class="text-center mb-4">
                    <h2 class="text-dark">Contact Us</h2>
                    <p class="text-muted">We’d love to hear from you! Please fill out the form below.</p>
                </div>
                <form method="POST" class="mx-auto" style="max-width: 600px;">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                    </div>
                </form>
            </div>
        </section>
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
