<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Cart</title>
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

        if (!isset($_SESSION["user_data"])) {
            header("Location: index.php");
            exit;
        }

        include("db_connect.php");
        // Get cart count
        $user_id = $_SESSION['user_data'] ?? null;
        $stmt = $DBConnect->prepare("SELECT SUM(quantity) AS total FROM cart WHERE (customer_id = ? OR session_id = ?) AND status = 'ACTIVE'");
        $stmt->bind_param("is", $user_id, $session_id);
        $stmt->execute();
        $cart_count = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
        //for total  price
        $stmt = $DBConnect->prepare("SELECT SUM(total_price) AS total FROM cart WHERE (customer_id = ? OR session_id = ?) AND status = 'ACTIVE'");
        $stmt->bind_param("is", $user_id, $session_id);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
        //for cart items
        $cart = $DBConnect->query("SELECT * FROM cart where  customer_id = $user_id  AND status = 'ACTIVE'");
        
        

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cart_id"])) {
            $cartId = $_POST["cart_id"]; // ✅ assign it
    
            $stmt = $DBConnect->prepare("UPDATE cart SET quantity = 0, status = 'NOT ACTIVE', total_price = 0 WHERE cart_id = ?");
            $stmt->bind_param("i", $cartId);
            $stmt->execute();
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }
        
        ?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 bg-dark position-static" id="mainNav">
            <div class="container px-4 px-lg-5">
                 <a class="navbar-brand d-flex align-items-center gap-2" href="#page-top">
                    <img src="EDUASSIST.png" alt="EduAssist Logo" width="40" height="40" class="d-inline-block align-text-top">
                    <span class="text-white">EduAssist Solutions</span>
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link " href="aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.php">What We Offer</a></li> 
                        <li class="nav-item"><a class="nav-link text-primary" href="#"><i class="fa-solid fa-cart-shopping"></i>(<?php echo $cart_count?>)</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Log-out</a></li>
                    </ul>
                </div>
            </div>
</nav>

<!-- Shopping Cart Section -->
<section class="container py-5 mt-5">
    <div class="text-center">
    <div class="alert alert-success py-5 rounded-4 shadow-sm">
        <h3 class="mb-3">Thank you for shopping!</h3>
        <p class="text-muted">Your purchased items will be shipped to you immediately!</p>
        <a href="index.php" class="btn btn-primary mt-2">Go Home</a>
        <a href="services.php" class="btn btn-primary mt-2">Browse More Services</a>
    </div>
</div>
</section>

<!-- Footer -->
<footer class="bg-light py-5 mt-5">
    <div class="container px-4 px-lg-5 text-center">
        <div class="small text-muted">Copyright &copy; 2025 - 2025 - Jamil & Lansigan</div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
