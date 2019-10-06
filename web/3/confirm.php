<?php
session_start();
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
            <h3 class="display-4">Order Confirmation</h3>
            <div class="table-responsive">
                <table class="table">
                    <tr><th colspan="2">Order:</th></tr>
                    <?php
                    require_once('inc/db/connect.php');
                    foreach ($_SESSION['order'] as $id => $items) {
                        if ($items > 0) {
                            $result = pg_fetch_assoc(pg_query($db, "SELECT * FROM Item WHERE id_item = $id LIMIT 1"));
                            echo '<tr>
                            <td class="align-middle">' . $result['name'] . '</td>
                            <td class="align-middle text-center">' . $items . '</td>
                            </tr>';
                        }
                    }
                    pg_close($db);
                    ?>
                    <tr>
                        <th colspan="2">Ship To:</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p>
                                <?php
                                echo $_SESSION['checkout']['fname'] . ' ' . $_SESSION['checkout']['lname'] . '<br>'
                                . $_SESSION['checkout']['addr1']
                                . (($_SESSION['checkout']['addr2'] != '') ? '<br>' . $_SESSION['checkout']['addr2'] : '') . '<br>'
                                . $_SESSION['checkout']['city'] . ', ' . $_SESSION['checkout']['state'] . ' ' . $_SESSION['checkout']['zip'];
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
    <script src="checkout.js"></script>
</body>
</html>