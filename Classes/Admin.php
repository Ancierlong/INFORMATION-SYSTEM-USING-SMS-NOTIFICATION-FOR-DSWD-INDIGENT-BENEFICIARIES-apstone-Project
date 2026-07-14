<?php
require_once(dirname(__FILE__) . '/../config/Master.php');
require_once(dirname(__FILE__) . '/Interface/UserInterface.php');
require_once(dirname(__FILE__) . '/SystemDatabaseConfig.php');
require_once(dirname(__FILE__) . '/Password.php');
require_once(dirname(__FILE__) . '/User.php');

/**
 * OOP #4: (Inheritance) Extends or (Interface) Implements
 * 
 */
class Admin extends User Implements UserInterface{
    protected $name;
    protected $email;
    protected $id;
    protected $contact_no;
    protected $password;
    protected $confirm_password;
    protected $role;

    protected $dbConn;
    protected $errors = [];

    
    public function __construct()
    {
        $this->dbConn = (new SystemDatabaseConfig());
    }

}
