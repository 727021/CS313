<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once('connect.php');

    $results = array();

    if ($_GET['add'] == "category") {
        $name = $_POST['name'];
        pg_query($db, "INSERT INTO Category (name) VALUES ('$name')");
        $results = pg_fetch_all(pg_query($db, "SELECT * FROM Category"));
    } elseif ($_GET['add'] == "item") {
        $name = $_POST['name'];
        $price = intval($_POST['price']);
        $description = $_POST['description'];
        $category = intval($_POST['category']);
        pg_query($db,"INSERT INTO Item (name,price,description,category) VALUES ('$name',$price,'$description',$category)");
        $results = pg_fetch_all($pg_query($db, "SELECT * FROM Item"));
    } else {
        pg_close($db);
        exit();
    }

    foreach ($results as $result) {
        var_dump($result);
        echo '<br>';
    }

    pg_close($db);
} else {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Andrew Schimelpfening" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Item</title>
    <style>
        div {
            border: 1px solid black;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
        <div>
            <form name="addCategory" action="<?php echo (strpos($_SERVER['PHP_SELF'], '?') === false ? $_SERVER['PHP_SELF'] : split('/\?/', $_SERVER['PHP_SELF'])[0]); ?>">
                <p>Add Category:</p>
                <input type="text" name="cName" placeholder="Name">
                <button type="button" onclick="addCategory">Add +</button>
            </form>
            <hr>
            <div id="cResult"></div>
        </div>
        <div>
            <form name="addItem" action="<?php echo (strpos($_SERVER['PHP_SELF'], '?') === false ? $_SERVER['PHP_SELF'] : split('/\?/', $_SERVER['PHP_SELF'])[0]); ?>">
                <p>Add Item:</p>
                <input type="text" name="iName" placeholder="Name">
                <input type="text" name="iPrice" placeholder="Price (cents)">
                <input type="text" name="iDescription" placeholder="Description">
                <select name="iCategory">
                    <option value="NULL">None</option>
                    <?php
                        require_once('connect.php');

                        foreach (pg_fetch_all(pg_query($db, "SELECT * FROM Category")) as $result) {
                            echo '<option value="' . $result[0] . '">' . $result[1] . '</option>';
                        }

                        pg_close($db);
                    ?>
                </select>
                <button type="button" onclick="addItem">Add +</button>
            </form>
            <hr>
            <div id="iResult"></div>
        </div>

        <script>
            function addItem() {
                let name = document.addItem.iName.value;
                let price = document.addItem.iPrice.value;
                let description = document.addItem.iDescription.value;
                let category = document.addItem.iCategory.value;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange =  function() {
                    if (this.readyState = 4 && this.status == 200) {
                        document.getElementById("iResults").innerHTML = this.responseText;
                    }
                }
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>?add=item", true);
                xhttp.send(`name=${name}`);
            }

            function addCategory() {
                let name = document.getElementById("cName").value;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange =  function() {
                    if (this.readyState = 4 && this.status == 200) {
                        document.getElementById("cResults").innerHTML = this.responseText;
                    }
                }
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>?add=category", true);
                xhttp.send(`name=${name}`);
            }
        </script>
</body>
</html>
<?php } ?>