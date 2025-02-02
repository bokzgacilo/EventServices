<?php

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['username'];
        $password = $_POST['pass'];

        try {
            // include other files
            require_once 'dbconnectt.php';
            require_once 'login_model.php';
            require_once 'login_contr.php';

            // avoid errors on log in
            $errors = []; // error container;
            
            if(is_input_empty($email, $password)) {
                $errors["empty_input"] = "Fill in all fields!"; 
            }

            $result = get_user($pdo, $email);

            if(is_email_wrong($result)) {
                $errors["login_incorrect"] = "Incorrect login Info!";
            }
            if(!is_email_wrong($result) && is_password_wrong($password, $result['password'])) {
                $errors["login_incorrect"] = "Incorrect login info!";
            }

            require_once 'config_session.php';
            
            if($errors) {
                $_SESSION["errors_login"] = $errors;
                foreach($errors as $error) {
                    echo "<script type='text/javascript'>alert('$error');</script>";
                }

                header("Refresh:0.5; url='../HomePage.php'");
                die();
            }

            $newSessionId = session_create_id();
            $sessionId = $newSessionId . "_" . $result["id"];
            session_id($sessionId);

            $_SESSION["user_id"] = $result["id"];
            $_SESSION["user_email"] = $result["email"];
            $_SESSION["last_regeneration"] = time();

           // echo "<script type='text/javascript'>alert('Log in Successful!');</script>";
            header("Refresh:0.5; url='../CustomerPage.html?login=success");
            $pdo = null;
            $stmt = null;

            die();

        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../HomePage.php");
        die();
    }