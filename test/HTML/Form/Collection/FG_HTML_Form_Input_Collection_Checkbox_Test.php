<?php
/**
 * Tests of class FG_HTML_Form_Input_Collection_Checkbox
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input.Collection
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/Collection/FG_HTML_Form_Input_Collection_Checkbox.php';

class FG_HTML_Form_Input_Collection_Checkbox_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$c = new FG_HTML_Form_Input_Collection_Checkbox('name');
		$c->add('value', false);
		$this->assertEquals('<div><input type="checkbox" value="value" id="name1" name="name" /></div>', $c->render());
	}
}