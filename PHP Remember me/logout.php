<?php
session_start();
setcookie("login_cookie", "", time() - 1);
session_destroy();
header("Location: login.php");
