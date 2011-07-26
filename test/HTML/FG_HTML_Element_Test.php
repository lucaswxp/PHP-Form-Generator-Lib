<?php
/**
 * Tests of class FG_HTML_Element
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/FG_HTML_Element.php';

class FG_HTML_Element_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testVoidBehaviour(){
		$tag = new FG_HTML_Element('img');
		$this->assertEquals('<img />', $tag->render());
		
		$tag = new FG_HTML_Element('a');
		$this->assertEquals('<a></a>', $tag->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSlugifyAttr(){
		$tag = new FG_HTML_Element('a');
		$this->assertEquals('<a id="a_id_here"></a>', $tag->attr('id', 'a id here')->render());
		
		$tag = new FG_HTML_Element('a');
		$this->assertEquals('<a for="a_id_here"></a>', $tag->attr('for', 'a id here')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testBooleanAttrs(){
		$tag = new FG_HTML_Element('a');
		$this->assertEquals('<a id="1"></a>', $tag->attr('id', true)->render());
		
		$tag = new FG_HTML_Element('a');
		$this->assertEquals('<a checked="checked"></a>', $tag->attr('checked', true)->render());
		$this->assertTrue($tag->isAttr('checked'));
		$this->assertEquals('<a></a>', $tag->attr('checked', false)->render());
		$this->assertFalse($tag->isAttr('checked'));
		$this->assertFalse($tag->attr('checked'));
	}
}