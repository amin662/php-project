<?php
session_start();
include '../core/functions.php';
include '../core/validations.php';
$errors  = [];
if (checkRequestMethod("POST")) {


    foreach ($_POST as $key => $value) {
        $$key = sanitizeInput($value);
    }


    //validations

    // email 
    if (!requiredVal($email)) {
        $errors[] = "email is required" . "<br>";
    } elseif (!emailval($email)) {
        $errors[] = "please enter a valid email" . "<br>";
    }

    // password --> required , min:6 , max:20
    if (!requiredVal($password)) {
        $errors[] = "password is required" . "<br>";
    } elseif (!minval($password, 6)) {
        $errors[] = "password must be more than 6 chars" . "<br>";
    } elseif (!maxval($password, 20)) {
        $errors[] = "password must be less than 20 chars" . "<br>";
    }



    if (empty($errors)) {
        // Example usage
        $email = $_POST['email']; // Retrieve email from login form
        $password = $_POST['password']; // Retrieve password from login form

        if (authenticateUser($email, $password)) {
            // Authentication successful, redirect to dashboard or home page
            redirect('../profile.php');
        } else {
            // Authentication failed, display error message
            echo "Invalid email or password. Please try again.";
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect("../login.php");
    }
} else {
    echo "not supported method";
}
