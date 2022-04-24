<?php
session_start();

if (!isset($_SESSION['users'])) {
    return header('Location: /tubes/login');
    exit(0);
}
