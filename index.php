<?php
include 'config/database.php';
include 'includes/navbar.php';

// Fetch categories and products for each category
$categories = $pdo->query("SELECT DISTINCT categoryId, category FROM products")->fetchAll(PDO::FETCH_ASSOC);

$productsByCategory = [];
foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT productId, productName, productImage, description FROM products WHERE categoryId = :categoryId LIMIT 4");
    $stmt->execute(['categoryId' => $category['categoryId']]);
    $productsByCategory[$category['category']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$query = "
    SELECT p.productId, p.productName, p.productImage, p.description, v.price, v.lastUpdated 
    FROM products p
    JOIN vendor_prices v ON p.productId = v.productId
    WHERE v.price > 0
    ORDER BY v.lastUpdated DESC
    LIMIT 10
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$recentProducts = $stmt->fetchAll();

$cpuCategoryId = 1; // Assuming CPUs have a categoryId of 1
$stmt = $pdo->prepare("SELECT p.productId, p.productName, p.description, p.productImage
                       FROM products p
                       JOIN vendor_prices vp ON p.productId = vp.productId
                       WHERE p.categoryId = :cpuCategoryId AND vp.price > 0.00
                       ORDER BY vp.lastUpdated DESC
                       LIMIT 8");
$stmt->execute(['cpuCategoryId' => $cpuCategoryId]);
$cpuProducts = $stmt->fetchAll();

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redesigned Site</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#recent-products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#comparison">Compare</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-primary text-white text-center py-5">
        <h1>Welcome to Our Store</h1>
        <p>Your one-stop destination for the latest products</p>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="py-5 bg-light text-center">
        <div class="container">
            <h2>Discover the Best Products</h2>
            <p>Find the right product for your needs today!</p>
            <a href="#search" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </section>

    <!-- Search Section -->
    <section id="search" class="py-5">
        <div class="container text-center">
            <h2>Search Products</h2>
            <div class="search-container mx-auto">
                <input type="text" id="search" class="form-control" placeholder="Search for products...">
            </div>
        </div>
    </section>

    <!-- Recently Added Products -->
    <section id="recent-products" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center">Recently Added Products</h2>
            <div id="recentProductsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="product1.jpg" class="card-img-top" alt="Product 1">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Product 1</h5>
                                        <p class="card-text">Description of Product 1</p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="product2.jpg" class="card-img-top" alt="Product 2">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Product 2</h5>
                                        <p class="card-text">Description of Product 2</p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="product3.jpg" class="card-img-top" alt="Product 3">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Product 3</h5>
                                        <p class="card-text">Description of Product 3</p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="product4.jpg" class="card-img-top" alt="Product 4">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Product 4</h5>
                                        <p class="card-text">Description of Product 4</p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="product5.jpg" class="card-img-top" alt="Product 5">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Product 5</h5>
                                        <p class="card-text">Description of Product 5</p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="product6.jpg" class="card-img-top" alt="Product 6">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Product 6</h5>
                                        <p class="card-text">Description of Product 6</p>
                                        <a href="#" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#recentProductsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#recentProductsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Your Company. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

