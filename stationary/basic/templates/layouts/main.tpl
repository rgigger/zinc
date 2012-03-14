<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<base HREF="{$baseUrl}">
<title>My App Name!{block name="title" hide=true} - {$smarty.block.child}{/block}</title>

<!-- jquery stuff -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="public/css/basic.css" media="screen" />
<script>
var scriptUrl = '{$scriptUrl}';
var virtualUrl = '{$virtualUrl}';
var zoneUrl = '{$zoneUrl}';
</script>	

</head>
<body>
<div id="wrap">
<div id="header">
<h1><a href="#">My App Name!</a></h1>
<h2>App Sub Title!</h2>
</div>

<div id="content">

<!-- Begin main content area -->
{block name=body}{/block}
<!-- End main content area -->

</div>
		
<div class="right">
		
<h2>Navigation</h2>

<ul>

<li><a href="http://www.example.com/one">Menu Link One</a></li>
<li><a href="http://www.example.com/two">Menu Link Two</a></li>
<li><a href="http://www.example.com/three">Menu Link Three</a></li>

</ul>
		
</div>

<div id="clear"></div>

</div>

<div id="footer">
Built with <a target="_external" href="https://github.com/rgigger/zinc/wiki/">Zinc Framework</a>
</div>
</body>
</html>
