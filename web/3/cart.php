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
            <h3 class="display-4">Cart<small class="text-muted"><?php $i = 0; foreach ($_SESSION['cart'] as $sess) { $i += $sess; } echo $i; ?> items</small></h3>
            <div class="table-responsive">
                <table class="table">
                    <!--
                        | Name | Price | Quantity | Remove |
                        |------+-------+----------+--------|
                        ...
                        |------+-------+----------+--------|
                        |                     Total: $0.00 |

                    -->
                </table>
            </div>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
</body>
</html>