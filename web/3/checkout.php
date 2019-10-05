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
            <form action="confirm.php" method="POST" name="checkout" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col">
                        <input class="form-control" type="text" name="fname" id="fname" placeholder="First name" required>
                        <div class="invalid-feedback">Please provide a first name.</div>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" name="lname" id="lname" placeholder="Last name" required>
                        <div class="invalid-feedback">Please provide a last name.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control" type="text" name="addr1" id="addr1" placeholder="Address Line 1" required>
                        <div class="invalid-feedback">Please provide a valid address.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col"><input class="form-control" type="text" name="addr2" id="addr2" placeholder="Address Line 2"></div>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control" type="text" name="city" id="city" placeholder="City" required>
                        <div class="invalid-feedback">Please provide a city.</div>
                    </div>
                    <div class="col"><select class="form-control" name="state" id="state" required></select></div>
                    <div class="col"><input class="form-control" type="text" name="zip" id="zip" placeholder="ZIP" required></div>
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