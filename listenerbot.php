
<?php
/* This is an bot webhook, created by Felix Lepoutre. This webhook only reads what a specific user in a group says, and then reposts that into a telegram channel. 

Instructions
1. Create a bots with @botfather in Telegram. This will both listen and post. The bot should be allowed groups and disable group privacy so he listens to all messages. 
2. Add the bot to the group the user you want to filter out is in. 
3. Create an announcement channel, and get into the settings to add an admin. Find your bot to add as an admin with posting rights. No need to add the bot into the channel first, right now telegram doesn't even allow this. 
4. define vars below 
5. upload this script. For true noobs, i suggest registering a free heroku account, putting the script in the Web folder of the heroku php-getting-started folder of this tutorial and then git the script to your heroku environemt: https://devcenter.heroku.com/articles/getting-started-with-php#introduction
6. set/update the listener webhook url, so all messages will be sent to this script. You can do this with the 'setwebhook.html' script. Just insert your bot token the @botfather gave to you, your url (without https:// !!) and you can keep the port at 88. If you chose the heroku service and have pushed your code, then your url will be: <appname>.heroku.com/listenerbot.php
*/

//define vars
$superuser = SET_ID; //This is the user_id of the user you want to single out. To find the user id, setup the webhook URL to a webhook listener like webhook.site and wait for the user to say something. The user_id will be in de data output to the webhook. 
$bottoken = "SET_TOKEN"; //remember to put 'bot' before token so for example: bot23492384928349:asdf2349sfsdaf
$channelname = "@CHANNELNAME" //insert the name of your announcement channel, where your bot is now admin. 

//define functions

function sendMessage($chatID, $message, $token) {
    echo "sending message to " . $chatID . "\n";

    $url = "https://api.telegram.org/" . $token . "/sendMessage?chat_id=" . $chatID ."&parse_mode=HTML";
    $url = $url . "&text=" . urlencode($message);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
}

function sendPhoto($chatID, $imgID, $token) {
    echo "sending message to " . $chatID . "\n";

    $url = "https://api.telegram.org/" . $token . "/sendPhoto?chat_id=" . $chatID;
    $url = $url . "&photo=" . $imgID;
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
}

//Get, edit & post data to Channel

$fullmessage = "";
$json = json_decode(file_get_contents('php://input'), true);

$userID = $json['message']['from']['id'];
if($userID == $superuser){

	//set some vars
	$token = $bottoken;
	$chatid = $channelname;

	//if picture in message
	if(isset($json['message']['photo'])){
		$imgID = $json['message']['photo'][0]['file_id'];
		sendPhoto($chatid, $imgID, $token);
	}

	//if the message was a reply to someone
	if($json['message']['text'] != ""){
		$username = $json['message']['from']['username'];
		$chatname = $json['message']['chat']['title'];
		
		if(isset($json['message']['reply_to_message'])){
			$username_original = $json['message']['reply_to_message']['from']['username'];
			$message_original = $json['message']['reply_to_message']['text'];
			
			
			$fullmessage .= "<i>" . $username_original . "</i>";
			$fullmessage .=": ";
			$fullmessage .= "<i>" . $message_original . "</i>";
			$fullmessage .='
			';
			$fullmessage .- "&nbsp;&nbsp;&nbsp;&nbsp;";
			$fullmessage .= "<b>" . $username . "</b>";
			$fullmessage .= ": ";
		}

		$message = $json['message']['text'];
		$message .= "<i> ~ " . $chatname . "</i>";

		$fullmessage .= $message;

		//send message to group
		sendMessage($chatid, $fullmessage, $token);
	}
}

?>
