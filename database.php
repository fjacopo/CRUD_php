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

// Eseguire una query per ottenere i dati dal database
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
LEFT JOIN 
organizzatori ON eventi.ID_organizzatore = organizzatori.ID_organizzatore
LEFT JOIN 
luoghi ON eventi.ID_luogo = luoghi.ID_luogo
LEFT JOIN 
partecipanti_eventi ON eventi.ID_evento = partecipanti_eventi.ID_evento
LEFT JOIN 
partecipanti ON partecipanti_eventi.ID_partecipante = partecipanti.ID_partecipante
GROUP BY 
eventi.ID_evento";
$result = $conn->query($sql);

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

        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Nome_evento"] . "</td>";
        echo "<td>" . $row["Data"] . "</td>";
        echo "<td>" . $row["Organizzatore_Cognome"] . "</td>";
     
        echo "<td>" . $row["Nome_luogo"] . "</td>";
        echo "<td>" . $row["Indirizzo"] . "</td>";
        echo "<td>" . $row["Capacita"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    // Aggiunta del codice JavaScript/jQuery per i filtri
    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script>
            $(document).ready(function () {
                
                $('#eventi').prepend('<tr id=\"filterRow\">' +
                    '<td><input type=\"text\" id=\"filtro1\"></td>' +
                    '<td><input type=\"text\" id=\"filtro2\"></td>' +
                    '<td></td>' +
                    '<td><input type=\"text\" id=\"filtro3\"></td>' +
                    '<td></td>' +
                    '<td><input type=\"text\" id=\"filtro4\"></td>' +
                    '</tr>');

              
                $('#filtro1').on('input', function () {
                    filterColumn(0, $(this).val());
                });

                $('#filtro2').on('input', function () {
                    filterColumn(1, $(this).val());
                });

                $('#filtro3').on('input', function () {
                    filterColumn(3, $(this).val());
                });

                $('#filtro4').on('input', function () {
                    filterColumn(4, $(this).val());
                });

                
                function filterColumn(columnIndex, filterValue) {
                    $('#eventi tr:gt(0)').each(function () {
                        var cellText = $(this).find('td').eq(columnIndex).text();
                        $(this).toggle(cellText.toLowerCase().includes(filterValue.toLowerCase()));
                    });
                }
            });
        </script>";
} else {
    echo "Nessun risultato trovato.";
}

// Chiudere la connessione al database
$conn->close();
?>
<style>
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
</style>