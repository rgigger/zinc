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
							{foreach from=$topnav key=name item=link}
								<li {if $curtab == $link}class="current"{/if}><a href="{$scriptUrl}/{$link}">{$name}</a></li>
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
					<div id="block" class="container">{$randomBlock}</div>
				</div>
			</div>
			<div id="footer">

			</div>
			<br/ style="clear: both">
		</div>
	</div>
</body>
</html>
