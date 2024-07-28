<?php
// common.php

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "Users";

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

$show_login_signup = true;
$show_user_profile = false;

if (isset($_SESSION['user_id'])) {
    $show_login_signup = false;
    $show_user_profile = true;
}

?>

<?php
$pdo = new PDO('mysql:host=localhost;dbname=markets_db', 'root', '');

// Assuming you get the market name from the URL parameter
$marketName = $_GET['name'] ?? '';

// Fetch market details from the database based on the name
$stmt = $pdo->prepare("SELECT * FROM markets WHERE name = :name");
$stmt->bindParam(':name', $marketName);
$stmt->execute();
$market = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 market Template, Created by Mutai Kevin ">

    <!-- title -->
    <title>Single Market</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <script src="app.js" defer></script>
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <!-- magnific popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!-- animate css -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="assets/css/responsive.css">

</head>
<body>
    
    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
    
<!-- header -->
<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">


                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
							<li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="support_user.php">Contact</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="sub-menu">
                                    <li><a href="about.php">About</a></li>
                                    <li><a href="support_user.php">Contact</a></li>
									<li><a href="markets.php">Market</a></li>
                                </ul>
                            </li>
							<li class="current-list-item"><a href="markets.php">Market</a></li>
                            <li>
                                <ul>
                                    <li class="nav-profile" style="<?php echo $show_user_profile ? 'display: block;' : 'display: none;'; ?>">
                                        <a href="#" id="profile-btn"><i class="fas fa-user-circle"></i> <?php echo $_SESSION['username']; ?></a>
                                    </li>
                                    <li class="nav-button" style="<?php echo $show_login_signup ? 'display: ;' : 'display: none;'; ?>">
                                        <a href="#" id="login-btn"><i class="fas fa-sign-in-alt"></i> Sign In</a>
                                    </li>
                                    <li class="nav-button" style="<?php echo $show_login_signup ? 'display: block;' : 'display: none;'; ?>">
                                        <a href="#" id="signup-btn"><i class="fas fa-user-plus"></i> Sign Up</a>
                                    </li>
                                </ul>
                            </li>
                            <li></li>
                        </ul>
                    </nav>
                    <div class="mobile-menu"></div>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end header -->

    
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>See more Details</p>
                        <h1>Single Market</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    
    <!-- single market -->
    <div class="single-market mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="market-image">
                        <a href="markets.php"><img src="<?php echo $market['image_path']; ?>" alt=""></a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-market-content">
                        <h3><?php echo $market['name']; ?></h3>
                        <p class="single-market-pricing"><span>Per Farmers' Stall</span> Ksh <?php echo $market['price']; ?></p>
                        <p><?php echo $market['description']; ?></p>
                        <div class="single-market-form">
                            <button>Proceed to Checkout</button>
                            <p><strong>Categories: </strong><?php echo $market['categories']; ?></p>
                        </div>
                        <h4>Share:</h4>
                        <ul class="market-share">
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fab fa-twitter"></i></a></li>
                            <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    // Function to handle button click, redirect, and update the heading
    function redirectToCheckout() {
        // Extract the market name from the existing content
        var marketName = document.querySelector('.single-market-content h3').innerText;

        // Redirect to process_form.php
        window.location.href = 'process_form.php?market=' + encodeURIComponent(marketName);
    }

    // Attach the function to the button click event
    document.addEventListener('DOMContentLoaded', function () {
        var checkoutButton = document.querySelector('.single-market-form button');
        checkoutButton.addEventListener('click', redirectToCheckout);
    });
</script>

    <!-- end single market -->
    
    <!-- find our location -->
    <div class="find-location blue-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $market['location']; ?> Location</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end find our location -->
    
    <!-- google map section -->
    <div class="embed-responsive embed-responsive-21by9">
        <iframe src="<?php echo $market['google_maps_link']; ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-- end google map section -->
    <br><br><br><br>
    
    <!-- more markets -->
    <div class="more-markets mb-150">
        <div class="container">
            <!-- Display related markets based on the current market's location -->
            <!-- Fetch related markets from the database -->
            <?php
            $stmt = $pdo->prepare("SELECT * FROM markets WHERE location = :location AND name != :name LIMIT 2");
            $stmt->bindParam(':location', $market['location']);
            $stmt->bindParam(':name', $market['name']);
            $stmt->execute();
            $relatedMarkets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
    
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Related</span> markets</h3>
                        <p>Check out other nearby markets. They're connected by location, <?php echo $market['location']; ?> area. Explore these markets to find more opportunities and connections for a convenient and local experience.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($relatedMarkets as $relatedMarket): ?>
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-market-item">
                            <div class="market-image">
                                <a href="single_market.php?name=<?php echo urlencode($relatedMarket['name']); ?>"><img src="<?php echo $relatedMarket['image_path']; ?>" alt=""></a>
                            </div>
                            <h3><?php echo $relatedMarket['name']; ?></h3>
                            <p class="market-price"><span>Per Farmers' Stall</span> Ksh <?php echo $relatedMarket['price']; ?> </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- end more markets -->
    

    <!-- footer -->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title">About us</h2>
                        <p>Welcome to Smart Farm, where innovation meets agriculture! At Smart Farm, we are passionate about revolutionizing the way farmers connect with markets.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box get-in-touch">
                        <h2 class="widget-title">Get in Touch</h2>
                        <ul>
                            <li>The Fortress, Kiserian.</li>
                            <li>kevin.m.kiprop@gmail.com</li>
                            <li>+254 791 828 824</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box pages">
                        <h2 class="widget-title">Pages</h2>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="markets.php">Market</a></li>
                            <li><a href="support_user.php">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box subscribe">
                        <h2 class="widget-title">Subscribe</h2>
                        <p>Subscribe to our mailing list to get the latest updates.</p>
                        <form action="index.php">
                            <input type="email" placeholder="Email">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end footer -->

<!-- copyright -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p>Copyrights &copy; 2023 - <a href="#">Mutai Kevin</a>,  All Rights Reserved.</p>
            </div>
            <div class="col-lg-6 text-right col-md-12">
                <div class="social-icons">
                    <ul>
                        <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end copyright -->

<!-- jquery -->
<script src="assets/js/jquery-1.11.3.min.js"></script>
<!-- bootstrap -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- count down -->
<script src="assets/js/jquery.countdown.js"></script>
<!-- isotope -->
<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
<!-- waypoints -->
<script src="assets/js/waypoints.js"></script>
<!-- owl carousel -->
<script src="assets/js/owl.carousel.min.js"></script>
<!-- magnific popup -->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<!-- mean menu -->
<script src="assets/js/jquery.meanmenu.min.js"></script>
<!-- sticker js -->
<script src="assets/js/sticker.js"></script>
<!-- main js -->
<script src="assets/js/main.js"></script>

</body>
</html>

