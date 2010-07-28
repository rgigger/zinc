<?php
/* SVN FILE: $Id: SassContext.php 1 2010-03-21 11:35:45Z chris.l.yates $ */
/**
 * SassContext class file.
 * @author Chris Yates
 * @copyright Copyright &copy; 2010 PBM Web Development
 * @license http://www.yiiframework.com/license/
 */

/**
 * SassContext class.
 * Defines the context that the parser is operating in and so allows variables
 * to be scoped.
 * A new context is created for Mixins and imported files.
 * @author Chris Yates
 * @copyright Copyright &copy; 2010 PBM Web Development
 * @license http://www.yiiframework.com/license/
 */
class SassContext {
	/**
	 * @var SassContext enclosing context
	 */
	protected $parent;
	/**
	 * @var array mixins defined in this context
	 */
	protected $mixins = array();
	/**
	 * @var array variables defined in this context
	 */
	protected $variables = array();

	/**
	 * SassContext constructor.
	 * @param mixed array - options for the context, SassContext - the enclosing context
	 * @return SassContext
	 */
	public function __construct($parent = null) {
		$this->parent = $parent;
	}

	/**
	 * Adds a mixin
	 * @param string name of mixin
	 * @return SassMixinDefinitionNode the mixin
	 */
	public function addMixin($name, $mixin) {
		$this->mixins[$name] = $mixin;
		return $this;
	}

	/**
	 * Returns a mixin
	 * @param string name of mixin to return
	 * @return SassMixinDefinitionNode the mixin
	 * @throws SassContextException if mixin not defined in this context
	 */
	public function getMixin($name) {
		if (isset($this->mixins[$name])) {
			return $this->mixins[$name];
		}
		elseif (!empty($this->parent)) {
			return $this->parent->getMixin($name);
		}
		throw new SassContextException("Undefined Mixin: $name");
	}

	/**
	 * Returns a variable defined in this context
	 * @param string name of variable to return
	 * @return string the variable
	 * @throws SassContextException if variable not defined in this context
	 */
	public function getVariable($name) {
		if (isset($this->variables[$name])) {
			return $this->variables[$name];
		}
		elseif (!empty($this->parent)) {
			return $this->parent->getVariable($name);
		}
		else {
			throw new SassContextException("Undefined Variable: \"$name\"");
		}
	}

	/**
	 * Returns a value indicating if the variable exists in this context
	 * @param string name of variable to test
	 * @return boolean true if the variable exists in this context, false if not
	 */
	public function hasVariable($name) {
		return isset($this->variables[$name]);
	}

	/**
	 * Sets a variable to the given value
	 * @param string name of variable
	 * @param string value of variable
	 */
	public function setVariable($name, $value) {
		$this->variables[$name] = $value;
		return $this;
	}

	/**
	 * Makes variables and mixins from this context available in the parent context.
	 * Note that is there are variables or mixins with the same name in the two
	 * contexts they will be set to that defined in this context.
	 */
	public function merge() {
	  $this->parent->variables =
	  	array_merge($this->parent->variables, $this->variables);
	  $this->parent->mixins = array_merge($this->parent->mixins, $this->mixins);
	}
}