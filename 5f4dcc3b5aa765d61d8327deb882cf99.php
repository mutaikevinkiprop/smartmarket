
<!-- search.php -->
<?php
date_default_timezone_set('Africa/Nairobi'); // Nairobi is the capital city of Kenya
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "checkout_form";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$receiptData = null;
$alertMessage = "";

// Retrieve data based on the provided receiptId
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receiptId = $_POST["receiptId"];

    $sql = "SELECT * FROM checkout_form WHERE receiptId = '$receiptId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $receiptData = $row; // Store the retrieved data
        if ($row["approved"] === 'approved') {
            $alertMessage = "This receipt was previously approved on " . $row["approval_timestamp"];
        } else {
            // Update the 'Approved' column to 'approved' and add timestamp
            $approvalTimestamp = date("Y-m-d H:i:s");
            $updateSql = "UPDATE checkout_form SET approved = 'approved', approval_timestamp = '$approvalTimestamp' WHERE receiptId = '$receiptId'";
            
            if ($conn->query($updateSql) === TRUE) {
                $alertMessage = "Approved on " . $approvalTimestamp;
                // Update the data to reflect the changes
                $receiptData["approved"] = "approved";
                $receiptData["approval_timestamp"] = $approvalTimestamp;
            } else {
                $alertMessage = "Error updating record: " . $conn->error;
            }
        }
    } else {
        $alertMessage = "No results found.";
    }
}

// Close the connection
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

    <title>Approval - Admin</title>
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
                            <li class="current-list-item"><a href="5f4dcc3b5aa765d61d8327deb882cf99.php">Approvals</a></li>
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
                        <p>Approve Intents</p>
                        <h1>Approvals</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    <h2>Search Receipt</h2>
   
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
                                        Search Receipt
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="billing-address-form">
                                    <form action="5f4dcc3b5aa765d61d8327deb882cf99.php" method="POST">
                                    <input type="text" name="receiptId" required placeholder="Receipt ID" >
                                    <button type="submit" class="boxed-button-5">Search</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display the receipt data -->
                    <?php if ($alertMessage) { ?>
                        <div class="alert alert-info"><?php echo $alertMessage; ?></div>
                    <?php } ?>

                    <?php if ($receiptData) { ?>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Receipt ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>No. of Stalls</th>
                                    <th>Approved</th>
                                    <th>Approval Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $receiptData['receiptId']; ?></td>
                                    <td><?php echo $receiptData['name']; ?></td>
                                    <td><?php echo $receiptData['email']; ?></td>
                                    <td><?php echo $receiptData['phone']; ?></td>
                                    <td><?php echo $receiptData['totalPrice']; ?></td>
                                    <td><?php echo $receiptData['stallCount']; ?></td>
                                    <td><?php echo $receiptData['approved']; ?></td>
                                    <td><?php echo $receiptData['approval_timestamp']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
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
```

In this modified code, we have added a section to display the receipt data in a table format if it is found. The table will be populated with the retrieved data. Additionally, an alert message is displayed to indicate the approval status or any errors encountered during the process.