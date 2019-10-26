<?php
require("secure/settings.php");
session_start();

if($_SESSION["login"] != true){
    echo "Bitte logge dich erneut ein!";
    die();
}

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$operation = $_REQUEST["operation"];
$iban = $_REQUEST["iban"];
$name = $_REQUEST["name"];
$value = $_REQUEST["value"];
$iban2 = $_REQUEST["iban2"];



$sql = "SELECT money FROM users WHERE iban = '$iban'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($operation !== "payment-deposit"){
            $balance = $row["money"] - $value;
            $IBANexists = true;
        }
        
    }
}else{
    $balance = 0;
    $IBANexists = false;
}

$response = "";

if($operation == "balance"){
    $sql = "SELECT money, iban, name FROM users WHERE iban = '$iban' OR name = '$iban'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $money = $row["money"];
            $iban = $row["iban"];
            echo "Name: $name <br> IBAN: $iban <br> Kontostand: $money";            
        }
    }else{
        echo "Kein Nutzer gefunden!";
    }
    die();
}

if($balance >= 0){
    switch ($operation) {
        case "payment-withdraw":
            $sql = "UPDATE users SET money = money - $value WHERE iban='$iban'";
            break;
        case "payment-deposit":
            $sql = "UPDATE users SET money = money + $value WHERE iban='$iban'";
            break;
        case "transfer":
            $sql = "UPDATE users SET money = money - $value WHERE iban='$iban'";
            $conn->query($sql);
            $sql = "UPDATE users SET money = money + $value WHERE iban='$iban2'";
            break;
        case "management-create":
            if(!$IBANexists){
                $sql = "INSERT INTO users (name, iban, money) VALUES ('$name', '$iban', $value)";
            }
            break;
        default:       
    }
    
    if ($conn->query($sql) === TRUE) {
        $response = "Erfolgreich!";
    } else {
        $response = "Fehler:" . $conn->error;
    }
}else{
    $response = "Kontostand zu gering!";
}





$conn->close();
echo $response;

?>