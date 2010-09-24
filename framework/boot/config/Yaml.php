<?php
class Yaml
{
	static function read($filename)
	{
		return Spyc::YAMLLoad($filename);
	}
	
	static function write($filename, $data)
	{
		file_put_contents($filename, Spyc::YAMLDump($data, 4, 0));
	}
}
