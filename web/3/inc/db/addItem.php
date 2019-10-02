<?php

require_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_GET['add'] == "category") {
        $name = $_POST['cName'];
        pg_query($db, "INSERT INTO Category (name) VALUES ('$name')");
    } elseif ($_GET['add'] == "item") {
        $name = $_POST['iName'];
        $price = intval($_POST['iPrice']);
        $description = $_POST['iDescription'];
        $category = intval($_POST['iCategory']);
        pg_query($db,"INSERT INTO Item (name,price,description,category) VALUES ('$name',$price,'$description',$category)");
    }
}

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
            <form name="addCategory" action="addItem.php?add=category" method="POST">
                <p>Add Category:</p>
                <input type="text" name="cName" placeholder="Name">
                <button type="submit">Add +</button>
            </form>
            <br>
            <div id="cResult">
                <table>
                    <tr>
                        <th>id_category</th>
                        <th>name</th>
                    </tr>
                <?php
                    foreach (pg_fetch_all(pg_query($db, "SELECT * FROM Category")) as $result) {
                        echo '<tr>';
                            foreach ($result as $r) {
                                echo "<td>$r</td>";
                            }
                        echo '</tr>';
                    }
                ?>
                </table>
            </div>
        </div>
        <div>
            <form name="addItem" action="addItem.php?add=item" method="POST">
                <p>Add Item:</p>
                <input type="text" name="iName" placeholder="Name">
                <input type="text" name="iPrice" placeholder="Price (cents)">
                <input type="text" name="iDescription" placeholder="Description">
                <select name="iCategory">
                    <option value="NULL">None</option>
                    <?php
                        foreach (pg_fetch_all(pg_query($db, "SELECT * FROM Category")) as $result) {
                            echo '<option value="' . $result["id_category"] . '">' . $result["name"] . '</option>';
                        }
                    ?>
                </select>
                <button type="submit">Add +</button>
            </form>
            <br>
            <div id="iResult">
            <table>
                    <tr>
                        <th>id_item</th>
                        <th>name</th>
                        <th>price</th>
                        <th>description</th>
                        <th>category</th>
                    </tr>
                <?php
                    foreach (pg_fetch_all(pg_query($db, "SELECT * FROM Item")) as $result) {
                        echo '<tr>';
                            foreach ($result as $r) {
                                echo "<td>$r</td>";
                            }
                        echo '</tr>';
                    }
                ?>
                </table>
            </div>
        </div>
</body>
</html>
<?php pg_close($db); ?>