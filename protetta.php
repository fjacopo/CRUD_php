<?php
session_start();
if(isset($_SESSION["UTENTE"]))
header('location:database.php');
else
echo "accesso non consentito";
?>