<?php
require_once(dirname(__FILE__) . '/Interface/UserInterface.php');
require_once(dirname(__FILE__) . '/User.php');

/**
 * OOP #4: (Interface) Implements
 */
class User Implements UserInterface{
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
        
    }

    public function setName($name) : void {
        $this->name = $name;
    }

    public function setEmail($email) : void  {
        $this->email = $email;
    }

    public function setId($id) : void  {
        $this->id = $id;
    }

    public function setRole($value) : void  {
        $this->role = $value;
    }


    public function setContactNo($contact_no) : void {
        $this->contact_no = $contact_no;
    }

    public function getName() : string  {
        return $this->name;
    }

    public function getId() : int  {
        return $this->id;
    }

    public function getErrors() : array  {
        return $this->errors;
    }

    public function toArray() : array {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'id' => $this->id,
            'contact_no' => $this->contact_no,
            'formatted_contact' => substr($this->contact_no, 1),
            'role' => $this->role
        ];
    }
}
