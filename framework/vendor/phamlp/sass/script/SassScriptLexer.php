<?php
/* SVN FILE: $Id: SassScriptLexer.php 1 2010-03-21 11:35:45Z chris.l.yates $ */
/**
 * SassCalculator class file.
 * Calculates values from expressions
 * @package sass
 * @author Chris Yates
 * @copyright Copyright &copy; 2010 PBM Web Development
 * @license http://www.yiiframework.com/license/
 */

require_once('literals/SassLiteral.php');
require_once('SassScriptFunction.php');
require_once('SassScriptOperation.php');

/**
 * SassCalculator class
 * @author Chris Yates
 * @package sass
 */
class SassScriptLexer {
	const MATCH_WHITESPACE = '/^\s+/';

	/**
	 * Lex a string into SassScript tokens and transform to
	 * Reverse Polish Notation using the Shunting Yard Algorithm.
	 * @param string string to lex
	 * @return array tokens in RPN
	 */
	public function lex($string) {
		$outputQueue = array();
		$operatorStack = array();

		while (strlen($string)) {
			$token = $this->nextToken($string); // Read a token.

			// If the token is a number or function add it to the output queue.
 			if ($token instanceof SassLiteral || $token instanceof SassScriptFunction) {
				array_push($outputQueue, $token);
			}
			// If the token is an operation
			elseif ($token instanceof SassScriptOperation) {
				// If the token is a left parenthesis push it onto the stack.
				if ($token->operator == SassScriptOperation::$operators['('][0]) {
					array_push($operatorStack, $token);
				}
				//If the token is a right parenthesis:
				elseif ($token->operator == SassScriptOperation::$operators[')'][0]) {
					while ($c = count($operatorStack)) {
						// If the token at the top of the stack is a left parenthesis
						if ($operatorStack[$c - 1]->operator == SassScriptOperation::$operators['('][0]) { 							// Pop the left parenthesis from the stack, but not onto the output queue.
							array_pop($operatorStack);
							break;
						}
						// else pop the operator off the stack onto the output queue.
						array_push($outputQueue, array_pop($operatorStack));
					}
					// If the stack runs out without finding a left parenthesis
					// there are mismatched parentheses.
					if ($c == 0) {
						throw new SassScriptLexerException('Unmatched parentheses');
					}
				}
				// the token is an operator, o1, so:
				else {
					// while there is an operator, o2, at the top of the stack
					while ($c = count($operatorStack)) {
						$operation = $operatorStack[$c - 1];
						// if o2 is left parenthesis, or
						// the o1 has left associativty and greater precedence than o2, or
						// the o1 has right associativity and lower or equal precedence than o2
						if (($operation->operator == SassScriptOperation::$operators['('][0]) ||
							($token->associativity == 'l' && $token->precedence > $operation->precedence) ||
							($token->associativity == 'r' && $token->precedence <= $operation->precedence)) {
							break; // stop checking operators
						}
						//pop o2 off the stack and onto the output queue
						array_push($outputQueue, array_pop($operatorStack));
					}
					// push o1 onto the stack
					array_push($operatorStack, $token);
				}
			}
		}

		// When there are no more tokens
		while ($c = count($operatorStack)) { // While there are operators on the stack:
			if ($operatorStack[$c - 1]->operator !== SassScriptOperation::$operators['('][0]) {
				array_push($outputQueue, array_pop($operatorStack));
			}
			else {
				throw new SassScriptLexerException('Unmatched parentheses');
			}
		}
		return $outputQueue;
	}

	/**
	 * Returns the next token from the string.
	 * @param string string to tokenise
	 * @return mixed token. Either a SassLiteral, a SassScriptOperation
	 * @throws SassScriptLexerException if unable to tokenise string
	 */
	private function nextToken(&$string) {
		if (($match = $this->isWhitespace($string)) !== false) {
			$string = substr($string, strlen($match));
			return $this->nextToken($string);
		}
		elseif (($match = SassNumber::isa($string)) !== false) {
			$string = substr($string, strlen($match));
			return new SassNumber($match);
		}
		elseif (($match = SassColour::isa($string)) !== false) {
			$string = substr($string, strlen($match));
			return new SassColour($match);
		}
		elseif (($match = SassBoolean::isa($string)) !== false) {
			$string = substr($string, strlen($match));
			return new SassBoolean($match);
		}
		elseif (($match = SassString::isa($string)) !== false) {
			$string = substr($string, strlen($match));
			return new SassString($match);
		}
		elseif (($match = SassScriptFunction::isa($string)) !== false) {
			$string = substr($string, strlen($match));
			return new SassScriptFunction($match);
		}
		elseif (($match = SassScriptOperation::isa($string)) !== false) {
			$string = substr($string, strlen($match));
			return new SassScriptOperation($match);
		}
		else {
			throw new SassScriptLexerException("Unable to tokenise \"$string\"");
		}
	}

	/**
	 * Returns a value indicating if a token of this type can be matched at
	 * the start of the subject string.
	 * @param string the subject string
	 * @return mixed match at the start of the string or false if no match
	 */
	public function isWhitespace($subject) {
		return (preg_match(self::MATCH_WHITESPACE, $subject, $matches) ? $matches[0] : false);
	}
}