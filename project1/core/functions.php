<?php

function checkRequestMethod($method)
{
    if ($_SERVER['REQUEST_METHOD'] == $method) {
        return true;
    }
    return false;
}

function checkPostInput($input)
{
    if (isset($_POST[$input])) {
        return true;
    }
    return false;
}

function sanitizeInput($name)
{
    return trim(htmlspecialchars(strip_tags($name)));
}

function redirect($path)
{
    header("location:$path");
    die;
}

function authenticateUser($email, $password) {
    $csvFile = fopen('../data/users.csv', 'r');

    if ($csvFile !== false) {
        while (($data = fgetcsv($csvFile)) !== false) {
            // Check if the email matches
            if ($data[1] === $email) {
                // Compare hashed passwords
                if (sha1($password) === $data[2]) {
                    // Authentication successful
                    $_SESSION['auth'] = [$data[0],$data[1]];
                    fclose($csvFile);
                    return true;
                }
            }
        }
        fclose($csvFile);
    }
      // Authentication failed
      return false;
    }
    

