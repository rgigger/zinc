<?php
// include('config.php');
// include('includes.php');

SqlBeginTransaction();

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

foreach($mail as $message)
{
	//	spit out a little info about the message being processed
	echo "{$message->from}: {$message->to}: {$message->subject}\n";
	
	//	see if the from field is like "John Doe <someuser@example.com>" 
	//	and if it is parse out the individual fields
	preg_match('/([\w ]*)<(\w.+)@([\w.]+)>/' , $message->from, $matches);
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
	
	// make sure there is a user in the database for the owner of the request
	$sender = Person::getOne(array('username' => $username), array(
		'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email
	));
	
	preg_match('/<([^>]+)>/' , trim($message->messageId), $matches);
	$messageId = $matches[1];
	$messageParts = getMessageParts($message);
	
	
	$parentRequest = null;
	if($message->headerExists('references'))
	{
		echo "dealing with $message->references\n";
		
		// figure out if this already referes to an existing comment
		$comment = Comment::findOne(array('message_id' => $messageId));
		if($comment)
			$parentRequest = $comment->Request;
		
		// figure out if this should be tied to an exisiting request, if so, attach it as a comment
		if(!$parentRequest)
		{
			$parentId = substr($message->references, 1, strlen($message->references) - 2);
			$parentRequest = Request::findOne(array('message_id' => $parentId));
		}
		
		//	if not see if it references an existing comment
		if(!$parentRequest)
		{
			$parentComment = Comment::findOne(array('message_id' => $parentId));
			if($parentComment)
				$parentRequest = $parentComment->Request;
		}
		
		if($parentRequest)
		{
			//	if we didn't find a comment earlier create one now
			if(!$comment)
				$comment = new Comment();
			
			$comment->request_id = $parentRequest->id;
			$comment->message_id = $messageId;
			$comment->text_comment = $messageParts['text'];
			$comment->html_comment = $messageParts['html'];
			$comment->save();
			continue;
		}
	}
	
	// if it doesn't attach to anything else see if it matches up to an existing request
	// if it does update, otherwise just create a new request
	if(!$parentRequest)
	{
		$request = Request::findOne(array('message_id' => $messageId));
		if(!$request)
			$request = new Request();
		
		$request->owner_id = $sender->id;
		$request->name = trim($message->subject);
		$request->message_id = $messageId;
		$request->text_desc = $messageParts['text'];
		$request->html_desc = $messageParts['html'];
		$request->short_desc = $messageParts['short'];
		$request->save();
		
		if(isset($messageParts['attachments']))
		{
			foreach($messageParts['attachments'] as $info)
			{
				$attachment = Attachment::getOne(array('request_id' => $request->id, 'hash' => $info['hash']));

				$attachment->name = $info['name'];
				$attachment->type = $info['type'];
				$attachment->content_id = $info['contentId'];
				$attachment->save();
			}
		}
	}
}

function getMessageParts($message)
{
	$parts = array('text' => null, 'html' => null, 'short' => null, 'attachments' => array());
	_getMessageParts($message, $parts);
	return $parts;
}

function _getMessageParts($message, &$parts)
{
	if(!$message->isMultipart())
	{
		$res = preg_match('/([\w ]+)\/([\w.-]+);.*/' , $message->contentType, $matches);
		
		if($matches[1] == 'text' && $matches[2] == 'plain')
		{
			$text = $parts['text'] = mb_convert_encoding(quoted_printable_decode($message->getContent()), 'UTF-8');
			//	convert any windows line endings to unix
			$text = str_replace("\r\n", "\n", $text);
			//	convert any Classic Mac line endings to Unix
			$text = str_replace("\r", "\n", $text);
			//	break it into lines
			$lines = explode("\n", $text);
			$shortDescLines = array();
			foreach($lines as $line)
			{
				if(trim($line))
					$shortDescLines[] = $line;
					
				if(count($shortDescLines) == 3)
					break;
			}
			$parts['short'] = implode("\n", $shortDescLines);
		}
		else if($matches[1] == 'text' && $matches[2] == 'html')
			$parts['html'] = mb_convert_encoding(quoted_printable_decode($message->getContent()), 'UTF-8');
		else
		{
			$info = importFile($message);
			$parts['attachments'][] = $info;
			// print_r($parts);
		}
			
		
		return;
	}
	
	foreach($message as $part)
		_getMessageParts($part, $parts);
}

function importFile($part)
{
	$res = preg_match('/(.*); name="(.*)"/' , $part->contentType, $matches);
	$type = $matches[1];
	$name = $matches[2];
	
	if($part->contentTransferEncoding == 'base64')
	{
		$content = base64_decode($part->getContent());
		$hash = md5($content);
		
		$path = Config::get('app.var');
		if(!$path)
			trigger_error("no Config value set for app.var");
		$path .= '/attachments';
		$path .= '/' . $hash;
		
		file_put_contents($path, $content);
		
		$attachment = new Attachment();
		$attachment->name = $name;
		$attachment->type = $type;
		$attachment->hash = $hash;
		$contentId = $part->headerExists('content-id') ? substr($part->contentId, 1, strlen($part->contentId) - 2) : null;
		$info = array('name' => $name, 'type' => $type, 'hash' => $hash, 'contentId' => $contentId);
		// print_r($info);
 		return $info;
	}
	else
		trigger_error("attachment encoding {$part->contentTransferEncoding} not handled");
}

SqlCommitTransaction();