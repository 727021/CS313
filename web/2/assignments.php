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
            <h1 class="display-4 border-bottom border-secondary">Assignments</h1>
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <caption>Links will become enabled as assignments are completed.</caption>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Week</th>
                            <th scope="col">Assignments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 1; $i <= 14; $i++) { // Make a row for each week ?>
                        <tr>
                            <th class="align-middle" scope="row"><?php echo $i; ?></th>
                            <td class="align-middle">
                                <a role="button" class="btn btn-outline-<?php echo file_exists("../$i/team/index.php") ? "primary" : "secondary disabled" ?>" href="../<?php echo $i ?>/team/">Team</a>
                                <a role="button" class="btn btn-outline-<?php echo file_exists("../$i/index.php") ? "success" : "secondary disabled" ?>" href="../<?php echo $i ?>/">Prove</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include('top.php'); ?>
    <?php include('scripts.php'); ?>
</body>
</html>