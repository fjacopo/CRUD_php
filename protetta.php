<?php
session_start();
if(isset($_SESSION["username"]))
header('location:database.php');
else
echo "accesso non consentito";
?>