<?php
/**
 * Tests of class FG_HTML_Element_Option
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Element
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Element/FG_HTML_Element_Option.php';

class FG_HTML_Element_Option_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testTag(){
		$tag = new FG_HTML_Element_Option();
		$this->assertEquals('<option></option>', $tag->render());
	}
}