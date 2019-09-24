<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
    <title>Team Activity</title>
</head>
<body>
    <div class="row">
        <div class="col-12 col-md-4">
            <div id="div1" class="bh">Div 1</div>
        </div>
        <div class="col-12 col-md-4">
            <div id="div2" class="bh">Div 2</div>
        </div>
        <div class="col-12 col-md-4">
            <div id="div3" class="bh">Div 3</div>
        </div>
    </div>

    <button class="btn btn-primary" id="button">Click Me</button>
    <br />
    <input class="form-control" type="text" name="color" id="color">
    <button class="btn btn-primary" id="colorButton">Change Color</button>
    <br />
    <button class="btn btn-primary" id="fade">Hide/Show</button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>
</html>