<!doctype html>
<html lang="en">
  <head>
    <title>Prove 08</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Andrew Schimelpfening" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../prism/prism.css">
    <style>
    a[href="#top"] {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        font-size: 2rem;
        padding: 0 0.75rem;
        display: none;
        border: none;
    }

    pre[class*="language-"] > code {
        max-height: 32rem;
        overflow: auto;
    }
</style>
</head>
  <body>
  <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a href="#" class="navbar-brand">CS313</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a href="../2/index.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                        <li class="nav-item"><a href="../2/about.php" class="nav-link"><i class="fas fa-question"></i> About</a></li>
                        <li class="nav-item"><a href="../2/assignments.php" class="nav-link"><i class="fas fa-list-ul"></i> Assignments</a></li>
                        <li class="nav-item"><a class="nav-link" target="_blank" href="https://727021.github.io"><i class="fab fa-github"></i> Github</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-2 mb-2 border rounded">
        <div class="mb-2 border-bottom border-secondary d-flex justify-content-between align-items-center">
            <h3 class="display-4">Prove 08 <small class="text-muted"><small>index.js</small></small></h3>
            <a href="https://github.com/727021/CS313/tree/master/web/8/index.js" target="_blank" class="btn btn-success" role="button" title="View on GitHub" data-toggle="tooltip" data-placement="left"><i class="fab fa-github"></i></a>
        </div>
        <pre class="line-numbers"><code class="lang-js"><?php echo nl2br(str_replace(' ', '&nbsp;', htmlspecialchars(file_get_contents('index.js')))); ?></code></pre>
    </div>
    <?php include '../2/top.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../2/script.js"></script>
    <script src="../prism/prism.js"></script>
    <script>
    $(function() { Prism.highlightAll(); $('[data-toggle="tooltip"]').tooltip(); })
    </script>
</body>
</html>