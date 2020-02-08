<?php 
use kmailTools\KLog;
use kmailTools\KMailingListAdder;
use kmailTools\KMailSender;
use KMail_handler\KMailProject;
use KMail_handler\KContactFormHandler;
//use Kmail_contacts\KMailContact;

require_once  'kmailTools/KMailingListAdder.php';
require_once 'kmailTools/KLog.php';
require_once 'kmailTools/KMailSender.php';
require_once 'KMail_handler/KMailProject.php';
require_once 'KMail_handler/KContactFormHandler.php';

 $projectInfo = [
    "apiKey"=> 'f0166eb5113e25b967e247700dd8c895',
    "apiSecret" =>   '6b936756be02c7c046b95eeeeaf71921',
    "businessRecipientList"=>[ ["Email"=>"ludemia@heartmindequation.com"]],
    "itRecipientList"=>[ ["Email"=>"kuaminika@gmail.com"]  ,["Email"=>"kuaminika@heartmindequation.com"] ],
     "outboundEmailForContactForm"=>"contact@heartmindequation.com" ,
    "projectName"=>"Heart mind equation"
];


try
{
 
    
    
    $menu = ["sendEmailFromContactform"=>"sendEmailFromContactform",            
             "registerToList" =>"registerToList"];
    /*
     * visitorsName: Herman Duquerronette
visitorsphone: lemanod@gmail.com
visitorsServiceSolicited: not specified
visitorsMessage: lemanod@gmail.com
command: sendEmailFromContactform
     * */
    $received = ["visitorsName"=>"Herman Duquerronette"
        ,"visitorsphone"=>"Herman Duquerronette"
        ,"visitorsEmail"=>"lemanod@gmail.com"
        ,"visitorsServiceSolicited"=>"not specified"
        ,"visitorsMessage"=>"test message"
        ,"command"=>"sendEmailFromContactform"
    ];//$_POST;
    $chosenCommand = $received["command"];
    
    
    
    
    ////////////////////
    
    $log = new KLog();
    $log->setLogOn();
    $log->log("will test sending email");
     
   // $contact  = new KMailContact("herman","kuaminika@gmail.com");
/*    $apiKey = 'f0166eb5113e25b967e247700dd8c895';    
    $apiSecret = '6b936756be02c7c046b95eeeeaf71921';    
    $projectName = "test";*/
    
    
  //  $mailSender = new  KMailSender($apiKey, $apiSecret, $projectName);
    
  //  $mailSender->sendEMail("contact@heartmindequation.com",["Email"=>"lemanod@gmail.com"] , "hihi his is a test");
 
   
    call_user_func($chosenCommand, $received);
   // $adder = new KMailingListAdder($apiKey, $apiSecret, $projectName);
   // $adder->createContact("herman", "sa89778@gmail.com");
   // $adder->addContacToAList("herman", "sdgfh54@4tmail.com", "1905");
     
  //  $log->log("called it");
}
catch (Exception $e)
{
    
    echo "something is wrong";
    $log = new KLog();
    $log->setLogOn();
    $log->log($e->getMessage());
}


function sendEmailFromContactform($emailInfo)
{
    global $projectInfo;
    
    $project = new KMailProject($projectInfo);
    $handlerCommand = new  KContactFormHandler($project);
    $handlerCommand->execute($emailInfo);    
}





?>
