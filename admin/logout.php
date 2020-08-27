<?php 

include("top.inc.php");

unset($_SESSION["a_loggedin"]);
unset($_SESSION["a_name"]);

redirect("login.php");

?>