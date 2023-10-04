<?php
session_start();


// check to see if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: login.php");
  exit();
}

$insert = false;
$update = false;
$delete = false;

// database
include 'db.php';
// Function for Caesar cipher encryption
function caesarEncrypt($text, $shift)
{
  $result = '';
  $length = strlen($text);

  for ($i = 0; $i < $length; $i++) {
    $char = $text[$i];

    // Encrypt uppercase characters
    if (ctype_upper($char)) {
      $result .= chr((ord($char) + $shift - 65) % 26 + 65);
    }
    // Encrypt lowercase characters
    elseif (ctype_lower($char)) {
      $result .= chr((ord($char) + $shift - 97) % 26 + 97);
    }
    // Ignore non-alphabet characters
    else {
      $result .= $char;
    }
  }

  return $result;
}
// delete the record
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $delete = true;
    header("Location: home.php");
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

// check to see if server method is post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    // Update the record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
    $shift = 3;
    // Encrypt the edited description before updating it into the database
    $encryptedDescription = caesarEncrypt($description, 3);
    // SQL update query
    $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description', `encrypted` = '$encryptedDescription' WHERE `notes`.`sno` = $sno";

    $result = mysqli_query($conn, $sql);
    if ($result) {
      $update = true;
    } else {
      mysqli_error($conn);
    }
  } else {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $user_id = $_SESSION['user_id']; // Get the user ID from the session
    $shift = 3;
    // Encrypt the description before inserting it into the database
    $encryptedDescription = caesarEncrypt($description, 3);
    // sql query to be executed
    $sql = "INSERT INTO notes (sno, title, description,encrypted, user_id, tstamp) VALUES (NULL, '$title','$description','$encryptedDescription','$user_id', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $insert = true;
    } else {
      mysqli_error($conn);
    }
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Memento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      // Handle encrypt button click
      $('.encrypt-btn').click(function() {
        var sno = $(this).data('sno');
        $.ajax({
          type: 'POST',
          url: 'update_encrypted_data.php',
          data: {
            sno: sno
          },
          success: function(response) {
            // Update the table cell with the encrypted data
            $('#row-' + sno + ' .description-cell').text(response.encrypted);
          },
          error: function(xhr, status, error) {
            console.log("Error getting encrypted data:", error);
          }
        });
      });
    });
  </script>


  <!-- <style>
    body {
      background-image: url('images/openbook.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }
  </style> -->
  <style>
    h1 {
      font-family: 'Tektur', cursive;
      text-align: center;
    }

    .description {
      position: absolute;
      left: 5px;
    }

    .description-cell {
      position: relative;
    }

    .description-cell:hover .description {
      display: block;
      position: absolute;
      top: 5px;
      right: 100px;

      border: 0ch;
      padding: 5px;
      z-index: 1;
      color: white;
    }

    .description-cell .description {
      display: none;
    }


    /* CSS to position the button to the top-right corner */
    .btncontainer {
      position: fixed;
      top: 30px;
      right: 108px;
    }
  </style>

</head>

<body>
  <!-- Modal -->
  <div class='modal fade' id='editModal' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h1 class='modal-title fs-5' id='editModalLabel'>Edit this Note</h1>
          <button type='button' class='btn-close' data-dismiss='modal' aria-label='Close'></button>
        </div>
        <form action='/memento/home.php' method='POST'>
          <div class='modal-body'>
            <input type='hidden' name='snoEdit' id='snoEdit'>
            <div class='mb-3'>
              <label for='title' class='form-label'>Note Title</label>
              <input type='text' class='form-control' id='titleEdit' name='titleEdit' aria-describedby='emailHelp'>
              <div class='mb-3'>
                <label for='description' class='form-label'>Note Description</label>
                <textarea class='form-control' id='descriptionEdit' name='descriptionEdit' rows='3'></textarea>
              </div>
            </div>
          </div>
          <div class='modal-footer mr-auto'>
            <button type='button' class='btn btn-dark' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-dark'>Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Note has been <b>INSERTED</b>.
    <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Note has been <b>UPDATED</b>.
    <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Note has been <b>DELETED</b>.
    <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <div class="container my-3">
    <h1>WELCOME <?php echo strtoupper($_SESSION['username']); ?></h1>
    <div class="btncontainer">
      <form class="d-flex" action="logout.php">
        <button class="btn btn-outline-danger" type="submit">Logout</button>
    </div>
    </form>
    <h2>Save your moments</h2>
    <form action="/memento/home.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <div class="mb-3">
          <label for="description" class="form-label">Note Description</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-dark">Add Note</button>
    </form>
  </div>

  <div class="container" mt-3 my-4>
    <table class="table table-dark table-stripped" id="myTable">

      <thead>
        <tr>
          <th scope="col">SNo</th>
          <th scope="col">Title</th>
          <th scope="col">Encryption</th>
          <th style="width:125px" scope="col">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp; |&nbsp;&nbsp;Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Fetch data specific to the logged-in user 
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM `notes` WHERE user_id= $user_id";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $sno + 1;
          echo "<tr>
      <th style='height:60px;'scope='row'>" . $sno . "</th>
      <td style='height:60px;'>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</td>
      <td style='height:60px;'class='description-cell'>
      <span style='top:33px;'class='description'>" . htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') . "</span> 
      <span data-toggle='tooltip' data-placement='right' title='" . $row['description'] . "'>" . $row['encrypted'] . "</span>
    </td>
      <td style='height:60px;'>  <button type='button' class='edit btn btn-outline-dark'id=" . $row['sno'] . ">Edit</button> 
      <button type='button' class='delete btn btn-outline-dark'id=d" . $row['sno'] . ">Delete</button>
      </tr>";
        }
        ?>

      </tbody>
    </table>
  </div>
  <hr>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit", );
        tr = e.target.parentNode.parentNode
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("span")[0].innerText;
        console.log(title, description)
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        document.getElementById('titleEdit').value = title;
        document.getElementById('descriptionEdit').value = description;
        document.getElementById('snoEdit').value = e.target.id;

        // modal toggle
        $('#editModal').modal('toggle');
      })
    })
  </script>
  <script>
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note?")) {
          console.log("yes");
          window.location = `/memento/home.php?delete=${sno}`;
        } else {
          console.log("no");
        }
      })
    })
  </script>
  <script>
    $(document).ready(function() {
      // Handle show description button click
      $('.show-description-btn').click(function() {
        var sno = $(this).data('sno');
        var descriptionCell = $('#row-' + sno + ' .description-cell');

        if (descriptionCell.hasClass('hidden-description')) {
          // Show the description
          var description = descriptionCell.find('.hidden-description').text();
          descriptionCell.html(description);
          descriptionCell.removeClass('hidden-description');
        } else {
          // Hide the description
          var description = descriptionCell.text();
          descriptionCell.html('<span class="hidden-description">' + description + '</span>');
          descriptionCell.addClass('hidden-description');
        }
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      // Initialize Bootstrap tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
          title: function() {
            return $(tooltipTriggerEl).next('.hidden-description').text();
          }
        });
      });
    });
  </script>

  <?php
  include 'footer.php';
  ?>
</body>

</html>