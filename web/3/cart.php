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
            <h3 class="display-4">Cart <small class="text-muted">(<?php $i = 0; foreach ($_SESSION['cart'] as $sess) { $i += $sess; } echo $i; ?>)</small></h3>
            <div class="table-responsive">
                <table class="table">
                    <!--
                        | Name | Price | Quantity | Remove |
                        |------+-------+----------+--------|
                        ...
                        |------+-------+----------+--------|
                        |                     Total: $0.00 |
                    -->
                    <?php
                        require_once('inc/db/connect.php');
                        foreach ($_SESSION['cart'] as $id => $items) {
                            if ($items > 0) {
                                $result = pg_fetch_assoc(pg_query($db, "SELECT * FROM Item WHERE id_item = $id LIMIT 1"));
                                print_r($result);
                                    echo '<tr>
                                    <td class="align-middle">' . $result['name'] . '</td>
                                    <td class="align-middle">$' . number_format(floatval($result['price']) / 100.0, 2) . '</td>
                                    <td id="itemCount" class="itemCount align-middle">' . $items . '</td>
                                    <td class="align-middle"><button data-id="' . $id . '" role="button" class="btn btn-danger btn-small removeItem" onclick="removeFromCart(' . $id . ')"><i class="far fa-times-circle"></i></button></td>
                                    </tr>';
                            }
                        }
                        pg_close($db);
                    ?>
                </table>
            </div>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
</body>
</html>