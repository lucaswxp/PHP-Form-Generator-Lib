<?php
/**
 * Tests of class FG_HTML_Form_Input_Colletion_Radio
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input.Collection
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/Collection/FG_HTML_Form_Input_Collection_Radio.php';

class FG_HTML_Form_Input_Collection_Radio_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$c = new FG_HTML_Form_Input_Collection_Radio('name');
		$c->add('value', false);
		$this->assertEquals('<input type="hidden" value="" name="name" /><div><input type="radio" value="value" id="name1" name="name" /></div>', $c->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testFill(){
		$c = new FG_HTML_Form_Input_Collection_Radio('name');
		$c->add('value', false)->add('value2', false)->add('value3', false)->fill(array('value', 'value2'));
		$this->assertFalse($c->getFilled());
		$c->fill('value');
		$this->assertEquals('<input type="hidden" value="" name="name" /><div><input type="radio" value="value" id="name1" name="name" checked="checked" /></div><div><input type="radio" value="value2" id="name2" name="name" /></div><div><input type="radio" value="value3" id="name3" name="name" /></div>', $c->render());
		$this->assertEquals('value', $c->getFilled());
	}
}