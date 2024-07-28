<?php
// Replace these values with your actual database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Validate input (you can add more validation if needed)

    // Update user role in the database
    $sql = "UPDATE users SET role = '$role' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "User with email '$email' updated successfully with role '$role'";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <!-- admin style-->
    <link rel="stylesheet" href="assets/css/admin.css">

    <title>Admin Panel - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
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
                            <li><a href="66ea7b6c66f1f1c1dbb2f22381d3f4a95a15.php">Register Markets</a></li>
                            <li class="current-list-item"><a href="5e884898da28047151d0e56f8dc629277.php">Administrators</a></li>
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
						<p>Add/Remove Administrators</p>
						<h1>Administrators</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
    <h2>Add/Remove Administrators</h2>
    <div class="container-2">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                        <div class="card single-accordion">

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="billing-address-form">
                                <form action="5e884898da28047151d0e56f8dc629277.php" method="post" >
                                    <input type="text" name="email" required placeholder="Email"><br>
                                    <select name="role" required placeholder="Role">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select><br>
                                    <input type="submit" value="Update Role">
                                </form>
                                    <h2>Admin User Data</h2>
                                        <?php
                                        // Replace these values with your actual database connection details
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $dbname = "users";

                                        // Create connection
                                        $conn = new mysqli($servername, $username, $password, $dbname);

                                        // Check connection
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }

                                        // Fetch and display admin user data
                                        $sql = "SELECT email, username FROM users WHERE role = 'admin'";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            echo "<table border='1'>
                                                    <tr>
                                                        <th>Email</th>
                                                        <th>Username</th>
                                                    </tr>";

                                            // Output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>" . $row["email"] . "</td>
                                                        <td>" . $row["username"] . "</td>
                                                    </tr>";
                                            }

                                            echo "</table>";
                                        } else {
                                            echo "No admin users found";
                                        }

                                        // Close the database connection
                                        $conn->close();
                                        ?>
								        </div>
						            </div>
						        </div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

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
