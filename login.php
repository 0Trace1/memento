<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT user_id, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            $hashedPassword = $row['password'];

            // Verify the password using password_verify()
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, set session variables and log in the user
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                header("location: home.php"); // Redirect to the home page or any other desired page
                exit();
            } // User not found
            $showError = "Invalid credentials.";
        }
    } else {
        $showError = "Username and password are required.";
    }

    // Display the error message, if any

    header("location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="css/stylel.css">
    <style>
        body {
            background-image: url('images/book.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        footer {
            background: black;
            color: wheat
        }
    </style>



</head>

<body>

    <div class="container1">
        <h2 style="font-family: 'Tektur', cursive;">LOGIN</h2>
    </div>
    <form method="post">
        <div class="container">
            <label style="color:white" for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button style="background-color: #04AA6D;" class="btn btn-outline-dark" type="submit">Login</button>
        </div>
    </form>
    <?php
    include 'footer.php';
    ?>
</body>

</html>