<?php

namespace kmailTools;

use Mailjet\Resources;

require_once  "mailjet/" . 'vendor/autoload.php';
require_once 'kmailTools/KMailTool.php';

class KMailSender extends  KMailTool
{
       /*
    private  $apikey;
    private $apisecret;
    function __construct($apiKey,$apiSecret) 
    {
        $this->apikey = $apiKey;
        $this->apisecret = $apiSecret;
        
    }*/
   
    
    
    
    function sendEMail($sender_Email,$recipientList_array,$content_String,$emailInfo = [])
    {
        KLog::Create()->logArrayAsJSON($recipientList_array);
        
       // $recipientList_array = [$recipientList_array];
        KLog::Create()->log("body bout to be created");
        $body =	[
            
            'FromEmail' => $sender_Email,//"it-helpdesk@tembizrising.com",
            
            'FromName' => $this->projectName." - Contact",
            
            'Subject' => "Message from contact form",
            
            'Text-part' => "This is to inform that a message was sent from the contact form:".json_encode($emailInfo),
            
            'Html-part' => "
            
			<h3>This is to inform that a message was sent from the contact form:</h3>
            
			 ".$content_String ,
            
            'Recipients' =>$recipientList_array
            
        ];
        KLog::Create()->log("body created");
        KLog::Create()->logArrayAsJSON($body);
        
        $mj = new \Mailjet\Client($this->apikey, $this->apisecret);
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        
        $response->success() && $this->showDataPretty($response->getData());
        KLog::Create()->logArrayAsJSON( (array)$response->getStatus());
        
       
     
    }
    
    
}

