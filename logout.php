<?php 

include("top.inc.php");

unset($_SESSION["USER_ID"]);
unset($_SESSION["USER_NAME"]);

redirect("login_register");

?>