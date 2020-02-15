<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerverwaltung</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
</head>
<body>
    <table>
    <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>erster Login</th>
    <th>letzter Login</th>
    <th>Aktionen</th>
    </tr>

    <?php
    require("mysql.php");

    if(isset($_GET["del"])){
        if(!empty($_GET["del"])){
            $stmt = $mysql->prepare("DELETE FROM users WHERE ID = :id");
            $stmt->execute(array(":id" => $_GET["del"]));
            ?>
            <p>Der Benutzer wurde gelöscht</p>
            <?php
        }
    }

    $stmt = $mysql->prepare("SELECT * FROM users");
    $stmt->execute();
    while($row = $stmt->fetch()){
        ?>
        <tr>
        <td><?php echo $row["ID"] ?></td>
        <td><?php echo $row["USERNAME"] ?></td>
        <td><?php echo $row["EMAIL"] ?></td>
        <td><?php echo date("d.M.Y - H:i", $row["LASTLOGIN"]) ?></td>
        <td><?php echo date("d.M.Y - H:i", $row["FIRSTLOGIN"]) ?></td>
        <td><a href="edit.php?id=<?php echo $row["ID"] ?>"><i class="fas fa-edit"></i></a><a href="index.php?del=<?php echo $row["ID"] ?>"><i class="fas fa-user-minus"></i></a></td>

        </tr>
        <?php
    }
    ?>
    </table>
</body>
</html>