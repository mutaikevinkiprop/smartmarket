<?php
// signup.php

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
        if ($user_role == 'admin') {
            header("Location: 5f4dcc3b5aa765d61d8327deb882cf99.php");
        } else {
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

<?php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data (you can add more validation)
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Assuming your MySQL server is running on the default XAMPP settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "support_user"; // Replace with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the table
    $sql_insert_data = "INSERT INTO support_user (name, email, phone, subject, message) VALUES ('$name', '$email', '$phone', '$subject', '$message')";

    // Execute the SQL query
    if ($conn->query($sql_insert_data) === TRUE) {
        // Data inserted successfully
        echo '<script type="text/javascript">';
        echo 'alert("Sent! We will get back to you shortly");';
        echo 'window.location.href = "support_user.php";'; // Redirect to the same page or any desired page
        echo '</script>';
    } else {
        echo "Error inserting data: " . $conn->error;
    }

    // Close the connection
    $conn->close();
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
	<title>Contact</title>
	
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
	
<!-- PreLoader -->
<div class="loader">
    <div class="loader-inner">
        <div class="circle"></div>
    </div>
</div>
<!-- PreLoader Ends -->

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
							<li class="current-list-item"><a href="support_user.php">Contact</a></li>
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
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Get 24/7 Support</p>
						<h1>Contact us</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- contact form -->
	<div class="contact-from-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mb-5 mb-lg-0">
					<div class="form-title">
						<h2>Do you have any question?</h2>
						<p>If you have any questions or need further assistance, please don't hesitate to contact our support team. We're here to help you make the most out of your Smart Farm experience!</p>
					</div>
				 	<div id="form_status"></div>
					<div class="contact-form">
						<form action="support_user.php"  method="POST">
							<p>
								<input type="text" placeholder="Name" name="name" id="name" required>
								<input type="email" placeholder="Email" name="email" id="email" required>
							</p>
							<p>
								<input type="tel" placeholder="Phone" name="phone" id="phone" required>
								<input type="text" placeholder="Subject" name="subject" id="subject">
							</p>
							<p><textarea name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea></p>
							<p><button type="submit" class="boxed-button"> Submit </button></p>
						</form>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="contact-form-wrap">
						<div class="contact-form-box">
							<h4><i class="fas fa-map"></i> Our Address</h4>
							<p>Manchester Close <br> Rimpa Estate, Kiserian. <br> Kenya</p>
						</div>
						<div class="contact-form-box">
							<h4><i class="far fa-clock"></i> Active Hours</h4>
							<p>MON - FRIDAY: 8 to 9 PM <br> SAT - SUN: 10 to 8 PM </p>
						</div>
						<div class="contact-form-box">
							<h4><i class="fas fa-address-book"></i> Contact</h4>
							<p>Phone: +254 791 828 824 <br> Email: kevin.m.kiprop@gmail.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end contact form -->

	<!-- find our location -->
	<div class="find-location blue-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<p> <i class="fas fa-map-marker-alt"></i> Find Our Location</p>
				</div>
			</div>
		</div>
	</div>
	<!-- end find our location -->

	<!-- google map section -->
	<div class="embed-responsive embed-responsive-21by9">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.597209502211!2d36.719828274066884!3d-1.4175868985690354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f0696aa3a0429%3A0x7b13e8390495402d!2sThe%20Fortress!5e0!3m2!1sen!2ske!4v1700783188822!5m2!1sen!2ske" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	<!-- end google map section -->


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