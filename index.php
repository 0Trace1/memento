<?php
session_start();

include 'db.php';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tektur&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stylei.css">
    <style>
        body {
            background-image: url('images/e_book.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <h1 class="text-center">Welcome to Memento</h1>
    <nav class="navbar navbar-expand-lg" style="background-color:black">
        <div class="container">
            <a class="navbar-brand" href="#" style="color:white"><img src="images/blank-post-it-note-4.png" height='40px' alt=""></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#" onclick="refreshPage()" style="color:white">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php" style="color:white">About</a>
                    </li>
                </ul>
                <div class="form-container">
                    <form action="login.php" id="login">
                        <button class="btn btn-outline-success" type="submit">Login</button>
                    </form>
                    <form action="signup.php" id="signup">
                        <button class="btn btn-outline-success" type="submit">Signup</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
    </nav>
    <?php
    if (isset($_SESSION['signup_success']) && $_SESSION['signup_success'] === true) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>Success!</strong> Your account is now created and you can login using your credentials
<button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
</div>";
        unset($_SESSION['signup_success']); // Clear the session variable to avoid showing the alert on subsequent page loads
    }
    ?>
    <script>
        function refreshPage() {
            location.reload();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <?php
    include 'footer.php';
    ?>
</body>

</html>