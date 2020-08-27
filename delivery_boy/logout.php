<?php 

// include("top.inc.php");
session_start();
require("../include/connection.inc.php");
require("../include/functions.inc.php");

unset($_SESSION["db_loggedin"]);
unset($_SESSION["db_name"]);
unset($_SESSION["db_id"]);

redirect("login.php");

?>