<?php
/**
 * Smarty replace modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     bytes<br>
 * Purpose:  format a number of bytes to human readable format
 * 
 * @param integer $bytes  the number of bytes to format
 * @return string 
 */
function smarty_modifier_bytes($bytes)
{
	return FormatBytes($bytes);
} 
