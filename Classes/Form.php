<?php 
require_once(dirname(__FILE__) . '/Password.php');

/**
 * OOP #1: Abstraction
 *  - used by LoginForm.php, RegisterForm.php, UpdateAccountForm.php, 
 */
abstract class Form {
    public $dbConn;
    public $errors = [];

    public function __construct() {
        $this->dbConn = (new SystemDatabaseConfig());
    }

    abstract protected function validate();
    abstract protected function getErrors();
    abstract protected function handleSubmit();
}