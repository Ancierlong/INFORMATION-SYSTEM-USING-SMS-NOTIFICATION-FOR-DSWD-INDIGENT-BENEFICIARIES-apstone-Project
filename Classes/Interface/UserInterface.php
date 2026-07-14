<?php
interface UserInterface {
    public function setName($name) : void;
    public function setEmail($email) : void ;
    public function setId($id) : void ;
    public function setContactNo($contact_no) : void;
    public function getName() : string ;
    public function getId() : int ;
    public function getErrors() : array ;
    public function toArray() : array;
}
?>