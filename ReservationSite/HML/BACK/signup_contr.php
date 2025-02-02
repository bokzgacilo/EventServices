<?php // dito lahat ng functions for controlling 

    declare(strict_types=1);

    // function for checking empty input
    function is_input_empty(string $email, string $password, string $confirm) {
        if(empty($email) || empty($password) || empty($confirm)) {
            return true;
        } else {
            return false;
        }
    }
    //function for checking invalid email
    function is_email_invalid(string $email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    //function for checking registered email
    function is_email_registered(object $pdo, string $email) {
        if(get_email($pdo, $email)) {
            return true;
        } else {
            return false;
        }
    }

    //function for creating the user
    function create_user(object $pdo, string $email, string $password) {
        set_user($pdo, $email, $password);
    }