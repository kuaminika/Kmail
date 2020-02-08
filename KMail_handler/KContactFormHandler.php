<?php
namespace KMail_handler;
use kmailTools\KMailSender;
use kmailTools\KLog;
//use KMail_handler\KMailProject;
//use KMail_handler\HandlerCommand;
require_once 'KMail_handler/HandlerCommand.php';
require_once 'kmailTools/KMailSender.php';
require_once 'KMail_handler/KMailProject.php';

class KContactFormHandler extends  HandlerCommand
{
    private $mailSender;
 /*   private $project;
    
    public  function __construct($project) 
    {
        $this->project = $project;
    }*/
    
    public function execute($emailInfo)
    {
        KLog::Create()->log("i am here");
        $proArray = (array) $this->project;
        //KLog::Create()->logArrayAsJSON($proArray);
        $apiKey = $this->project->apiKey;//'f0166eb5113e25b967e247700dd8c895';
        $apiSecret = $this->project->apiSecret;//'6b936756be02c7c046b95eeeeaf71921';
        $projectName = $this->project->projectName;//"Heart mind equation";
        
        KLog::Create()->log("i am here stills");
        $this->mailSender = new KMailSender($apiKey, $apiSecret, $projectName);        
        
        $content_String = "<table>
            
				<tr><td style='width:30%'>Name</td><td>". $emailInfo["visitorsName"]."</td></tr>
				<tr><td style='width:30%'>Email</td><td>".  str_replace("%40","@",$emailInfo["visitorsEmail"])  ."-</td></tr>
				<tr><td style='width:30%'>Service interested in</td><td>".$emailInfo["visitorsServiceSolicited"]  ."</td></tr>
				<tr><td style='width:30%'>Phone</td><td>".$emailInfo["visitorsphone"]  ."</td></tr>
				<tr><td style='width:30%'>Message</td><td>". $emailInfo["visitorsMessage"] ."</td></tr>
				    
			</table>";
        
        
        
        $itRecipientList = $this->project->itRecipientList;//[ ["Email"=>"kuaminika@gmail.com"]  ,["Email"=>"kuaminika@heartmindequation.com"] ];
        $outboundEmailForContactForm = $this->project->outboundEmailForContactForm;// "contact@heartmindequation.com";        
        $businessRecipientList = $this->project->businessRecipientList;//[ ["Email"=>"ludemia@heartmindequation.com"]];
        
        $recipientList_array = array_merge($itRecipientList,$businessRecipientList);
        KLog::Create()->log("recipients:");
        KLog::Create()->logArrayAsJSON($recipientList_array);
        KLog::Create()->log("content:");
        KLog::Create()->log($content_String); 
        KLog::Create()->log("sender email:");
        KLog::Create()->logArrayAsJSON($outboundEmailForContactForm);
        
        $this->mailSender->sendEMail( $outboundEmailForContactForm , $recipientList_array, $content_String);
        
        
    }
    
    
}

