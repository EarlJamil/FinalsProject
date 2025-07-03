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
        $display = '';
        $message = 'd-none';
        
        if (mysqli_num_rows($cart) <= 0){
            $display = 'd-none';
        $message = 'd-block';
        }
        

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
    <h2 class="mb-4">Your Shopping Cart</h2>
    <?php while($row = $cart->fetch_assoc()): ?>
        <?php 
            $productId = $row['product_id'];
            $stmt = $DBConnect->prepare("SELECT * FROM product WHERE product_id = ?");
            $stmt->bind_param("i", $productId); // "i" for integer
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

        ?>
    <!-- Cart Item -->
     <form method = "POST">
        <div class="card mb-3">
            <div class="row g-0 align-items-center ">
                <div class="col-md-2">
                    <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($product['product_name']) ?>">
                </div>
                <div class="col-md-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <p class="card-text text-muted">₱<?= htmlspecialchars($product['price']) ?>.00</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    
                        <?= htmlspecialchars($row['quantity']) ?> x
                    
                </div>
                <div class="col-md-2 text-center">
                    <strong>₱<?= htmlspecialchars($row['total_price']) ?>.00</strong>
                </div>
                
                <div class="col-md-2 text-center ">
                    <input class ="d-none"type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
                    <button class="btn btn-outline-danger" type="submit"><i class="fa-solid fa-trash"></i></i></button>
                </div>
            </div>
        </div>
    </form>
    <?php endwhile; ?>
    <!-- Total and Checkout -->
    <div class="row justify-content-end <?= htmlspecialchars($display) ?> mt-3">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <p class="card-text fs-4 fw-bold">₱<?= htmlspecialchars($total) ?>.00</p>
                    <a class="btn btn-success w-100" href="checkout.php">
                        <i class="bi bi-bag-check-fill"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center <?= htmlspecialchars($message) ?>">
    <div class="alert alert-primary py-5 rounded-4 shadow-sm">
        <i class="bi bi-cart-x fs-1 text-secondary mb-3"></i>
        <h3 class="mb-3">Your cart is currently empty</h3>
        <p class="text-muted">Looks like you haven't added anything on your cart yet. Explore our services to get started!</p>
        <a href="services.php" class="btn btn-primary mt-2">Browse Services</a>
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
