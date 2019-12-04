<!DOCTYPE html>
<html lang="de">

<head>
    <title>PHP SMPT Mailer</title>
</head>

<body>
    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    if(isset($_POST["submit"])){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.yandex.com";
        $mail->SMTPAuth = true;
        $mail->Username = "admin@tutorialwork.de";
        $mail->Password = "wcpdehtibashvvfg";

        $mail->setFrom("admin@tutorialwork.de", "Tutorialwork");
        $mail->addAddress("tutorialworktv@gmail.com", "Tutorialwork");

        $mail->addAttachment("Anhang.zip", "Test.zip");
        $mail->isHTML(true);
        $mail->Subject = "Test";
        $mail->Body = $_POST["msg"];

        if($mail->send()){
            echo "Deine Email wurde erfolgreich verschickt.";
        } else {
            echo "Es gab einen Fehler ".$mail->ErrorInfo;
        }
    }
    ?>
    <h1>PHP SMPT Mailer</h1>
    <form method="post" action="index.php">
        <textarea name="msg" placeholder="Nachricht"></textarea><br>
        <button type="submit" name="submit">Senden</button>
    </form>
</body>

</html>