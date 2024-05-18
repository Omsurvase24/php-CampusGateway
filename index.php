<?php

include("includes/header.php");
include("functions/customFunctions.php");

if(isset($_SESSION['auth'])) {
    $role = $_SESSION['role'];

    if($role == 0) {
        redirect('Already logged in', 'student/index.php');
    }
    else {
        redirect('Already logged in', 'tpo/index.php');
    }
}

?>

<h1 class="text-sm text-white">Home</h1>

<?php
include("includes/footer.php")
?>