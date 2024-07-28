<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If the user submits the signup form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $signup_username = mysqli_real_escape_string($conn, $_POST['signup-username']);
    $signup_password = mysqli_real_escape_string($conn, $_POST['signup-password']);
    $signup_repeat_password = mysqli_real_escape_string($conn, $_POST['signup-repeat-password']);
    $signup_email = mysqli_real_escape_string($conn, $_POST['signup-email']);

    // Check if the password and repeat password match
    if ($signup_password != $signup_repeat_password) {
        $signup_error = "Passwords do not match. Please try again.";
    } else {
        // Check if the email is already registered
        $check_email_query = "SELECT * FROM users WHERE email = '$signup_email'";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            // Email is already registered
            echo '<script>alert("Email is already registered. Please use a different email.");</script>';
        } else {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($signup_password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password, email) VALUES ('$signup_username', '$hashed_password', '$signup_email')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Redirect to the login page after a short delay (e.g., 2 seconds)
                echo '<script>
                        alert("Signup successful! Tap the Sign In icon to Log In.");
                        setTimeout(function() {
                            window.location.href = window.location.href;  // Change the URL to your login page
                        }, 200);
                      </script>';
                exit();
            } else {
                $signup_error = "Error creating user. Please try again.";
            }
        }
    }
}
?>

<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

$show_login_signup = true;
$show_user_profile = false;

// Fetch user details from the database based on the user's session information
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, email, created_at, avatar FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $show_login_signup = false;
        $show_user_profile = true;
    }
    $stmt->close();
}

// Initialize $login_unsuccessful
$login_unsuccessful = false;

/// If the user submits the login form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_username, $db_password, $user_role);
    $stmt->fetch();
    $stmt->close();

    // Verify the password using password_verify
    if ($db_username && password_verify($password, $db_password)) {
        // Set session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['role'] = $user_role;  // Store user role in the session

        // Redirect based on the user role
        if ($user_role == 'superadmin') {
            header("Location: 66ea7b6c66f1f1c1dbb2f22381d3f4a95a15.php");
        } else if ($user_role == 'admin'){
            header("Location: 5f4dcc3b5aa765d61d8327deb882cf99.php");
        } 
        else {
            // Redirect to the current page
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        exit();
    } else {
        $login_unsuccessful = true;
    }
}

// Check if the logout button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    // Redirect to login page or any other page after logout
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>

<?php
if ($login_unsuccessful) {
    echo '<script>alert("Incorrect email or password. Please try again.");</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 market Template, Created by Mutai Kevin ">

    <!-- title -->
    <title>SmartFarm</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
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
                            <li class="current-list-item"><a href="#">Home</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="support_user.php">Contact</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="sub-menu">
                                    <li><a href="about.php">About</a></li>
                                    <li><a href="support_user.php">Contact</a></li>
                                    <li><a href="markets.php">Market</a></li>
                                </ul>
                            </li>
                            <li><a href="markets.php">Market</a></li>
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
                                <li><ul></ul></li>
                            </li>
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

<!-- Signup Modal -->
<div id="signup-modal" class="modal">
    <span class="close" id="close-signup-modal">&times;</span>
    <h2>Sign Up</h2>

    <!-- Add your signup form here -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="text" class="modal-G" name="signup-username" placeholder="Name" required>
        <input type="password" class="modal-G" id="signup-password" name="signup-password" placeholder="Password" required>
        <input type="password" class="modal-G" id="signup-repeat-password" name="signup-repeat-password" placeholder="Repeat Password" oninput="validatePassword()" required>
        <span id="password-error" style="color: red;"></span>
        <input type="email" class="modal-G" name="signup-email" placeholder="Email" required>
        <button type="submit" class="boxed-button-5" name="signup">Sign Up</button>
    </form>
</div>

<!-- Login Modal -->
<div id="login-modal" class="modal">
    <span class="close" id="close-login-modal">&times;</span>
    <h2>Sign In</h2>

    <!-- Add your login form here -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="text" name="email" class="modal-G" placeholder="Email" required>
        <input type="password" class="modal-G" name="password" placeholder="Password" required>
        <button type="submit" class="boxed-button-5" name="login">Sign In</button>
    </form>
</div>

<!-- User Profile Modal -->
<div id="profile-modal" class="modal">
    <span class="close" id="close-profile-modal">&times;</span>
    <h2>
        <div id="avatar-container" style="position: relative;">
            <img src="<?php echo isset($user['avatar']) ? $user['avatar'] : 'N/A'; ?>" alt="User Avatar" class="avatar" id="avatar-img" onclick="openAvatarModal()">
        </div>
        User Profile
    </h2>

    <?php if ($show_user_profile) : ?>
        <!-- User Details -->
        <div class="user-details">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php
                // Fetch user details from the database based on the user's session information
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT id, username, email, created_at, avatar FROM users WHERE id = '$user_id'";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                ?>
                    <div class="user-info">
                        <p><strong>Name:</strong> <?php echo isset($user['username']) ? $user['username'] : 'N/A'; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <p><strong>Joined on:</strong> <?php echo $user['created_at']; ?></p>
                        <!-- Add more user details as needed -->
                    </div>
                <?php } ?>
            <?php else : ?>
                <p>User details not available.</p>
            <?php endif; ?>
        </div>

        <!-- Additional User Actions -->
        <div class="user-actions">
            <h3>Actions</h3>
            <ul>
                <li><a href="#">Change Password</a></li>
                <li>
                    <form method="post" action="">
                        <input type="hidden" name="logout" value="true">
                        <button class="boxed-button-5" type="submit">Logout</button>
                    </form>
                </li>
                <!-- Add more user actions as needed -->
            </ul>
        </div>

    <?php else : ?>
        <p>Please log in to view your profile.</p>
    <?php endif; ?>

    <!-- Modal for uploading a new avatar -->
    <div id="avatar-modal" class="modal">
        <span class="close" id="close-avatar-modal">&times;</span>
        <h2>Upload New Avatar</h2>
        <form action="upload_avatar.php" method="post" enctype="multipart/form-data" id="avatar-upload-form">
            <label for="new-avatar">Choose a new avatar:</label>
            <input type="file" name="new_avatar" id="new-avatar" accept="image/*">
            <button class="boxed-button-5" type="submit" name="upload">Upload</button>
        </form>
    </div>
