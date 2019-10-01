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
            <div class="row"><!-- TODO Use a button and a modal to set filters -->
                <div class="d-none d-md-block col-2"><!-- Spacer --></div>
                <div class="col">
                    List of items
                </div>
                <div class="d-none d-md-block col-2"><!-- Spacer --></div>
            </div>
        </div>
    </main>

    <?php include 'inc/top.php'; ?>
    <?php include 'inc/scripts.php'; ?>
</body>
</html>