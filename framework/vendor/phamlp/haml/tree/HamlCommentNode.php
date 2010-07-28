<?php
/* SVN FILE: $Id: HamlCommentNode.php 4 2010-03-29 15:04:19Z chris.l.yates $ */
/**
 * HamlNode class file.
 * @author Chris Yates
 * @copyright Copyright &copy; 2010 PBM Web Development
 * @license http://www.yiiframework.com/license/
 */

/**
 * HamlNode class.
 * Base class for all Haml nodes.
 * @author Chris Yates
 * @copyright Copyright &copy; 2010 PBM Web Development
 * @license http://www.yiiframework.com/license/
 */
class HamlCommentNode extends HamlNode {
	private $isConditional;

	public function __construct($content) {
	  $this->content = $content;
		$this->isConditional = (bool)preg_match('/^\[.+\]$/', $content, $matches);
	}

	public function getIsConditional() {
		return $this->isConditional;
	}

	public function render() {
		$output  = $this->renderer->renderOpenComment($this);
		foreach ($this->children as $child) {
			$output .= $child->render();
		} // foreach
		$output .= $this->renderer->renderCloseComment($this);
	  return $this->debug($output);
	}
}