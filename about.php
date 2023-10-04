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
    <link rel="stylesheet" href="css/stylea.css">
    <style>
        body {
            background-image: url('images/openbook.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        h3 {
            font-family: 'Tektur', cursive;
            top: 118px;
            position: absolute;
            left: 525px;

        }

        .endtext {
            text-align: center;
            margin-left: 225px;
            margin-right: 293px;
            color: black;
            font-weight: bold;
            font-style: italic;
        }



        .begintext {
            text-align: justify;
            color: black;
            margin-left: 240px;
            margin-right: 295px;
            font-weight: bold;
            font-style: italic;

        }

        li {
            color: black;
            font-weight: bold;
            font-style: italic;
            margin-left: 225px;
            margin-right: 293px;

        }


        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
        }
    </style>
</head>

<body>
    <hr style="visibility: hidden;">
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
                        <a class="nav-link active" aria-current="page" href="index.php" onclick="refreshPage()" style="color:white">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color:white">About</a>
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
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/signup.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block mb-3">
                    <h5>Sign-up</h5>
                    <p>Website 101 - create an account first</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/login.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block mb-3">
                    <h5>Login</h5>
                    <p>You are almost there to witness it.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/main.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block mb-3">
                    <h5>The Magic</h5>
                    <p>Add a new note and see the magic below in the datatable.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <?php
    if (isset($_SESSION['signup_success']) && $_SESSION['signup_success'] === true) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your account is now created and you can login using your credentials
        <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION['signup_success']); // Clear the session variable to avoid showing the alert on subsequent page loads
    }
    ?>
    <h3 class="text-center text-white"> Your Secure Notes Keeping App!</h3>
    <p class="begintext">Memento is a powerful and user-friendly notes keeping app that ensures the safety and privacy of your personal notes through encryption using the Caesar cipher. Here are the functionalities and how it works :</p>
    <div class="card" style="width: 18rem; left:285px;">
        <div class="card-body">
            <h5 class="card-title">Add note</h5>
            <p class="card-text">Add a note with title and description.</p>
        </div>
    </div>
    <span>
        <div class="card" style="width: 18rem; left:855px;">
            <div class="card-body">
                <h5 class="card-title">Delete note</h5>
                <p class="card-text">Delete a note once your are done with it.</p>
            </div>
        </div>
    </span>
    <div class="card mt-3" style="width: 18rem; left: 285px;">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <p class="card-text">once adding a note you can edit using edit button which you will have hover.</p>
        </div>
    </div>
    <span>
        <div class="card" style="width: 18rem; left:855px;">
            <div class="card-body">
                <h5 style="align-items: center;" class="card-title">Caesar Cipher</h5>
                <p class="card-text">The description is encrytped using caesar cipher algorithm.</p>
            </div>
        </div>
    </span>
    <ul>
        <li>
            **Secure Registration:** Get started by creating an account with Memento. Simply provide your username and password, and you're all set to use the app!
        </li>
        <li>
            **Protected Login:** After registering, log in securely with your credentials. Memento ensures that your login information is always encrypted, keeping your account safe from unauthorized access.
        </li>
        <li>
            **Create Your Notes:** Once you're logged in, you can start creating your notes. Give each note a title and add your thoughts, ideas, or anything you want to remember in the description section.
        </li>
        <li>
            **Encryption for Privacy:** Your privacy is of utmost importance to us. When you save a note, Memento automatically encrypts the content using the Caesar cipher algorithm, making it unreadable to anyone without the decryption key.
        </li>
        <li>
            **Edit and Update:** Need to make changes to your notes? No problem! You can easily edit and update your existing notes. When you save your edits, the content gets re-encrypted, maintaining your privacy.
        </li>
        <li>
            **Organize and Manage:** Memento helps you keep your notes organized by displaying them in a clean and user-friendly interface. Easily view and manage your notes with just a few clicks.
        </li>
        <li>
            **Automatic Logout:** To enhance security, Memento automatically logs you out after a period of inactivity. This ensures that your notes remain secure even if you accidentally leave your account open.
        </li>
        <li>
            **Enjoy Peace of Mind:** With Memento, you can be confident that your personal thoughts and information are protected. We take privacy seriously, and your encrypted notes are accessible only to you.
        </li>
    </ul>
    <p class="endtext">
        Remember, Memento is designed with your privacy and ease of use in mind. Your notes are encrypted, your data is safe, and your experience is seamless. Start using Memento today and never worry about forgetting important information again!
    </p>
    <script>
        function refreshPage() {
            location.reload();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <hr style="visibility:hidden">
    <hr style="visibility:hidden">

    <?php
    include 'footer.php';
    ?>
</body>

</html>