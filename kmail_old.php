<?PHP

require_once  "mailjet/" . 'vendor/autoload.php';

use   \Mailjet\Resources;

	$logIsOn = true;
	$apikey = 'f0166eb5113e25b967e247700dd8c895';
	$apisecret = '6b936756be02c7c046b95eeeeaf71921';
	
	$itRecipientList = [ ["Email"=>"kuaminika@gmail.com"]
						,["Email"=>"kuaminika@heartmindequation.com"] ];
	$outboundEmailForContactForm = "contact@heartmindequation.com";				
	$businessRecipientList = [ ["Email"=>"ludemia@heartmindequation.com"]];					
	
klog(  (class_exists('\Mailjet\\Resources'))? "\Mailjet\Resources": "no \Mailjet\Resources");


function addEmailToContactListRegardless($listId,$contactInfo)
{
	global $apikey,$apisecret;
	$mj = new \Mailjet\Client($apikey, $apisecret);

	$body =  [			  'IsUnsubscribed' => "true",			//  'ContactID' => "987654321",			  'ContactAlt' => $contactInfo["Email"],			  'ListID' => "9517",			//  'ListAlt' => "abcdef123"			];				
	$body['Action'] = "addnoforce";
	
	$body['Contacts']=[];
	$body['Contacts']=[ "Email" => $contactInfo["Email"]];
	
	
	print_r($body);
	
	$response = $mj->post(Resources::$ContactslistManagemanycontacts,  ['id' => $listId, 'body' => $body]);
	$response->success() && showDataPretty($response->getData());
}



function addEmailAsContact($emailAddress)
{
	global $apikey,$apisecret;
	$mj = new \Mailjet\Client($apikey, $apisecret);
	$body = [ "Email" => $emailAddress];
	
	print_r($body);
	
	$response = $mj->post(Resources::$Contact, ['body' => $body]);
	$response->success() && showDataPretty($response->getData());
}


function sendTestEmail()
{
	global $apikey,$apisecret,$itRecipientList;
	$mj = new \Mailjet\Client($apikey, $apisecret);
		klog("bout to define the body");
		$body = [
		'FromEmail' => "noreply@kuaminika.com",
		'FromName' => "No reply Kuaminika",
		'Subject' => "Your email flight plan!",
		'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
		'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br />May the delivery force be with you!",
		'Recipients' => $itRecipientList//[['Email' => "lemanod@gmail.com"]]
		];

	$response = $mj->post(Resources::$Email, ['body' => $body]);
	$response->success() && showDataPretty($response->getData());

	klog("used the post");
	
}
function decodeJSON($jsonString)
{
	echo "abou to decode".$jsonString;
	return json_decode($jsonString);
}
function encodeJSON($arr)
{
	return json_encode($arr);
}

function sendBack($arr)
{
	echo encodeJSON($arr);
}
function sendEmailFromContactform($emailInfo)
{
	global $apikey,$apisecret,$itRecipientList,$outboundEmailForContactForm,$businessRecipientList;
	$allRecipients = array_merge( $itRecipientList,$businessRecipientList );
	//showDataPretty($allRecipients);
	$emailInfoHtmlTable = "<table>
				<tr><td style='width:30%'>Name</td><td>". $emailInfo["visitorsName"]."</td></tr>				<tr><td style='width:30%'>Email</td><td>".  str_replace("%40","@",$emailInfo["visitorsEmailField"])  ."</td></tr>
				<tr><td style='width:30%'>Service interested in</td><td>".$emailInfo["visitorsServiceSolicited"]  ."</td></tr>
				<tr><td style='width:30%'>Phone</td><td>".$emailInfo["visitorsphone"]  ."</td></tr>
				<tr><td style='width:30%'>Message</td><td>". $emailInfo["visitorsMessage"] ."</td></tr>
			</table>";	$emailAddress = str_replace("%40","@",$emailInfo["visitorsEmailField"]);
	addEmailToContactListRegardless();
	klog(" body:");
	
	$mj = new \Mailjet\Client($apikey, $apisecret);
	klog("bout to define the body");
	$body =	[
    'FromEmail' => $outboundEmailForContactForm,//"it-helpdesk@tembizrising.com",
    'FromName' => "Heart mind equation - Contact",
    'Subject' => "Message from contact form",
    'Text-part' => "This is to inform that a message was sent from the contact form:".encodeJSON($emailInfo),
    'Html-part' => "
			<h3>This is to inform that a message was sent from the contact form:</h3>
			 ".$emailInfoHtmlTable ,
    'Recipients' =>$allRecipients 
	];
	$response = $mj->post(Resources::$Email, ['body' => $body]);
	$response->success() && showDataPretty($response->getData());
}


function sendCopyToSender_contactForm($emailInfoTbl,$body)
{
	global $apikey,$apisecret,$outboundEmail;
	$mj = new \Mailjet\Client($apikey, $apisecret);
	$body['FromEmail'] = $outboundEmail;
	$body['Html-part'] = "<h3>This is to inform that you sent a  sent from the contact form:</h3>";
	$response = $mj->post(Resources::$Email, ['body' => $body]);
	$response->success() && showDataPretty($response->getData());
	
	
}


function showDataPretty($data)
{
	echo '<pre>' . var_export($data, true) . '</pre>';

}

function digest($data)
{
	klog("digesting");
}

function klog($msg)
{
	global $logIsOn;
	if(!$logIsOn ) return;
	echo $msg . "</br>";
}



try 
{
	$menu = ["sendEmailFromContactform"=>"sendEmailFromContactform",
			 "registerToContactList" =>"registerToContactList"];
	
	
	$received = $_POST;
	
	showDataPretty($received);
	if(!isset($received)){
		echo "no data";
	    return;
	}
	klog("bout to send");
	//sendEmailFromContactform($received);
	
	if(!isset($received["command"]))
	{
		echo "no command";
		return;
	}
	
	call_user_func($received["command"], $received);
	
	
	return;  
} 
catch (Exception $e) 
{
    echo klog('Caught exception: '.  $e->getMessage());
}



 ?>
 