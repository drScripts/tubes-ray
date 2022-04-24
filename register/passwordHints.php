<?php

$q = $_GET['q'];

if (strlen($q) < 8) {
    echo " <span style='color:red;'>minimal password: 8 karakter !</span>";
} else {
    echo '';
}
?>
