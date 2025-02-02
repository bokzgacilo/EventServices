<?php

    // securing the session when signing up
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);

    // cookie parameters
    session_set_cookie_params([
        'lifetime' => 1800,
        'domain' => 'localhost',
        'path' => '/',
        'secure' => true,
        'httponly' => true
    ]);

    // starting a session
    session_start();

    if(isset($_SESSION["user_id"])) {
        // pag wala pang session, mag create
        if(!isset($_SESSION["last_regeneration"])) {
            regenerate_session_id_loggedin();
        } else {
            // pag meron na, 30 minutes mag expire
            $interval = 60 * 30;
            if(time() - $_SESSION["last_regeneration"] >= $interval) {
                regenerate_session_id_loggedin();
            }
        }
    } else {
        // pag wala pang session, mag create
        if(!isset($_SESSION["last_regeneration"])) {
            regenerate_session_id();
        } else {
            // pag meron na, 30 minutes mag expire
            $interval = 60 * 30;
            if(time() - $_SESSION["last_regeneration"] >= $interval) {
                regenerate_session_id();
            }
        }
    }

    // function for creating a session cookie
    function regenerate_session_id() {
        session_regenerate_id(true);
        $_SESSION["last_regeneration"] = time();
    }

    function regenerate_session_id_loggedin() {
        session_regenerate_id(true);

        $userId = $_SESSION["user_id"];
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $userId;
        session_id($sessionId);

        $_SESSION["last_regeneration"] = time();
    }