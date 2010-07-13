<?php
include('config.php');
include('includes.php');

Zoop::loadLib('zend');

$mail = new Zend_Mail_Storage_Pop3(array('host'     => 'pop.gmail.com',
                                         'user'     => 'request_test@rickgigger.com',
                                         'password' => 'requestx0ring',
                                         'ssl'      => 'SSL'));

// $mail = new Zend_Mail_Storage_Imap(array('host'     => 'imap.gmail.com',
//                                          'user'     => 'request_test@rickgigger.com',
//                                          'password' => 'requestx0ring',
//                                          'ssl'      => 'SSL'));
var_dump($mail);

var_dump($count = $mail->countMessages());

// for($i = 1; $i <= $count; $i++)
foreach($mail as $message)
{
	// $message = $mail->getMessage($i);
	// print_r($message);
	// echo "$i {$message->from} {$message->to} {$message->subject}\n";
	echo "{$message->from} {$message->to} {$message->subject}\n";
	
	$res = preg_match('/([\w ]+)<(\w+)@([\w.]+)>/' , $message->from, $matches);
	$name = trim($matches[1]);
	$parts = explode(' ', $name);
	$firstname = array_shift($parts);
	$lastname = array_pop($parts);
	$user = trim($matches[2]);
	$domain = trim($matches[3]);
	$username = $email = "$user@$domain";
	
	$sender = DbObject::_getOne('Person', array('username' => $username), array(
		'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email
	));
	
	// print_r($sender);
	
	preg_match('/<([^>]+)>/' , trim($message->messageId), $matches);
	$messageId = $matches[1];
	if(SqlFetchCell("SELECT count(*) from request where message_id = :messageId", array('messageId' => $messageId)))
		continue;
	
	$request = new Request();
	$request->owner_id = $sender->id;
	$request->name = trim($message->subject);
	$request->message_id = $messageId;
	
	//	deal with the headers
	// foreach ($message->getHeaders() as $name => $value)
	// {
	//     if(is_string($value))
	// 	{
	//         echo "$name: $value\n";
	//         continue;
	//     }
	// 	else
	// 	{
	// 		echo "$name: <complex value>\n";
	// 	}
	//     // foreach ($value as $entry) {
	//     //     echo "$name: $entry\n";
	//     // }
	// }
	
	if($message->isMultipart())
	{
	    foreach($message as $part)
		{
			print_r($part->getContent());
			var_dump($part->contentType);
			$start = strpos($part->contentType, '/');
			var_dump($start);
			$end = strpos($part->contentType, ';');
			var_dump($end);
			var_dump($end - $start);
			$type = substr($part->contentType, $start + 1, $end - $start - 1);
			var_dump($type);
			
			if($type == 'text')
				$request->text_desc = $part->getContent();
			else if($type == 'html')
				$request->html_desc = $part->getContent();
		}
		// die();
	}
	else
		$request->text_desc = $message->getContent();
	
	$request->save();
	// break;
}

// echo_r(Config::get('app.allowedDomains'));

//  get the owner id
//  if the user doesn't exist create them with the email as the username
//	take the name from the subject line
//	take the description from the body
	//	split it into text_desc and html_desc - display the html desc if it is there
