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
            <form action="confirm.php" method="GET" name="checkout">
                <div class="form-row">
                    <div class="col"><input type="text" name="fname" placeholder="First name"></div>
                    <div class="col"><input type="text" name="lname" placeholder="Last name"></div>
                </div>
                <div class="form-row">
                    <div class="col"><input type="text" name="addr1" placeholder="Address Line 1"></div>
                </div>
                <div class="form-row">
                    <div class="col"><input type="text" name="addr2" placeholder="Address Line 2"></div>
                </div>
                <div class="form-row">
                    <div class="col"><input type="text" name="city" placeholder="City"></div>
                    <div class="col"><select name="state"></select></div>
                    <div class="col"><input type="text" name="zip" id="ZIP"></div>
                </div>
                <div class="form-row">
                    <div class="col"><a href="cart.php" class="btn btn-default" role="button">Back to Cart</a></div>
                    <div class="col"><button class="btn btn-success" type="submit">Continue</button></div>
                </div>
            </form>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
    <script src="checkout.js"></script>
</body>
</html>