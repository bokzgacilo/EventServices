<?php // dito lahat ng functions na kailangan ng database

    declare(strict_types=1);

    // funtion for getting the email from the database
    function get_email(object $pdo, string $email) {
        $query = "SELECT email FROM tbl_users WHERE email = :email;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function set_user(object $pdo, string $email, string $password) {
        $query = "INSERT INTO tbl_users (email, password) VALUES (:email, :password);";
        $stmt = $pdo->prepare($query);
        
        $options = ['cost' => 12];
        $hashedPword = password_hash($password, PASSWORD_BCRYPT, $options);
        
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPword);

        $stmt->execute();
    }