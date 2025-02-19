<?php
session_start();
if(session_id() != "") {
    session_destroy();
}
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
   setcookie(session_name(), '', time() - 1);
}

// Finally, destroy the session.
session_destroy();
header('Location:index.php?Act=logout');
exit();
?>