<?php
/* SVN FILE: $Id: HamlCompressedRenderer.php 4 2010-03-29 15:04:19Z chris.l.yates $ */
/**
 * HamlCompressedRenderer class file.
 * Output is on one line with minimal whitespace.
 * @package sass
 * @author Chris Yates
 * @copyright Copyright &copy; 2010 PBM Web Development
 * @license http://www.yiiframework.com/license/
 */

/**
 * HamlCompressedRenderer class.
 * @package sass
 * @author Chris Yates
 */
class HamlCompressedRenderer extends HamlRenderer {
	/**
	 * Renders the opening of a comment.
	 * Only conditional comments are rendered
	 */
	public function renderOpenComment($node) {
		if ($node->isConditional) return parent::renderOpenComment($node);
	}

	/**
	 * Renders the closing of a comment.
	 * Only conditional comments are rendered
	 */
	public function renderCloseComment($node) {
		if ($node->isConditional) return parent::renderCloseComment($node);
	}
}