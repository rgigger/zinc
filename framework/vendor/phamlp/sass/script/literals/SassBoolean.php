<?php
/* SVN FILE: $Id: SassBoolean.php 1 2010-03-21 11:35:45Z chris.l.yates $ */
/**
 * SassBoolean class file.
 * @package sass
 * @author Chris Yates
 * @copyright Copyright &copy; 2010 PBM Web Development
 * @license http://www.yiiframework.com/license/
 */

/**
 * SassBoolean class.
 * @package sass
 * @author Chris Yates
 */
class SassBoolean extends SassLiteral {
	/**@#+
	 * Regexes for matching and extracting colours
	 */
	const MATCH = '/^(true|false)\b/';

	/**
	 * SassBoolean constructor
	 * @param string value of the boolean type
	 * @return SassBoolean
	 */
	public function __construct($value) {
		if ($value === 'true' || $value === 'false') {
			$this->value = ($value === 'true' ? true : false);
		}
		else {
			throw new SassBooleanException('Invalid SassBoolean value');
		}
	}

	/**
	 * Returns the value of this boolean.
	 * @return boolean the value of this boolean
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Returns a string representation of the value.
	 * @return string string representation of the value.
	 */
	public function toString() {
		return $this->getValue() ? 'true' : 'false';
	}

	/**
	 * Returns a value indicating if a token of this type can be matched at
	 * the start of the subject string.
	 * @param string the subject string
	 * @return mixed match at the start of the string or false if no match
	 */
	static public function isa($subject) {
		return (preg_match(self::MATCH, $subject, $matches) ? $matches[0] : false);
	}
}
