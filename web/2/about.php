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
            <h1 class="display-4 border-bottom border-secondary">About Me</h1>
            <div class="row">
                <div class="col-1 d-none d-lg-block"></div><!-- Spacer -->
                <div class="col-12 col-sm-6 col-lg-5">
                    <p><span class="lead">Hi, I'm Andrew Schimelpfening.</span> I'm a Computer Science student from central California. This is my fourth semester at Brigham Young University-Idaho. I live in Rexburg with my beautiful wife, Kelly, who I married in May 2019.</p>
                    <p>I served as a full-time missionary for the Church of Jesus Christ of Latter-day Saints in the <a class="text-decoration-none" href="https://goo.gl/maps/uujnHMgK1iyx1m789" target="_blank">Liberia Monrovia mission</a>, from January 2016 to January 2018. I currently work on campus as an early morning custodian.</p>
                    <p>I really enjoy computers and programming. I started learning C# in middle school, and have been writing code ever since. You can see some of my personal projects (some of which are pretty old) on <a class="text-decoration-none" href="https://727021.github.io/projects.html" target="_blank">Github</a>.</p>
                </div>
                <div class="col-12 col-sm-6 col-lg-5">
                    <img src="me.jpg" alt="" class="img-fluid rounded mx-auto d-block">
                </div>
                <div class="col-1 d-none d-lg-block"></div><!-- Spacer -->
            </div>
        </div>
    </main>

    <?php include('top.php'); ?>
    <?php include('scripts.php'); ?>
</body>
</html>