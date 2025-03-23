<?php

session_start(); // Always start the session before destroying

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Clear the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Add cache control headers to prevent page caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Thu, 19 Nov 1981 08:52:00 GMT"); // Past date to ensure no caching

    // Redirect to index page
    header("Location: index.php");
    exit();
?>
