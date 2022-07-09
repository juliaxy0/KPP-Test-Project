<?php
session_start();

require "Util.php";
$util = new Util();

//Clear Session
$_SESSION["ic"] = "";
session_destroy();

// clear cookies
$util->clearAuthCookie();

header("Location: ./index2.php");
?>
