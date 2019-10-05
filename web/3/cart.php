<?php session_start(); ?>
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
        <div class="container mt-1 mb-2 p-1"><!-- TODO Use a button and a modal to set filters -->
            <h3 class="display-4">Cart <small class="text-muted">(<span class="itemTotal"><?php $i = 0; foreach ($_SESSION['cart'] as $sess) { $i += $sess; } echo $i; ?></span>)</small></h3>
            <div class="table-responsive">
                <table class="table">
                    <!--
                        | Name | Price | Quantity | Remove |
                        |------+-------+----------+--------|
                        ...
                        |------+-------+----------+--------|
                        |                     Total: $0.00 |
                    -->
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                    <?php
                        require_once('inc/db/connect.php');
                        $price = 0;
                        $rows = 0;
                        foreach ($_SESSION['cart'] as $id => $items) {
                            if ($items > 0) {
                                $rows++;
                                $result = pg_fetch_assoc(pg_query($db, "SELECT * FROM Item WHERE id_item = $id LIMIT 1"));
                                    echo '<tr>
                                    <td class="align-middle">' . $result['name'] . '</td>
                                    <td class="itemPrice align-middle">$' . number_format(floatval($result['price']) / 100.0, 2) . '</td>
                                    <td class="itemCount align-middle">' . $items . '</td>
                                    <td class="align-middle"><button data-id="' . $id . '" role="button" class="btn btn-danger btn-small removeItem" onclick="removeFromCart(' . $id . ')"><i class="far fa-times-circle"></i></button></td>
                                    </tr>';
                                $price += intval($items) * $result['price'];
                            }
                        }
                        pg_close($db);
                        if ($rows = 0) {
                            echo '<tr><td class="text-center" colspan="4">No items in cart.</td></tr>';
                        }
                    ?>
                    <tr>
                        <th colspan="3"></th>
                        <th>Total:</th>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td id="totalPrice">$<?php echo number_format($price / 100.0, 2); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
</body>
</html>