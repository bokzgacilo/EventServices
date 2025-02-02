<?php

    // retrieve data na sinubmit
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['pass'];

        // connect to the database
        include("../dbconnect.php");
        
        // fetch the admin info from the database
        $query = "SELECT id FROM tbl_users WHERE email='admin' AND password='admin';";
        $result = $con->query($query);

        $query2 = "SELECT id FROM tbl_users WHERE email='$username' AND password='$password';";
        $result2 = $con->query($query2);

        // pag nakita sa db yung input ng admin, mag proceed sa AdminPage
        if($result == $result2) {
            header("Location: ../AdminPage.html");
            exit();
        } else {
            header("Location: ../HomePage.php"); // pag hindi nakita, sa HomePage ulit :(
            exit();
        }

    } else {
        header("Location: ../HomePage.php");
        exit();
    }

?>