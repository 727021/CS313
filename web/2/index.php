<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
</head>
<body>
    <?php include('nav.php'); ?>

    <!-- Main page content -->
    <main class="flex-shrink-0 pl-1 pr-1 pl-md-0 pr-md-0">
        <div class="container border rounded mt-1 mb-2 p-1">
            <h1 class="display-4 border-bottom border-secondary">Home</h1>
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="box">
                        <a class="text-center" href="about.php">About Me</a>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="box">
                        <a class="text-center" href="assignments.php">PHP Assignments</a>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="box">
                        <a class="text-center" href="https://polar-peak-19768.herokuapp.com/">Node Assignments</a>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="box">
                        <a class="text-center" target="_blank" href="https://727021.github.io">Github</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include('top.php'); ?>
    <?php include('scripts.php'); ?>
</body>
</html>