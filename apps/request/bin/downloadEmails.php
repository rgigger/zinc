<?php
// include('config.php');
// include('includes.php');

Zoop::loadLib('zend');

$mailConfig = Config::get('app.importer');
$mail = new Zend_Mail_Storage_Pop3(array('host'     => $mailConfig['host'],
                                         'user'     => $mailConfig['username'],
                                         'password' => $mailConfig['password'],
                                         'ssl'      => $mailConfig['ssl'] ? 'SSL' : ''));

// $mail = new Zend_Mail_Storage_Imap(array('host'     => $mailConfig['host'],
//                                          'user'     => $mailConfig['username'],
//                                          'password' => $mailConfig['password'],
//                                          'ssl'      => $mailConfig['ssl'] ? 'SSL' : ''));
// var_dump($mail);

var_dump($count = $mail->countMessages());

// for($i = 1; $i <= $count; $i++)
foreach($mail as $message)
{
	// $message = $mail->getMessage($i);
	// print_r($message);
	// echo "$i {$message->from} {$message->to} {$message->subject}\n";
	echo "{$message->from}: {$message->to}: {$message->subject}\n";
	
	//	see if the from field is like "John Doe <someuser@example.com>" 
	//	and if it is parse out the individual fields
	$res = preg_match('/([\w ]*)<(\w.+)@([\w.]+)>/' , $message->from, $matches);
	print_r($matches);
	
	if(count($matches) == 4)
	{
		$name = trim($matches[1]);
		$parts = explode(' ', $name);
		$firstname = array_shift($parts);
		$lastname = array_pop($parts);
		$user = trim($matches[2]);
		$domain = trim($matches[3]);
		$username = $email = "$user@$domain";
	}
	else
		die("unhandled address format in the 'From' field\n\n");
	
	$sender = DbObject::_getOne('Person', array('username' => $username), array(
		'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email
	));
	
	// print_r($sender);
	
	preg_match('/<([^>]+)>/' , trim($message->messageId), $matches);
	$messageId = $matches[1];
	// SqlEchoOn();
	if(SqlFetchCell("SELECT count(*) from request where message_id = :messageId", array('messageId' => $messageId)))
		$request = Request::findOne(array('message_id' => $messageId));
		// continue;
	else
		$request = new Request();
	
	echo 'CLASS NAME = ' . get_class($request) . "\n\n";
	
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
		$parts = getMessageParts($message);
		print_r($parts);
		$request->text_desc = $parts['text'];
		$request->html_desc = $parts['html'];
	}
	else
		$request->text_desc = $message->getContent();
	
	print_r($request);
	$request->save();
	// break;
}

function getMessageParts($message)
{
	$parts = array('text' => null, 'html' => null, 'attachments' => array());
	_getMessageParts($message, $parts);
	return $parts;
}

function _getMessageParts($message, &$parts)
{
	foreach($message as $part)
	{
		// echo "CONTENT TYPE = $part->contentType\n\n";
		if($part->isMultipart())
			_getMessageParts($part, $parts);
		else
		{
			$res = preg_match('/([\w ]+)\/(\w+);.*/' , $part->contentType, $matches);
			
			if($matches[1] == 'text' && $matches[2] == 'plain')
				$parts['text'] = mb_convert_encoding(quoted_printable_decode($part->getContent()), 'UTF-8');
			else if($matches[1] == 'text' && $matches[2] == 'html')
				$parts['html'] = mb_convert_encoding(quoted_printable_decode($part->getContent()), 'UTF-8');
		}
	}
}


// echo_r(Config::get('app.allowedDomains'));

//  get the owner id
//  if the user doesn't exist create them with the email as the username
//	take the name from the subject line
//	take the description from the body
	//	split it into text_desc and html_desc - display the html desc if it is there
