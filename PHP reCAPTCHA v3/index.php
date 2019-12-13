<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    if(isset($_POST["submit"])){
        $request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Leee8cUAAAAAN5-5PnLypW26GewUeqnlld2mbIA&response=".$_POST["token"]);
        $request = json_decode($request);
        if($request->success == true){
            if($request->score >= 0.6){
                mail("tutorialworktv@gmail.com", "Kontaktformular", 'Name: '.$_POST["name"].' Email: '.$_POST["email"].' Priorität: '.$_POST["priorität"].' Nachricht: '.$_POST["message"]);
                ?>
                <h1 style="color: green;">Das Kontaktformular wurde abgesendet!</h1>
                <?php
            } else {
                echo "Die Anfrage wurde aufgrund von Spamverdacht blockiert.";
            }
        } else {
            echo "Es gab einen Fehler mit dem Captcha";
        }
    }
     ?>
    <form action="index.php" method="post">
      <input type="text" name="name" placeholder="Name" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <select name="priorität">
        <option value="hoch">Hoch</option>
        <option value="mittel">Mittel</option>
        <option value="gering">Gering</option>
      </select><br>
      <textarea name="message" rows="8" cols="80" required></textarea><br>
      <input type="hidden" name="token" id="token">
      <button type="submit" name="submit">Absenden</button>
    </form>
    <script src="https://www.google.com/recaptcha/api.js?render=6Leee8cUAAAAAI5CepD3Fa4qxaAVOqK9A2xKz1wq"></script>
    <script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Leee8cUAAAAAI5CepD3Fa4qxaAVOqK9A2xKz1wq', {action: 'homepage'}).then(function(token) {
            document.getElementById("token").value = token;
        });
    });
    </script>
  </body>
</html>
