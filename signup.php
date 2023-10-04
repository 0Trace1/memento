<?php
session_start();
$showError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (empty($username) || empty($password) || empty($cpassword)) {
        $_SESSION['signup_error'] = "All fields are required.";
        header('Location: signup.php');
        exit();
    } elseif ($password !== $cpassword) {
        $_SESSION['signup_error'] = "Passwords do not match.";
        header('Location: signup.php');
        exit();
    } else {
        // Use password_hash() for secure password hashing
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Use prepared statements
        $sql = "INSERT INTO users (username, password, tstamp) VALUES (?, ?, current_timestamp())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);

        try {
            if (mysqli_stmt_execute($stmt)) {
                // Signup is successful, set session variable
                $_SESSION['signup_success'] = true;
                $user_id = mysqli_insert_id($conn);
                // Redirect to the index page or any other desired page
                header('Location: index.php');
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            // Check if the error is due to the unique key constraint (duplicate username)
            if ($e->getCode() === 1062) {
                $showError = "Username already exists. Please choose a different username.";
            } else {
                $showError = "Error in signup. Please try again later.";
            }
        }
    }
    // After the catch block
    if ($showError) {
        $_SESSION['signup_error'] = $showError;
        header('Location: signup.php');
        exit();
    }
}

?>

<!-- Rest of your HTML form code remains unchanged -->

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stylesu.css">
    <style>
        body {
            background-image: url('images/book.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        span {
            color: white;
        }
    </style>
</head>

<body>
    <?php
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
        </div>';
    }
    ?>
    <div class="container-fluid mt-3">
        <form style="background:white" method="post">
            <div class="container-fluid" style="background-color:blanchedalmond;">
                <h1 style="color: black;background-color:beige;">Sign Up</h1>
                <p style="color: black;">Please fill in this form to create an account.</p>
                <hr>

                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="username" id="username" required>

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>

                <label for="cpassword"><b>Confirm Password</b></label>
                <input type="password" placeholder="Confirm Password" name="cpassword" id="cpassword" required>


                <p style="color: black;">By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

                <div class="clearfix">
                    <button class="btn btn-outline-dark" type="submit" class="signupbtn">Sign Up</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <?php
    include 'footer.php';
    ?>
</body>

</html>