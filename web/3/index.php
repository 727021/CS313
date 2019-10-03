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
            <h3 class="display-4">Store</h3>
            <div class="table-responsive">
                <table class="table">
                <?php
                    require_once('inc/db/connect.php');
                    $results = pg_fetch_all(pg_query("SELECT * FROM Item"));
                    pg_close($db);
                    foreach ($results as $result) {
                        echo "<tr>
                            <td class='align-middle'>
                                <b>" . $result['name'] . "</b>
                            </td>
                            <td class='align-middle'>
                                <span class='text-truncate'>" . $result['description'] . "</span>
                            </td>
                            <td class='align-middle'>
                                <button type='button' class='btn btn-success' onclick='addToCart(" . $result['id_item'] . ")'><i class='fas fa-cart-plus'></i> \$" . number_format((floatval($result['price']) / 100.0), 2) . "</button>
                            </td>
                        </tr>";
                    }
                ?>
                </table>
            </div>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
</body>
</html>