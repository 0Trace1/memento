<?php
// update_encrypted_data.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sno'])) {
    $sno = $_POST['sno'];

    // Perform necessary database connection
    include 'db.php';

    // Retrieve the encrypted data from the database
    $sql = "SELECT encrypted FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $encryptedText = $row['encrypted'];
        $response = array('encrypted' => $encryptedText);
        echo json_encode($response); // Return the encrypted data as JSON
    } else {
        echo "Error: Data not found.";
    }

    // Close the database connection
    mysqli_close($conn);
}
