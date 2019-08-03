<?php
// if logged in, end the current browser session
session_destroy();
header("location:/login");
$routing = FALSE;
 ?>
