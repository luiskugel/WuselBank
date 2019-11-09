<?php
require("secure/settings.php");

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT money, iban, name FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "name iban kontostand<br>"; 
    while($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $money = $row["money"];
        $iban = $row["iban"];
        echo "$name $iban $money<br>";            
    }
}else{
    echo "Kein Nutzer gefunden!";
}


echo "<br><br>Bitte löschen Sie sowohl die init.php als auch die list.php nach dem Gebrauch!";

$conn->close();
echo $response;

?>