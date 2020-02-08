<?php
namespace Kmail_contacts;

class KMailContact
{
    var $firstname;
    var $lastname;
    var $email;
    
    
    public function __construct($name,$email,$lname)
    {
        $this->firstname = $name;
        $this->email = $email;
        $this->lastname=$lname;
    }
    
    public function toArray()
    {
        $result = (array)$this;
        return $result;
    }
    
}

