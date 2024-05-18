<?php

session_start();

include("../config/db.php");
include("customFunctions.php");

if(isset($_POST['signup'])) {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // check user with email already exist
    $emailExistQuery = "SELECT * FROM users WHERE email = ?";
    $emailExistQueryStmt = mysqli_prepare($conn, $emailExistQuery);
    mysqli_stmt_bind_param($emailExistQueryStmt, "s", $email);
    mysqli_stmt_execute($emailExistQueryStmt);
    mysqli_stmt_store_result($emailExistQueryStmt);

    if(mysqli_stmt_num_rows($emailExistQueryStmt) > 0) {
        redirect("Email already registered", "../signup.php", "error");
    }

    // if not then insert new user
    $insertQuery = "INSERT INTO users(name, email, password) values(?, ?, ?)";
    $insertQueryStmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($insertQueryStmt, "sss", $fullName, $email, $password);

    if(mysqli_stmt_execute($insertQueryStmt)) {
        $userId = mysqli_insert_id($conn);

        $_SESSION['auth'] = true;
        $_SESSION['user'] = [
            'userId' => $userId,
            'fullName' => $fullName,
            'email' => $email
        ];
        $_SESSION['role'] = 1;

        // TODO: need to change this later (for now tpo/index.php -> need to be student/index.php)

        redirect("User signed up successfully", "../student/index.php");
    }
    else {
        redirect('Something went wrong. Please try again', '../signup.php', "error");
    }
}
else if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $userExistQuery = "SELECT id, name, email, role FROM users WHERE email = ? AND password = ?";
    $userExistQueryStmt = mysqli_prepare($conn, $userExistQuery);
    mysqli_stmt_bind_param($userExistQueryStmt, "ss", $email, $password);
    mysqli_stmt_execute($userExistQueryStmt);
    mysqli_stmt_store_result($userExistQueryStmt);
    mysqli_stmt_bind_result($userExistQueryStmt, $id, $fullName, $email, $role);

    if(mysqli_stmt_fetch($userExistQueryStmt)) {
        $_SESSION['auth'] = true;
        $_SESSION['user'] = [
            'userId' => $id,
            'fullName' => $fullName,
            'email' => $email
        ];
        $_SESSION['role'] = $role;

        // role: 0=student and 1=tpo
        if($role == 0) {
            redirect("User logged in successfully", "../student/index.php");
        }
        else {
            redirect("User logged in successfully", "../tpo/index.php");
        }
    } 
    else {
        redirect('Invalid email or password', '../login.php', 'error');
    }
}
else if(isset($_POST['logout'])) {
    // unset($_SESSION['user']);
    // unset($_SESSION['auth']);
    // unset($_SESSION['role']);
    session_unset();
    session_destroy();
    redirect("User logged out successfully", "../login.php");
}

?>