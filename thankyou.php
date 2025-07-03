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
        include("db_connect.php");
        
        if (!isset($_SESSION["user_data"])) {
            header("Location: index.php");
            exit;
        }
        $customer_id = $_SESSION['user_data'];
        $user_id = $_SESSION['user_data'] ?? null;
             // Prepare and execute query safely
        $stmt = $DBConnect->prepare("SELECT * FROM customer WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id); // assuming customer_id is integer
        $stmt->execute();
        $result = $stmt->get_result();

        $userData = $result->fetch_assoc(); // fetch as associative array

        // Assign data
        $fullName = $userData['customer_name'];
    
        $pnum = $userData['phone_num'];
        $email = $userData['email'];

        $stmt = $DBConnect->prepare("SELECT transaction_id FROM cart WHERE customer_id = ? AND status = 'TRANSACT' ORDER BY transaction_id DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $transaction_id = $stmt->get_result()->fetch_assoc()['transaction_id'] ?? 'N/A';

        $stmt = $DBConnect->prepare("SELECT payment FROM transaction WHERE customer_id = ? ORDER BY transaction_id DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $payment = $stmt->get_result()->fetch_assoc()['payment'];

        $stmt = $DBConnect->prepare("SELECT address FROM transaction WHERE customer_id = ? ORDER BY transaction_id DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $address = $stmt->get_result()->fetch_assoc()['address'];

        $cart = $DBConnect->query("SELECT * FROM cart WHERE customer_id = $user_id  AND status = 'TRANSACT' AND transaction_id = $transaction_id");
        
        $stmt = $DBConnect->prepare("SELECT SUM(total_price) AS total FROM cart WHERE (customer_id = ? OR session_id = ?) AND status = 'TRANSACT' AND transaction_id = $transaction_id");
        $stmt->bind_param("is", $user_id, $session_id);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

        $tax = $total * .12;
        $total_tax = $tax + $total;

        $stmt = $DBConnect->prepare("SELECT SUM(quantity) AS total FROM cart WHERE (customer_id = ? OR session_id = ?) AND status = 'ACTIVE'");
        $stmt->bind_param("is", $user_id, $session_id);
        $stmt->execute();
        $cart_count = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
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
<section class="container py-5 mt-5 b-3">
    <div class="text-center">
    <div class="alert alert-success pt-3 pb-5 rounded-4 shadow-sm">
        <div class="d-flex justify-content-center">
                        <img src = "EDUASSIST.png" width="100" height = "100" class="d-flex justify-content-center">
                        </div>
        <h3 class="mb-3">Thank you for shopping!</h3>
        <p class="text-muted">Your purchased items will be shipped to you immediately!</p>
        <div class="container mb-3 pb-3 rounded" style="background-color:white;">
                <div class="row mt-3 py-3 px-4  rounded text-start" style="background-color:white;">
                    <div class="card-body">
                        <div class="align-items-center mb-3 ">
                            <h2 class="text-center">Receipt</h2>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control border-0" value="<?= htmlspecialchars($fullName) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control border-0" value="<?= htmlspecialchars($email) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" class="form-control border-0" value="<?= "(".substr($pnum, 0, 4).") ".substr($pnum, 4, 3)." ".substr($pnum, 7, 7); ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="address" class="form-label fw-bold">Shipping Address</label>
                                <input type="text" name="address" id="address" class="form-control border-0" placeholder="Enter your full delivery address" value="<?= htmlspecialchars($address) ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 py-2 px-4 rounded" style="background-color:white;">
                    <div class="row">
                        <div class="col-md border-bottom pb-2">
                            <h5 class="mb-0 text-dark"><i class="bi bi-truck"></i> Fulfilled by EduAssist</h5>
                        </div>
                    </div>

                    <?php while ($row = $cart->fetch_assoc()): ?>
                        <?php 
                            $productId = $row['product_id'];
                            $stmt = $DBConnect->prepare("SELECT * FROM product WHERE product_id = ?");
                            $stmt->bind_param("i", $productId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $product = $result->fetch_assoc();
                        ?>
                        <div class="row py-3 border-bottom align-items-center">
                            <div class="col-md-2 text-center">
                                <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid border border-secondary rounded shadow-sm" style="max-height: 180px;">
                            </div>
                            <div class="col-md-10 ps-4 text-start">
                                <h5 class="mb-1"><?= htmlspecialchars($product['product_name']) ?></h5>
                                <p class="mb-1 text-primary fs-5">₱<?= htmlspecialchars($row['total_price']) ?></p>
                                <p class="mb-0 text-secondary"><?= htmlspecialchars($row['quantity']) ?>x ordered</p>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <!-- Payment Method -->
                    <div class="row pt-3 my-2">
                        <div class="col-md-12">
                            <h5 class="mb-2"><i class="bi bi-credit-card"></i> Payment Method</h5>
                            
                                <input type="text" class="form-control text-center" value="<?= htmlspecialchars($payment) ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Total Summary  -->
                <div class="row justify-content-end mt-3 mb-3">
                    <div class="col-md-5">
                        <div class="px-4 py-3 rounded" style="background-color:white;">
                            <h5 class="text-dark mb-3">Order Summary</h5>
                            <p class="text-secondary fs-6 mb-2">Subtotal: ₱<?= htmlspecialchars($total) ?></p>
                            <p class="text-secondary fs-6 mb-2">VAT (12%): ₱<?= htmlspecialchars($tax) ?></p>
                            <hr>
                            <p class="fs-4 fw-bold text-dark mb-3">Total: ₱<?= htmlspecialchars($total_tax) ?></p>
                        </div>
                    </div>
                </div>

        </div>
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
