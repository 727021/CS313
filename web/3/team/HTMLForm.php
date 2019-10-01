<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css">
  <title>Group assignment</title>
</head>

<body>

  <h2>HTML Forms</h2>

  <form method="post" action="PHPForm.php">
    First name:<br>
    <input type="text" name="firstname" value="John">
    <br>
    Email:<br>
    <input type="text" name="email" value="Email Address">
    <br><br>


    <?php
    $majorOptions = array("Computer Science","Web Design and Development","Computer Information Technology", "Computer Engineering");
    ?>
    
    <p>Please select your major:</p>

    <?php
    foreach($majorOptions as $major){
        echo "<input type='radio' name='major' value='$major'> $major<br>";
    }
    ?>
    

    <br>
    <textarea name="comments"></textarea>


    <p>Select all continents visated</p>
    <input type="checkbox" name="continentsVisated[]" value="1"> North America<br>
    <input type="checkbox" name="continentsVisated[]" value="2"> South America<br>
    <input type="checkbox" name="continentsVisated[]" value="3"> Europe<br>
    <input type="checkbox" name="continentsVisated[]" value="4"> Asia<br>
    <input type="checkbox" name="continentsVisated[]" value="5"> Australia<br>
    <input type="checkbox" name="continentsVisated[]" value="6"> Africa<br>
    <input type="checkbox" name="continentsVisated[]" value="7"> Antarctica<br>

    <br>

    <input type="submit" value="Submit">

  </form>


</body>

</html>