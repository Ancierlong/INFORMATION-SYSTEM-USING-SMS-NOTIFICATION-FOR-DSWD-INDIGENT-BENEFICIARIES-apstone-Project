<?php
    // logged in user redirections
    if (isset($_SESSION['user']) == true) {
        header("Location: " . $BASE_URL . '/dashboard.php');
        return;
    }
