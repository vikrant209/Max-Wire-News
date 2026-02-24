<?php session_start();
unset($_SESSION['loginId']);

header("Location: login.php");?>