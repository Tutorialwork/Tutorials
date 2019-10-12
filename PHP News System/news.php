<?php
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
            <a href="news.php?id=<?php echo $row["ID"] ?>">Read more</a>
            <?php
        }
    }
}
?>