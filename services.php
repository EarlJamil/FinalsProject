<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>What We Offer</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        
        $conn = new mysqli("localhost", "root", "", "eduassist");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION['user_data'] ?? null;
        $session_id = session_id();

        // Handle Add to Cart

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
            $product_id = (int)$_POST["product_id"];
            $qty = max(1, (int)$_POST["quantity"]);
            
            // Check if the item is already in the cart
            $check = $conn->prepare("
                SELECT quantity 
                FROM cart 
                WHERE (customer_id = ? OR session_id = ?) 
                AND product_id = ? 
                AND transaction_id IS NULL
            ");
            $check->bind_param("isi", $user_id, $session_id, $product_id);
            $check->execute();
            $check->bind_result($existing_qty);
            $exists = $check->fetch();
            $check->close();

            // Fetch product price
            $price_stmt = $conn->prepare("SELECT price FROM product WHERE product_id = ?");
            $price_stmt->bind_param("i", $product_id);
            $price_stmt->execute();
            $price_stmt->bind_result($price);
            $price_stmt->fetch();
            $price_stmt->close();

            if ($exists) {
                $new_qty = $existing_qty + $qty;
                $total_price = $new_qty * $price;

                $update = $conn->prepare("
                    UPDATE cart
                    SET quantity = ?, total_price = ?, status = 'ACTIVE'
                    WHERE (customer_id = ? OR session_id = ?) 
                    AND product_id = ? 
                    AND transaction_id IS NULL
                ");
                $update->bind_param("diiis", $new_qty, $total_price, $user_id, $session_id, $product_id);
                $update->execute();
                $update->close();

            } else {
                $total_price = $qty * $price;
                $insert = $conn->prepare("
                    INSERT INTO cart (customer_id, session_id, product_id, quantity, total_price, status)
                    VALUES (?, ?, ?, ?, ?, 'ACTIVE')
                ");
                $insert->bind_param("isidd", $user_id, $session_id, $product_id, $qty, $total_price);
                $insert->execute();
                $insert->close();
            }
        }


        // Get cart count

        $stmt = $conn->prepare("SELECT SUM(quantity) AS total FROM cart WHERE (customer_id = ? OR session_id = ?) AND status = 'ACTIVE'");
        $stmt->bind_param("is", $user_id, $session_id);
        $stmt->execute();
        $cart_count = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
        $redirect = "";
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

        // Sort options

        $order = "ORDER BY date_added DESC";
        if (isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'cheapest': $order = "   "; break;
                case 'recommended': $order = "   "; break;
            }
        }

        $order = "ORDER BY date_added DESC";
        $selected_sort = $_GET['sort_by'] ?? 'newest'; 

        switch ($selected_sort) {
            case 'cheapest':
                $order = "ORDER BY price ASC";
                break;
            case 'recommended':
                $order = "ORDER BY rate DESC"; 
                break;
            case 'notrecommended':
                $order = "ORDER BY rate ASC"; 
                break;
            case 'newest':
                $order = "ORDER BY date_added DESC";
                break;
            case 'oldest': 
                $order = "ORDER BY date_added ASC";
                break;
            case 'expensive':
                $order = "ORDER BY price DESC";
                break;
            default:
                $order = "ORDER BY date_added DESC";
                break;
        }

        $membership = $conn->query("SELECT * FROM product WHERE category_id = 1 " . $order);
        $digitalProducts = $conn->query("SELECT * FROM product WHERE category_id = 2 " . $order);
        $stationery = $conn->query("SELECT * FROM product WHERE category_id = 3 " . $order);
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
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link border-bottom border-3 border-primary text-primary" href="services.php">What We Offer</a></li>
                        <?php echo $log?>
                    </ul>
                </div>
            </div>
        </nav>

        

        
       <section class="page-section bg-light" id="products">
    <div class="container px-4 px-lg-5">
        <h2 class="text-center">What We Offer</h2>
        <hr class="divider" />

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs mb-4 justify-content-center" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">Services</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="digital-tab" data-bs-toggle="tab" data-bs-target="#digital" type="button" role="tab">Materials/Items</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="stationery-tab" data-bs-toggle="tab" data-bs-target="#stationery" type="button" role="tab">Stationery</button>
            </li>
        </ul>
        <div class="mb-4 text-end">
                    <form action="services.php" method="GET" id="sortForm"> <label for="sort" class="form-label me-2">Sort by:</label>
                        <select id="sort" name="sort_by" class="form-select d-inline-block w-auto" onchange="this.form.submit()"> 
                            <option value="newest" <?php if ($selected_sort == 'newest') echo 'selected'; ?>>Newest</option>
                            <option value="oldest" <?php if ($selected_sort == 'oldest') echo 'selected'; ?>>Oldest</option> 
                            <option value="cheapest" <?php if ($selected_sort == 'cheapest') echo 'selected'; ?>>Cheapest</option>
                            <option value="expensive" <?php if ($selected_sort == 'expensive') echo 'selected'; ?>>Expensive</option>
                            <option value="recommended" <?php if ($selected_sort == 'recommended') echo 'selected'; ?>>Most Recommended</option>
                            <option value="notrecommended" <?php if ($selected_sort == 'notrecommended') echo 'selected'; ?>>Least Recommended</option>
                        </select>
                    </form>
                </div>
        <!-- Tab Contents -->
        <div class="tab-content" id="productTabsContent">
            <script>
            function updateQuantity(button, change) {
            const input = button.parentNode.querySelector('input[type="number"]');
            let value = Number(input.value) + change;
            input.value = value < 1 ? 1 : value;
            }
            </script>
            <!-- Services Tab -->
            <div class="tab-pane fade show active" id="services" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                     <script>
                        $(document).ready(function() {
                            $("a#fakeanchor").click(function() {
                                $("#submit_this").submit();
                                return false;
                            });
                        });
                    </script>
                    <!-- Bronze Member -->
                     <?php while($row = $membership->fetch_assoc()): ?>
                        <div class="col">
                            <div class="card h-100">
                                <?=
                                $rate_value = "";
                                switch ( htmlspecialchars($row['rate'])){
                                    case 1:
                                        $rate_value = '★☆☆☆☆ (1.0)';
                                        break;
                                    case 2:
                                        $rate_value = '★★☆☆☆ (2.0)';
                                        break;
                                    case 3:
                                        $rate_value = '★★★☆☆ (3.0)';
                                        break;
                                    case 4:
                                        $rate_value = '★★★★☆ (4.0)';
                                        break;
                                    case 5:
                                        $rate_value = '★★★★★ (5.0)';
                                        break;
                                    default :
                                        $rate_value = 'No Rating Yet';
                                        break;
                                }
                                ?>
                                
                                <form method="post" class="mt-auto" <?php echo $redirect?>>
                                <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['product_name']) ?>">
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($row['product_details']) ?></p>
                                    <label class="form-label"><strong>Quantity:</strong></label>
                                    <div class="input-group" style="width: 100%;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(this, -1)">−</button>
                                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1">
                                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(this, 1)">+</button>
                                    </div>
                                    <div class="mb-1"><strong>Rating:</strong> <?= htmlspecialchars($rate_value) ?></div>
                                    <div class="mb-2">Date Added: <?= htmlspecialchars($row['date_added']) ?></div>
                                    
                                </div>
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <div class="card-footer text-muted">
                                        <div class="row">
                                            <div class="col-md-6">₱<?= htmlspecialchars($row['price']) ?></div>
                                            <div class="col-md-6 text-end">
                                                <?php if (!isset($_SESSION['user_data'])): ?>
                                                    <a href="login.php" class="btn btn-primary text-end">
                                                        <i class="fa-solid fa-cart-shopping float-end"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-primary text-end">
                                                        <i class="fa-solid fa-cart-shopping float-end"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Digital Products Tab -->
            <div class="tab-pane fade" id="digital" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <!-- Example Products-->
                    <?php while($row = $digitalProducts->fetch_assoc()): ?>
                        <div class="col">
                            <div class="card h-100">
                                <?=
                                $rate_value = "";
                                switch ( htmlspecialchars($row['rate'])){
                                    case 1:
                                        $rate_value = '★☆☆☆☆ (1.0)';
                                        break;
                                    case 2:
                                        $rate_value = '★★☆☆☆ (2.0)';
                                        break;
                                    case 3:
                                        $rate_value = '★★★☆☆ (3.0)';
                                        break;
                                    case 4:
                                        $rate_value = '★★★★☆ (4.0)';
                                        break;
                                    case 5:
                                        $rate_value = '★★★★★ (5.0)';
                                        break;
                                    default :
                                        $rate_value = 'No Rating Yet';
                                        break;
                                }
                                ?>
                                
                                <form method="post" class="mt-auto">
                                <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['product_name']) ?>">
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($row['product_details']) ?></p>
                                    <label class="form-label"><strong>Quantity:</strong></label>
                                    <div class="input-group" style="width: 100%;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(this, -1)">−</button>
                                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1">
                                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(this, 1)">+</button>
                                    </div>
                                    <div class="mb-1"><strong>Rating:</strong> <?= htmlspecialchars($rate_value) ?></div>
                                    <div class="mb-2">Date Added: <?= htmlspecialchars($row['date_added']) ?></div>
                                    
                                </div>
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <div class="card-footer text-muted">
                                        <div class="row">
                                            <div class="col-md-6">₱<?= htmlspecialchars($row['price']) ?></div>
                                            <div class="col-md-6 text-end">
                                                <?php if (!isset($_SESSION['user_data'])): ?>
                                                    <a href="login.php" class="btn btn-primary text-end">
                                                        <i class="fa-solid fa-cart-shopping float-end"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-primary text-end">
                                                        <i class="fa-solid fa-cart-shopping float-end"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>                 
                    <!-- Add more digital items like Refresher Courses, Worksheets, Journal Kits... -->
                </div>
            </div>

            <!-- Stationery Tab -->
            <div class="tab-pane fade" id="stationery" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 g-4">

                    <!-- Color Pens -->
                    <?php while($row = $stationery->fetch_assoc()): ?>
                        <div class="col">
                            <div class="card h-100">
                                <?=
                                $rate_value = "";
                                switch ( htmlspecialchars($row['rate'])){
                                    case 1:
                                        $rate_value = '★☆☆☆☆ (1.0)';
                                        break;
                                    case 2:
                                        $rate_value = '★★☆☆☆ (2.0)';
                                        break;
                                    case 3:
                                        $rate_value = '★★★☆☆ (3.0)';
                                        break;
                                    case 4:
                                        $rate_value = '★★★★☆ (4.0)';
                                        break;
                                    case 5:
                                        $rate_value = '★★★★★ (5.0)';
                                        break;
                                    default :
                                        $rate_value = 'No Rating Yet';
                                        break;
                                }
                                ?>
                                
                                <form method="post" class="mt-auto">
                                <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['product_name']) ?>">
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($row['product_details']) ?></p>
                                    <label class="form-label"><strong>Quantity:</strong></label>
                                    <div class="input-group" style="width: 100%;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(this, -1)">−</button>
                                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1">
                                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(this, 1)">+</button>
                                    </div>
                                    <div class="mb-1"><strong>Rating:</strong> <?= htmlspecialchars($rate_value) ?></div>
                                    <div class="mb-2">Date Added: <?= htmlspecialchars($row['date_added']) ?></div>
                                    
                                </div>
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <div class="card-footer text-muted">
                                        <div class="row">
                                            <div class="col-md-6">₱<?= htmlspecialchars($row['price']) ?></div>
                                            <div class="col-md-6 text-end">
                                                <?php if (!isset($_SESSION['user_data'])): ?>
                                                    <a href="login.php" class="btn btn-primary text-end">
                                                        <i class="fa-solid fa-cart-shopping float-end"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-primary text-end">
                                                        <i class="fa-solid fa-cart-shopping float-end"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    
                    

                </div>
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
         <script>
            $(document).ready(function () {
                // Store the active tab in localStorage when clicked
                $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    localStorage.setItem('activeTab', $(e.target).attr('data-bs-target'));
                });

                // On page load, check for the saved tab and activate it
                const activeTab = localStorage.getItem('activeTab');
                if (activeTab) {
                    const tabTrigger = new bootstrap.Tab(document.querySelector(`[data-bs-target="${activeTab}"]`));
                    tabTrigger.show();
                }
            });
        </script>
        <!-- <script>
            // Save scroll position before form submits
            window.addEventListener("beforeunload", function () {
                localStorage.setItem("scrollY", window.scrollY);
            });

            // Restore scroll position on load
            window.addEventListener("load", function () {
                const scrollY = localStorage.getItem("scrollY");
                if (scrollY !== null) {
                    window.scrollTo(0, parseInt(scrollY));
                    localStorage.removeItem("scrollY"); // optional: clear after restore
                }
            });
        </script> -->

    </body>
</html>
