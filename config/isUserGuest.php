<?php
    // logged in user redirections
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
