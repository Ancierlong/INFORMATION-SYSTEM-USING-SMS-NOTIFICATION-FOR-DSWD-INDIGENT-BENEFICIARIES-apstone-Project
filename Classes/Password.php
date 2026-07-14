<?php
require_once(dirname(__FILE__) . '/../config/Master.php');

Trait Password {

    public function hash($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verify($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

}