<?php

$db_host = 'localhost'; 
$db_name = 'eventi'; 
$db_user = 'programma'; 
$db_password = '1234'; 

try {
    // Connessione al database usando PDO
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    
    // Imposta l'attributo di PDO per gestire automaticamente gli errori di PDOException
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se si verifica un errore di connessione, mostra un messaggio di errore
    echo "Errore di connessione al database: " . $e->getMessage();
    die(); // Interrompe l'esecuzione dello script
}
?>