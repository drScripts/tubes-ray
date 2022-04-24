<?php

include '../db/index.php';

$existName = [];

$sql = 'SELECT username FROM users';
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($existName, $row['username']);
    }
}

mysqli_close($connection);

$q = $_GET['q'];

if (strlen($q) > 0) {
    for ($i = 0; $i < count($existName); $i++) {
        if (strtolower($q) == strtolower($existName[$i])) {
            echo 'username sudah dipakai orang lain !';
        } else {
            echo '';
        }
    }
}
