<?php

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['username'];
        $password = $_POST['pass'];
        $confirm = $_POST['confirm'];

        try {
            // include other files
            require_once 'dbconnectt.php';
            require_once 'signup_model.php';
            require_once 'signup_contr.php';

            // avoid errors on sign up
            $errors = []; // error container;
            
            if(is_input_empty($email, $password, $confirm)) {
                $errors["empty_input"] = "Fill in all fields!"; 
            }
            if(is_email_invalid($email)) {
                $errors["invalid_email"] = "Invalid email used!";
            }
            if(is_email_registered($pdo, $email)) {
                $errors["email_used"] = "Email already registered!";
            }

            require_once 'config_session.php';
            
            if($errors) {
                $_SESSION["errors_signup"] = $errors;
                foreach($errors as $error) {
                    echo "<script type='text/javascript'>alert('$error');</script>";
                }

                header("Refresh:0.5; url='../HomePage.php'");
                die();
            }

            if($password == $confirm) {
                create_user($pdo, $email, $password);
                echo "<script type='text/javascript'>alert('Sign Up Successful!');</script>";
                header("Refresh:0.5; url='../CustomerPage.html?signup=success");

                $pdo = null;
                $stmt = null;

                die();
            } else {
                echo "<script type='text/javascript'>alert('Confirm same password!');</script>";
                header("Refresh:0.5; url='../HomePage.php'");
                die();
            }

        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

    } else {
        header("Location: ../HomePage.php");
        die();
    }