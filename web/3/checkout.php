<?php
session_start();

require_once('inc/db/connect.php');
$price = 0;
foreach ($_SESSION['cart'] as $id => $items) {
    if ($items > 0) {
        $result = pg_fetch_assoc(pg_query($db, "SELECT * FROM Item WHERE id_item = $id LIMIT 1"));
        $price += intval($items) * $result['price'];
    }
}
pg_close($db);

function sanitize($data) {
    return trim(htmlspecialchars($data));
}

$states = array('Alabama','Alaska','American Samoa','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Federated States of Micronesia','Florida','Georgia','Guam','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Marshall Islands','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Northern Mariana Islands','Ohio','Oklahoma','Oregon','Palau','Pennsylvania','Puerto Rico','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virgin Island','Virginia','Washington','West Virginia','Wisconsin','Wyoming');
$fname = $lname = $addr1 = $addr2 = $city = $zip = "";
$state = "Alabama";
$valid = array("fname" => 0, "lname" => 0, "addr1" => 0, "addr2" => 0, "city" => 0, "state" => 0, "zip" => 0);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fname = sanitize($_POST['fname']);
    $lname = sanitize($_POST['lname']);
    $addr1 = sanitize($_POST['addr1']);
    $addr2 = sanitize($_POST['addr2']);
    $city = sanitize($_POST['city']);
    $state = sanitize($_POST['state']);
    $zip = sanitize($_POST['zip']);

    $valid['fname'] = (preg_match("/^[A-Za-z\-]+$/", $fname) === 0) ? -1 : 1;
    $valid['lname'] = (preg_match("/^[A-Za-z\-]+$/", $lname) === 0) ? -1 : 1;
    $valid['addr1'] = (preg_match("/^\d+ [A-Za-z\-\. ]+$/", $addr1) === 0) ? -1 : 1;
    $valid['city'] = (preg_match("/^[A-Za-z\- ]+$/", $lname) === 0) ? -1 : 1;
    $valid['state'] = (in_array($state, $states)) ? 1 : -1;
    $valid['zip'] = (preg_match("/^\d{5}(\-\d{4})?$/", $zip) === 0) ? -1 : 1;

    $allValid = true;
    foreach ($valid as $v) { if ($v < 0) { $allValid = false; } }

    if ($allValid) { // Store form values in $_SESSION['checkout'] and redirect
        $_SESSION['checkout'] = array('fname' => $fname, 'lname' => $lname, 'addr1' => $addr1, 'addr2' => $addr2, 'city' => $city, 'state' => $state, 'zip' => $zip);
        header('location: confirm.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.php'; ?>
    <title><?php echo $title; ?> - Store</title>
</head>
<body>
    <?php include 'inc/nav.php'; ?>

    <!-- Main page content -->
    <main class="flex-shrink-0 pl-1 pr-1 pl-md-0 pr-md-0">
        <div class="container mt-1 mb-2 p-1">
            <h3 class="display-4">Checkout</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="checkout" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col">
                        <input class="form-control<?php echo ($valid['fname'] < 0) ? ' is-invalid' : ($valid['fname'] > 0) ? ' is-valid' : ''; ?>" type="text" name="fname" id="fname" placeholder="First name" value="<?php echo $fname; ?>" required>
                        <div class="invalid-feedback">Please provide a first name.</div>
                    </div>
                    <div class="col">
                        <input class="form-control<?php echo ($valid['lname'] < 0) ? ' is-invalid' : ($valid['lname'] > 0) ? ' is-valid' : ''; ?>" type="text" name="lname" id="lname" placeholder="Last name" value="<?php echo $lname; ?>" required>
                        <div class="invalid-feedback">Please provide a last name.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control<?php echo ($valid['addr1'] < 0) ? ' is-invalid' : ($valid['addr1'] > 0) ? ' is-valid' : ''; ?>" type="text" name="addr1" id="addr1" placeholder="Address Line 1" value="<?php echo $addr1; ?>" required>
                        <div class="invalid-feedback">Please provide a valid address.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col"><input class="form-control<?php echo ($valid['addr2'] < 0) ? ' is-invalid' : ($valid['addr2'] > 0) ? ' is-valid' : ''; ?>" type="text" name="addr2" id="addr2" placeholder="Address Line 2" value="<?php echo $addr2; ?>" ></div>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control<?php echo ($valid['city'] < 0) ? ' is-invalid' : ($valid['city'] > 0) ? ' is-valid' : ''; ?>" type="text" name="city" id="city" placeholder="City" value="<?php echo $city; ?>" required>
                        <div class="invalid-feedback">Please provide a city.</div>
                    </div>
                    <div class="col"><select class="form-control<?php echo ($valid['state'] < 0) ? ' is-invalid' : ($valid['state'] > 0) ? ' is-valid' : ''; ?>" name="state" id="state" value="<?php echo $state; ?>" required></select></div>
                    <div class="col"><input class="form-control<?php echo ($valid['zip'] < 0) ? ' is-invalid' : ($valid['zip'] > 0) ? ' is-valid' : ''; ?>" type="text" name="zip" id="zip" placeholder="ZIP" value="<?php echo $zip; ?>" required></div>
                </div>
                <div class="row">
                    <div class="col text-left"><a href="cart.php" class="btn btn-primary" role="button">Back to Cart</a></div>
                    <div class="col text-right"><button class="btn btn-success" type="submit">Checkout ($<?php echo number_format($price / 100.0, 2); ?>)</button></div>
                </div>
            </form>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
    <script src="checkout.js"></script>
</body>
</html>