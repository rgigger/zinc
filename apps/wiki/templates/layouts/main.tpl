{capture assign="contentOutput"}{include file=$TEMPLATE_CONTENT}{/capture}
<!DOCTYPE html>

<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>RickGigger.com</title>
<BASE HREF="{$baseUrl}">
<meta name="generator" content="TextMate http://macromates.com/">
<meta name="author" content="Rick Gigger">
<link type="text/css" rel="stylesheet" href="public/css/{if isset($cssFile)}{$cssFile}{else}main.css{/if}" />

<!-- jQuery (http://jquery.com) -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<!-- fancybox (http://fancybox.net) -->
<script type="text/javascript" src="public/fancybox/jquery.fancybox-1.3.1.pack.js"></script>
<script type="text/javascript" src="public/fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="public/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<link rel="stylesheet" href="public/fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />

<script>
{literal}
$(document).ready(function() {
	$(".lightbox").fancybox({
		'transitionIn' : 'elastic',
		'transitionOut' : 'elastic',
		'easingIn'      : 'easeOutBack',
		'easingOut'     : 'easeInBack',
		'speedIn'		:	400, 
		'speedOut'		:	400
	});
});
{/literal}
</script>

</head>
<body>
	<div id="background">
		<div id="page">
			<div id="header" class="container">
				<h1><a style="color: black" href="{$scriptUrl}">{$strings.title}</a></h1>
				<br style="clear: both"/>
				{*
				<div id="topnav">
					<div id="topnav-inner">
						<ul class="mod">
							{foreach from=$topnav key=name item=info}
								{if !isset($info.requireLogin) || !$info.requireLogin || $loggedInUser}
									<li {if $curtab == $info.link}class="current"{/if}><a href="{$scriptUrl}/{$info.link}">{$name}</a></li>
								{/if}
							{/foreach}
						</ul>
					</div>
					<br style="clear: both"/>
				</div>
				*}
			</div>
			<div id="body">
				<div id="main" class="container">
					<!-- Begin main content area -->
					{ $contentOutput }
					<!-- End main content area -->
				</div>
				{*
				<div id="panel">
					<div class="container">{$loginBlock}</div>
					<div class="container">{$randomBlock}</div>
				</div>
				*}
			</div>
			<div id="footer">

			</div>
			<br/ style="clear: both">
		</div>
	</div>
</body>
</html>
