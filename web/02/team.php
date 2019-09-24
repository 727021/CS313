<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Andrew Schimelpfening" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<?php
for ($i = 1; $i <= 10; $i++) {
    echo "<div style='". (($i % 2 == 0) ? "color: red;" : "") . "'>$i</div>";
}
?>
</body>
</html>

