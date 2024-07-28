<?php
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
date_default_timezone_set('Africa/Nairobi'); // Nairobi is the capital city of Kenya
require_once('TCPDF/tcpdf.php');

// Function to generate a unique receipt ID
function generateReceiptId() {
    return substr(md5(uniqid()), 0, 8);
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "checkout_form"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
    $marketName = isset($_POST['marketName']) ? $conn->real_escape_string($_POST['marketName']) : '';
    $stallCount = isset($_POST['stallCount']) ? intval($_POST['stallCount']) : 0;
    $totalPrice = isset($_POST['hiddenTotalPrice']) ? floatval(str_replace(',', '.', $_POST['hiddenTotalPrice'])) : 0;

    // Generate a unique receipt ID
    $receiptId = generateReceiptId();

    // Insert data into the database
    $insertQuery = "INSERT INTO checkout_form (receiptId, name, email, phone, marketName, stallCount, totalPrice) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssssds", $receiptId, $name, $email, $phone, $marketName, $stallCount, $totalPrice);

    if ($stmt->execute()) {
        $stmt->close();

        // Fetch data from the database to confirm insertion
        $selectQuery = "SELECT * FROM checkout_form WHERE receiptId = ?";
        $selectStmt = $conn->prepare($selectQuery);
        $selectStmt->bind_param("s", $receiptId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Create PDF
            $pdf = new TCPDF();
            $pdf->AddPage();
            $pdf->SetFont('times', 'B', 10);
            $pdf->Cell(0, 10, 'Receipt Details', 0, 1, 'C');
            $pdf->Ln(10);
            $pdf->Cell(0, 10, 'Receipt ID: ' . $row['receiptId'], 0, 1);
            $pdf->Cell(0, 10, 'Name: ' . $row['name'], 0, 1);
            $pdf->Cell(0, 10, 'Email: ' . $row['email'], 0, 1);
            $pdf->Cell(0, 10, 'Phone: ' . $row['phone'], 0, 1);
            $pdf->Cell(0, 10, 'Market Name: ' . $row['marketName'], 0, 1);
            $pdf->Cell(0, 10, 'Stall Count: ' . $row['stallCount'], 0, 1);
            $pdf->Cell(0, 10, 'Total Price: Ksh ' . $row['totalPrice'], 0, 1);
            $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d H:i:s'), 0, 1); // Add timestamp here
            $pdf->Cell(0, 10, 'Pay Bill No: 12345678', 0, 1);
            $pdf->Cell(0, 10, 'Account: Your Receipt ID', 0, 1);

            // Add other details as needed

            // Output PDF as attachment
            $pdfContent = $pdf->Output('receipt_' . $receiptId . '.pdf', 'S');

            // Set appropriate headers for download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="receipt_' . $receiptId . '.pdf"');
            header('Content-Length: ' . strlen($pdfContent));
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');

            // Output the PDF content
            echo $pdfContent;

            // Exit to prevent additional output
            exit;
        } else {
            echo "Error fetching data from the database.";
        }

        $selectStmt->close();
    } else {
        echo "Error inserting data: " . $stmt->error;
        // You can log the detailed error for debugging purposes
        // error_log("Error: " . $stmt->error);
    }
}

// Close the database connection
$conn->close();
?>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "markets_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the market name from the URL
$marketName = isset($_GET['market']) ? $_GET['market'] : '';

// Fetch the price from the database based on the market name
$query = "SELECT price FROM markets WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $marketName);
$stmt->execute();
$stmt->bind_result($price);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 market Template, Created by Mutai Kevin ">

	<!-- title -->
	<title>Check Out</title>

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
	<!--Head Js-->

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
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Deliver</p>
						<h1>Check Out</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
    

	<!-- check out section -->
    <?php
    $marketName = isset($_GET['market']) ? $_GET['market'] : '';
    ?>
<div class="checkout-section mt-150 mb-150">
    <div class="container-2">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                        <div class="card single-accordion">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Billing for <?php echo $marketName; ?>
                                    </button>
                                </h5>
                            </div>

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="billing-address-form">
						        	<form action="process_form.php" method="post"> 
                                        <p><input type="text" name="name" placeholder="Name" required></p>
                                        <p><input type="email" name="email" placeholder="Email" required></p>
                                        <p><input type="tel" name="phone" placeholder="Phone" required></p>
										<input type="number" name="stallCount" id="stallCount" placeholder="Stalls" oninput="calculateTotalPrice()">
                                        <td><output id="totalPrice" name="totalPrice">0</output></td>
                                        <input type="hidden" name="marketName" value="<?php echo htmlspecialchars($marketName); ?>">
                                        <input type="hidden" name="hiddenTotalPrice" id="hiddenTotalPrice" value="0">
										<p><button type="submit" class="boxed-button">Place Intent</button></p>
                                    </form>
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
    <script>
            var pricePerStall = <?php echo $price; ?>;
            
            document.getElementById("stallCount").addEventListener("input", function() {
                calculateTotalPrice();
            });

            function calculateTotalPrice() {
                var stallCount = document.getElementById("stallCount").value;

                // Calculate total price
                var totalPrice = stallCount * pricePerStall;

                // Display the total price in the output box with the currency symbol
                document.getElementById('totalPrice').innerText = '  Ksh ' + totalPrice;

                document.getElementById('hiddenTotalPrice').value = totalPrice;
            }
    </script>
	<!-- end check out section -->

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

