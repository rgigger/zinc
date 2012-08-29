{capture assign="contentOutput"}{include file=$TEMPLATE_CONTENT}{/capture}
<!DOCTYPE html>

<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>RickGigger.com</title>
<BASE HREF="{$baseUrl}">
<meta name="generator" content="TextMate http://macromates.com/">
<meta name="author" content="Rick Gigger">

<!-- jQuery (http://jquery.com) -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

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
	
	$('.entry .body a').attr('target', '_new');
});
{/literal}
</script>

</head>
<body>
	<div id="background">
		<div id="page">
			<div id="header" class="container">
				<h1>Rick Gigger</h1>
				<br style="clear: both"/>
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
			</div>
			<div id="body">
				<div id="main" class="container">
					<!-- Begin main content area -->
					{ $contentOutput }
					<!-- End main content area -->
				</div>
				<div id="panel">
					<div class="container">{include file="blocks/login.tpl"}</div>
					{foreach from=$randoms item=choice}
						<div class="container">{include file="blocks/$choice.tpl"}</div>
					{/foreach}
				</div>
			</div>
			<div id="footer">

			</div>
			<br/ style="clear: both">
		</div>
	</div>
{literal}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-15309716-1");
pageTracker._trackPageview();
} catch(err) {}</script>
{/literal}
</body>
</html>
