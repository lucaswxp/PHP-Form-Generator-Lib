<?php
/**
 * Test class
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.Util
 */
require_once realpath(dirname(__FILE__) . '../../') . 'fg/load.php';

class Html_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testReturn(){
		$this->assertInstanceOf('FG_HTML_Element', Html::tag('a'));
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testTagWithContent(){
		$this->assertEquals('<div>content</div>', Html::tag('div', 'content')->render());
	}
}