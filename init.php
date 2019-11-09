<form method="POST" action="init.php">
    <input id="dbusername" type="text" name="dbusername" placeholder="MySQL username" required>
    <input id="dbpassword" type="password" name="dbpassword" placeholder="MySQL password" required>
    <input id="dbname" type="text" name="dbname" placeholder="MySQL database" required>
    <input id="servername" type="text" name="servername" placeholder="MySQL server adress" required>
    <input id="username" type="text" name="username" placeholder="username" required>
    <input id="password" type="text" name="password" placeholder="password" required>
    <button id="login-btn" class="login-form" type="submit">Submit</button>
</form>


<?php

if($_POST["dbusername"] != null){
    $dbusername = $_POST["dbusername"];
    $dbpassword = $_POST["dbpassword"];
    $dbname = $_POST["dbname"];
    $servername = $_POST["servername"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
}else{
    die();
}

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DROP TABLE IF EXISTS `users`";
if ($conn->query($sql) === TRUE) {
     echo "<br>Recreated database successfull!<br><br>";
}

// sql to create table
$sql = "CREATE TABLE `users` ( `id` INT(6) NOT NULL AUTO_INCREMENT , `name` TINYTEXT NOT NULL , `iban` VARCHAR(22) NOT NULL , `money` DECIMAL(5,1) NOT NULL , PRIMARY KEY (`id`))";
    
if ($conn->query($sql) === TRUE) {
    echo "Database Setup successfull!<br>";

    echo "<br>Pleasy copy the following content into the 'settings.php' in the 'secure' folder (replace lines 2-8, lines 1 and 9 have to remain there):";


    echo"<br><br><br>
    \$correct_username = '$username';<br>
    \$correct_password = '$password';<br>
    <br>
    \$servername = '$servername';<br>
    \$username = '$dbusername';<br>
    \$password = '$dbpassword';<br>
    \$dbname = '$dbname';<br>
    ";

} else {
    echo "Error creating table: " . $conn->error;
}
?>