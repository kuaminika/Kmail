<?php
namespace kmailTools;

use Mailjet\Resources;
use Kmail_contacts\KMailContact;
use Mailjet;
require_once 'Kmail_contacts/KMailContact.php';
require_once  "mailjet/" . 'vendor/autoload.php';
require_once 'kmailTools/KMailTool.php';

class KMailingListAdder extends  KMailTool
{
    
   
    
    public  function createContact($name,$email)
    {
       $contact = new KMailContact($name, $email);
       
       
      $body =[ 'IsExcludedFromCampaigns' => "true"];
      $body = array_merge($body,$contact->toArray());
     // echo "k".json_encode((array)$this)."\n";
      $mj = new \Mailjet\Client($this->apikey, $this->apisecret);
      $response = $mj->post(Resources::$Contact, ['body' => $body]);
      $response->success() && $this->showDataPretty($response->getData());
      
      
      return  $contact;
    }
    
    private function addCreatedContact($createdContactArray, $listId)
    {
        KLog::Create()->log("inside add created");
        KLog::Create()->log( json_encode($createdContactArray));
        
        //'IsUnsubscribed' => "true",
   //     echo json_encode($createdContactArray);
       $body = []; 
      $body["IsUnsubscribed"]="true";
       $body["ContactID"] =   $createdContactArray[0]["ID"];
        $body["ContactAlt"] =  $createdContactArray[0]["Email"];
       $body["ListID"] = $listId;
      
       KLog::Create()->log( "body that i gathered");
       KLog::Create()->log( json_encode($body));
       
       $mj = new \Mailjet\Client($this->apikey, $this->apisecret);
       $response = $mj->post(Resources::$Listrecipient, ['body' => $body]);
       
       KLog::Create()->log( "the response if it makes sense:");
       KLog::Create()->log( json_encode($response));
      
       $response->success() && $this->showDataPretty($response->getData());
       KLog::Create()->log(    $response->getReasonPhrase());
    }
 
    
    public function addContacToAList($name,$email,$listId)
    {
       // echo "jojo";
        //echo $name;
     $contact = new KMailContact($name, $email);
     
       // KLog::Create()->log("hihih");
        $body =[ 'IsExcludedFromCampaigns' => "true"];
        $body = array_merge($body,$contact->toArray());
        
    KLog::Create()->log( json_encode($body));
        $mj = new \Mailjet\Client($this->apikey, $this->apisecret);
        $response = $mj->post(Resources::$Contact, ['body' => $body]);
    
        
        KLog::Create()->log( "the response if it makes sense:");
        KLog::Create()->log( json_encode($response));
    
        $response->success() && $this->addCreatedContact($response->getData(),$listId);
        
    }
    
}

