<?php
session_start();
if(!isset($_SESSION["username"])){
  header("Location: index.php");
  exit;
}
require("rankmanager.php");
if(getRank($_SESSION["username"]) != ADMIN){
    header("Location: geheim.php");
    exit;
}
if(isBanned($_SESSION["username"])){
  header("Location: logout.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News hinzufügen</title>
</head>
<body>
    <?php
    if(isset($_POST["submit"])){
        require("mysql.php");
        $stmt = $mysql->prepare("INSERT INTO news (TITEL, NEWS, CREATED_AT) VALUES (:titel, :news, :now)");
        $stmt->bindParam(":titel", $_POST["titel"], PDO::PARAM_STR);
        $stmt->bindParam(":news", $_POST["news"], PDO::PARAM_STR);
        $now = time();
        $stmt->bindParam(":now", $now, PDO::PARAM_STR);
        $stmt->execute();
        echo "Die News wurde erfolgreich hinzugefügt.";

    }
    ?>
    <form action="addnews.php" method="post">
        <input type="text" name="titel" placeholder="Titel" required><br>
        <textarea name="news" cols="30" rows="10"></textarea><br>
        <button type="submit" name="submit">Hinzufügen</button><br>
    </form>
</body>
</html>