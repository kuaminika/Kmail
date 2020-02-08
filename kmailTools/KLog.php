<?php
namespace kmailTools;

use function GuzzleHttp\json_encode;

class KLog
{
    private  $logIsOn;
    public function __construct(){
       
    }
    
    public static function Create()
    {
        $result = new KLog();
        $result->setLogOn();
        return $result;        
    }
    
    
    public  function setLogOn()
    {
        $this->logIsOn = true;
    }
    
    public  function setLogOff()
    {
        $this->logIsOn = false;
    }
    
    public function logArrayAsJSON($array)
    {
        $jsongSTR = json_encode($array);
        
        $this->log($jsongSTR);
    }
    public function log($message)
    {
     
        if(!$this->logIsOn) return ;
        
        echo $message."</br>";
    }
    
}

