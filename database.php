<?php
// Configurazione di connessione al database
$servername = "localhost";
$username = "programma";
$password = "1234";
$dbname = "eventi";

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->error);
}

// Funzione per eseguire una query
function executeQuery($sql) {
    global $conn;
    return $conn->query($sql);
}

// Funzione per ottenere tutti gli eventi dal database
function getEventi() {
    $sql = "SELECT 
                eventi.ID_evento,
                eventi.Nome_evento,
                eventi.Data,
                organizzatori.Nome AS Organizzatore_Nome,
                organizzatori.Cognome AS Organizzatore_Cognome,
                luoghi.Nome_luogo,
                luoghi.Indirizzo,
                luoghi.Capacita,
                GROUP_CONCAT(partecipanti.Nome, ' ', partecipanti.Cognome) AS Partecipanti
            FROM 
                eventi
                LEFT JOIN organizzatori ON eventi.ID_organizzatore = organizzatori.ID_organizzatore
                LEFT JOIN luoghi ON eventi.ID_luogo = luoghi.ID_luogo
                LEFT JOIN partecipanti_eventi ON eventi.ID_evento = partecipanti_eventi.ID_evento
                LEFT JOIN partecipanti ON partecipanti_eventi.ID_partecipante = partecipanti.ID_partecipante
            GROUP BY 
                eventi.ID_evento";
    return executeQuery($sql);
}

// Funzione per inserire un nuovo evento nel database
function insertEvento($nome, $data) {
    $nome = sanitizeInput($nome);
    $data = sanitizeInput($data);

    $sql = "INSERT INTO eventi (Nome_evento, Data, ID_organizzatore, ID_luogo) VALUES ('$nome', '$data',1,1)";
    return executeQuery($sql);
}

// Funzione per aggiornare un evento esistente nel database
function updateEvento($idEvento, $nome, $data, $idOrganizzatore, $idLuogo) {
    $nome = sanitizeInput($nome);
    $data = sanitizeInput($data);
    $idOrganizzatore = sanitizeInput($idOrganizzatore);
    $idLuogo = sanitizeInput($idLuogo);

    $sql = "UPDATE eventi SET Nome_evento = '$nome', Data = '$data', ID_organizzatore = '$idOrganizzatore', ID_luogo = '$idLuogo' WHERE ID_evento = '$idEvento'";
    return executeQuery($sql);
}

// Funzione per eliminare un evento dal database
function deleteEvento($idEvento) {
    $idEvento = sanitizeInput($idEvento);

    $sql = "DELETE FROM eventi WHERE ID_evento = '$idEvento'";
    return executeQuery($sql);
}

// Funzione per pulire l'input
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Gestione delle richieste CRUD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $nome = $_POST["nome"];
        $data = $_POST["data"];

        insertEvento($nome, $data);
    } elseif (isset($_POST["update"])) {
        $idEvento = $_POST["id_evento"];
        $nome = $_POST["nome"];
        $data = $_POST["data"];
        updateEvento($idEvento, $nome, $data, $idOrganizzatore, $idLuogo);
    } elseif (isset($_POST["delete"])) {
        $idEvento = $_POST["id_evento"];

        deleteEvento($idEvento);
    }
}

// Ottenere tutti gli eventi dal database
$result = getEventi();

// Verificare se ci sono risultati
if ($result->num_rows > 0) {
    echo "<table id='eventi'>";
    echo "<tr>
            <th>Nome</th>
            <th>Data</th>
            <th>Organizzatore</th>
            <th>Nome Luogo</th>
            <th>Indirizzo</th>
            <th>Capacita</th>
            <th>Azioni</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Nome_evento"] . "</td>";
        echo "<td>" . $row["Data"] . "</td>";
        echo "<td>" . $row["Organizzatore_Cognome"] . "</td>";
        echo "<td>" . $row["Nome_luogo"] . "</td>";
        echo "<td>" . $row["Indirizzo"] . "</td>";
        echo "<td>" . $row["Capacita"] . "</td>";
        echo "<td>
                <form method='post' action=''>
                    <input type='hidden' name='id_evento' value='" . $row["ID_evento"] . "'>
                    <input type='submit' name='edit' value='Modifica'>
                    <input type='submit' name='delete' value='Elimina'>
                </form>
            </td>";
        echo "</tr>";
    }

    echo "</table>";

    // Form per aggiungere un nuovo evento
    echo "<h2>Aggiungi nuovo evento</h2>";
    echo "<form method='post' action=''>
            <label for='nome'>Nome:</label>
            <input type='text' id='nome' name='nome' required><br>
            <label for='data'>Data:</label>
            <input type='date' id='data' name='data' required><br>
            
            <input type='submit' name='add' value='Aggiungi'>
        </form>";
} else {
    echo "Nessun risultato trovato.";
}

// Chiudere la connessione al database
$conn->close();
?>
<style>
/* Stili CSS per la tabella */
table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #e6e6e6;
}

/* Stili CSS per il form di aggiunta evento */
form {
    margin-bottom: 20px;
}

label {
    display: inline-block;
    width: 100px;
    margin-bottom: 10px;
}

input[type='text'], input[type='date'] {
    width: 200px;
    padding: 5px;
    margin-bottom: 10px;
}
</style>