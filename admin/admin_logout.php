<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to main website homepage
header("Location: ../index.php");
exit();
?>