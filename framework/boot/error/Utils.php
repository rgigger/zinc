<?php
function GetTerminalCols()
{
	if(getenv('TERM') !== false)
		return exec('tput cols');
	else
		return 80;
}

function GetTerminalLines()
{
	if(getenv('TERM') !== false)
		return exec('tput lines');
	else
		return 20;
}
