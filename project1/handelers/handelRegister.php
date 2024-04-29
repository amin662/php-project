<?php
session_start();
include '../core/functions.php';
include '../core/validations.php';
$errors  = [];
if (checkRequestMethod("POST") && checkPostInput('name')) {


    foreach ($_POST as $key => $value) {
        $$key = sanitizeInput($value);
    }


    //validations
    // name --> required , min:3 , max:25

    if (!requiredVal($name)) {
        $errors[] = "name is required" . "<br>";
    } elseif (!minval($name, 3)) {
        $errors[] = "name must be more than 3 char" . "<br>";
    } elseif (!maxval($name, 25)) {
        $errors[] = "name must be less than 25 char" . "<br>";
    }

    // email 
    if (!requiredVal($email)) {
        $errors[] = "name is required" . "<br>";
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
        $users_file = fopen("../data/users.csv","a+");
        $data = [$name, $email, sha1($password)];
        fputcsv($users_file,$data);
        $_SESSION['auth'] = [$name, $email];
        redirect("../index.php");
    } else {
        $_SESSION['errors'] = $errors;
        redirect("../register.php");
    }
} else {
    echo "not supported method";
}
