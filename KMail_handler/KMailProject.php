<?php
namespace KMail_handler;

class KMailProject
{
    var $itRecipientList;
    var  $outboundEmailForContactForm;
    var $businessRecipientList;
    var $apiKey;
    var $apiSecret;
    var $projectName;
    
    public  function __construct($projectInfo)
    {
        $this->apiKey= $projectInfo["apiKey"];
        $this->apiSecret = $projectInfo["apiSecret"];
        $this->businessRecipientList = $projectInfo["businessRecipientList"];
        $this->itRecipientList = $projectInfo["itRecipientList"];
        $this->outboundEmailForContactForm = $projectInfo["outboundEmailForContactForm"];
        $this->projectName = $projectInfo["projectName"];
        
    }
    
    /*
    $itRecipientList = [ ["Email"=>"kuaminika@gmail.com"]  ,["Email"=>"kuaminika@heartmindequation.com"] ];
    $outboundEmailForContactForm = "contact@heartmindequation.com";
    $businessRecipientList = [ ["Email"=>"ludemia@heartmindequation.com"]];
    $apiKey = 'f0166eb5113e25b967e247700dd8c895';
    $apiSecret = '6b936756be02c7c046b95eeeeaf71921';
    $projectName = "Heart mind equation";*/
}

