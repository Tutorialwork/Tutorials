<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer bearbeiten</title>
</head>
<body>
    <?php
    if(isset($_GET["id"])){
        if(!empty($_GET["id"])){
            require("mysql.php");
            if(isset($_POST["submit"])){
                $stmt = $mysql->prepare("UPDATE users SET USERNAME = :user, EMAIL = :email WHERE ID = :id");
                $stmt->execute(array(":user" => $_POST["username"], ":email" => $_POST["email"], ":id" => $_GET["id"]));
                ?>
                <p>Der Benutzer wurde gespeichert.</p>
                <?php
            }
            $stmt = $mysql->prepare("SELECT * FROM users WHERE ID = :id");
            $stmt->execute(array(":id" => $_GET["id"]));
            $row = $stmt->fetch();
            ?>
            <form action="edit.php?id=<?php echo $_GET["id"] ?>" method="post">
                <input type="text" name="username" value="<?php echo $row["USERNAME"] ?>" placeholder="Benutzername" require><br>
                <input type="email" name="email" value="<?php echo $row["EMAIL"] ?>" placeholder="Email" require><br>
                <button name="submit" type="submit">Speichern</button>
            </form>
            <?php
        } else {
            //edit.php?id
            ?>
            <p>Kein Benutzer wurde angefragt</p>
            <?php
        }
    } else {
        //edit.php
        ?>
        <p>Kein Benutzer wurde angefragt</p>
        <?php
    }
    ?>
</body>
</html>