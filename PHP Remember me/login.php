<h1>Login</h1>

<?php

    require_once("mysql.php");

    if(isset($_COOKIE["login_cookie"])){
      $stmt = $mysql->prepare("SELECT * FROM users WHERE rememberToken = ?");
      $stmt->execute([$_COOKIE["login_cookie"]]);

      if($stmt->rowCount() == 1){
        $row = $stmt->fetch();

        session_start();
        $_SESSION["username"] = $row["username"];
        header("Location: geheim.php");
      } else {
        setcookie("login_cookie", "", time() - 1);
      }
    }

    if(isset($_POST["submit"])){
      $stmt = $mysql->prepare("SELECT * FROM users WHERE username = ?"); //Username überprüfen
      $stmt->execute([$_POST["username"]]);
      $count = $stmt->rowCount();
      if($count == 1){
        //Username ist frei
        $row = $stmt->fetch();
        if(password_verify($_POST["pw"], $row["passwordHash"])){

          
          if(isset($_POST["rememberme"])){
            $token = bin2hex(random_bytes(16));
            
            $stmt = $mysql->prepare("UPDATE users SET rememberToken = ? WHERE username = ?");
            $stmt->execute([$token, $_POST["username"]]);

            setcookie("login_cookie", $token, time() + (3600*24*360));
          }

          session_start();
          $_SESSION["username"] = $row["username"];
          header("Location: geheim.php");

        } else {
          echo "Der Login ist fehlgeschlagen";
        }
      } else {
        echo "Der Login ist fehlgeschlagen";
      }
    }

?>

<form action="login.php" method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="text" name="pw" placeholder="Passwort" required><br>
    <button type="submit" name="submit">Login</button><br>
    <input type="checkbox" name="rememberme">Angemeldet bleiben
</form>

<a href="register.php">Account anlegen</a>