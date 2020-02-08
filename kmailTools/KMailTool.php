<?php
namespace kmailTools;

abstract class KMailTool
{
    var   $apikey;
    var  $projectName;
    var $apisecret;
    
    function __construct($apiKey,$apiSecret,$projectName)
    {
  
        $this->apikey = $apiKey;
        $this->apisecret = $apiSecret;
        $this->projectName = $projectName;
        
        KLog::Create()->log("done constructing kmailtool");
    }
    
    function showDataPretty($data)    
    {     
        KLog::Create()->log("supposed to get some");
        echo '<pre>' . var_export($data, true) . '</pre>';               
    }
}

