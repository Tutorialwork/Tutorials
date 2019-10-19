<?php
session_start();
if(!isset($_SESSION["username"])){
  header("Location: index.php");
  exit;
}
require("rankmanager.php");
if(isBanned($_SESSION["username"])){
  header("Location: logout.php");
  exit;
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Top Secret</h1>
    <br>
    <a href="addnews.php">News hinzufügen</a>
    <br>
    <?php
    if(getRank($_SESSION["username"]) >= MOD){
      if(isset($_GET["id"])){
        require("mysql.php");
        $stmt = $mysql->prepare("SELECT * FROM news WHERE ID = :id");
        $stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 0){
            echo "Die News wurde nicht gefunden.";
        } else {
            $row = $stmt->fetch();
                ?>
                <h1><?php echo $row["TITEL"] ?></h1>
                <p><?php echo $row["NEWS"] ?></p>
                <p><?php echo date("d.m.Y H:i", $row["CREATED_AT"]) ?></p>
                <?php
        }
    } else {
        require("mysql.php");
        $stmt = $mysql->prepare("SELECT * FROM news ORDER BY CREATED_AT DESC LIMIT 3");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 0){
            echo "Es wurden keine News gefunden.";
        } else {
            while($row = $stmt->fetch()){
                ?>
                <h1><?php echo $row["TITEL"] ?></h1>
                <p><?php echo substr($row["NEWS"], 0, 120) ?></p>
                <p><?php echo date("d.m.Y H:i", $row["CREATED_AT"]) ?></p>
                <a href="geheim.php?id=<?php echo $row["ID"] ?>">Read more</a>
                <?php
            }
        }
    }
    } else {
      echo "Du hast keine Rechte die News zu sehen. Du musst mindestens Mod sein.";
    }
    
    ?>
    <br>
    <a href="logout.php">Abmelden</a>
  </body>
</html>