</div>
<!-- End of user profile modal -->


    <!-- hero area -->
    <div class="hero-area hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 offset-lg-2 text-center">
                    <div class="hero-text">
                        <div class="hero-text-tablecell">
                            <p class="subtitle">Smart Farm</p>
                            <h1>Empowering Agriculture with Smart Solutions</h1>
                            <div class="hero-btns">
                                <a href="markets.php" class="boxed-btn">Market Collection</a>
                                <a href="support_user.php" class="bordered-btn">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end hero area -->

    <!-- Market section -->
    <div class="market mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title"> 
                        <h3><span class="orange-text">Available</span> Markets</h3>
                        <p>Dive into our extensive list of available markets, each offering unique opportunities for farmers to showcase their produce.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-market-item">
                        <div class="market-image">
                            <a href="markets.php"><img src="assets/img/markets/market-img-1.jpg" alt=""></a>
                        </div>
                        <h3>Chandrana Foodplus</h3>
                        <p class="market-price"><span>Per Farmers' Stall</span> Ksh 260.00 </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-market-item">
                        <div class="market-image">
                            <a href="markets.php"><img src="assets/img/markets/market-img-2.jpg" alt=""></a>
                        </div>
                        <h3>Fresh Choice</h3>
                        <p class="market-price"><span>Per Farmers' Stall</span> Ksh 299.00 </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0 text-center">
                    <div class="single-market-item">
                        <div class="market-image">
                            <a href="markets.php"><img src="assets/img/markets/market-img-5.jpg" alt=""></a>
                        </div>
                        <h3>Gebewa Grocers</h3>
                        <p class="market-price"><span>Per Farmers' Stall</span> Ksh 260.00 </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Market section -->

    <!-- testimonail-section -->
    <div class="testimonail-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <div class="testimonial-sliders">
                        <div class="single-testimonial-slider">
                            <div class="client-avater">
                                <img src="assets/img/avaters/avatar1.jpg" alt="">
                            </div>
                            <div class="client-meta">
                                <h3>Beatrice Tanui <span>Vegetable Farmer</span></h3>
                                <p class="testimonial-body">
                                    " Smart Farm transformed my business! Through their platform, I connected with premium markets, reaching customers who appreciate organic produce. Their seamless process and market connections boosted my sales. "
                                </p>
                                <div class="last-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </div>
                        <div class="single-testimonial-slider">
                            <div class="client-avater">
                                <img src="assets/img/avaters/avatar2.jpg" alt="">
                            </div>
                            <div class="client-meta">
                                <h3>Kevin Kiprop <span>Dairy Farmer</span></h3>
                                <p class="testimonial-body">
                                    " I can't thank Smart Farm enough for simplifying my dairy sales. Their platform linked me with local markets seeking fresh dairy markets. Smart Farm's user-friendly interface and reliable market connections made my farm thrive. "
                                </p>
                                <div class="last-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </div>
                        <div class="single-testimonial-slider">
                            <div class="client-avater">
                                <img src="assets/img/avaters/avatar3.jpg" alt="">
                            </div>
                            <div class="client-meta">
                                <h3>Juliet Chepkurui <span>Fruit Farmer</span></h3>
                                <p class="testimonial-body">
                                    " Smart Farm exceeded my expectations! They connected my Fruit farm with diverse markets, allowing me to showcase my fruits to a wider audience. "
                                </p>
                                <div class="last-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end testimonail-section -->
    
    <!-- advertisement section -->
    <div class="abt-section mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <br><br><br><br>
                    <style>
                    .video-mask{
                        width: 530px;
                        height: 300px;
                        border-radius: 10px; 
                        overflow: hidden; 
                    }
                    body::-webkit-scrollbar {
  display: none; }
                    </style>
                    <div class="video-mask">
                        <iframe width="530" height="300" src="https://youtube.com/embed/POkYTJoJNB0?autoplay=1&mute=1">
                        </iframe>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="abt-text">
                        <p class="top-sub">Since Year 2023</p>
                        <h2>We are <span class="orange-text">Smart Farm</span></h2>
                        <p>Our mission at Smart Farm is to empower farmers and enhance the agricultural industry by providing a reliable and user-friendly platform. We strive to reduce uncertainties for sellers, eliminate challenges related to market congestion and dumping, and boost sales for farmers.</p>
                        <p>Through cutting-edge technology and strategic allocation methods, we aim to streamline the process of selling agricultural markets, making it easier, faster, and more organized.</p>
                        <a href="about.php" class="boxed-btn mt-4">know more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end advertisement section -->

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

