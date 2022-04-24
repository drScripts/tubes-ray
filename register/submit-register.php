<?php

include '../db/index.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pic = 'assets/users_pic_profile/usericon.png';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //cek apakah ada username yang sama
    $getUsername = "SELECT username FROM users WHERE username = '$username'";
    $cekResult = mysqli_query($connection, $getUsername);
    $num_row = mysqli_num_rows($cekResult);

    if ($num_row == 0) {
        // jika belum ada username yang sama

        //query insert data ke dalam database
        $insertVal = "INSERT INTO users (username, password, email, pic_profile) VALUES ('$username', '$hashedPassword', '$email', '$pic')";
        $result = mysqli_query($connection, $insertVal);

        if ($result) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'cannot';
    }
} else {
    header('Location: ./register');
}
