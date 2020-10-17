<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Account erstellen</title>
  </head>
  <body>
    <?php

    require_once("mysql.php");

    if(isset($_POST["submit"])){
      $stmt = $mysql->prepare("SELECT * FROM users WHERE username = ?"); //Username überprüfen
      $stmt->execute([$_POST["username"]]);
      $count = $stmt->rowCount();

      if($count == 0){
        if($_POST["pw"] == $_POST["pw2"]){

            //User anlegen
            $stmt = $mysql->prepare("INSERT INTO users (username, passwordHash) VALUES (?, ?)");

            $hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
           
            $stmt->execute([$_POST["username"], $hash]);

            echo "Dein Account wurde angelegt";
          } else {

            echo "Die Passwörter stimmen nicht überein";
          }
      } else {

        echo "Der Username ist bereits vergeben";
      }
    }
     ?>
    <h1>Account erstellen</h1>
    <form action="register.php" method="post">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="pw" placeholder="Passwort" required><br>
      <input type="password" name="pw2" placeholder="Passwort wiederholen" required><br>
      <button type="submit" name="submit">Erstellen</button>
    </form>
    <br>
    <a href="login.php">Hast du bereits einen Account?</a>
  </body>
</html>
