<?php require_once './database/connection.php'; ?>

<?php
session_start();
unset($_SESSION['id']);

header('location: ./login.php');