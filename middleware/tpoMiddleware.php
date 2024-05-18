<?php

include("../functions/customFunctions.php");

if(isset($_SESSION['auth'])) {
    if($_SESSION['role'] != 1) {
        redirect("Unauthorized access", "../index.php", "error");
        exit;
    }
}
else {
    redirect("Login to continue", "../login.php", "error");
}

?>