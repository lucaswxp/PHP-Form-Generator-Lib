<?php
/**
 * Tests of class FG_HTML_Form_Input_Checkbox
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Checkbox.php';

class FG_HTML_Form_Input_Checkbox_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$input = new FG_Html_Form_Input_Checkbox();
		$this->assertEquals('<input type="hidden" value="0" /><input type="checkbox" value="1" />', $input->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElementWithoutHiddenInput(){
		$input = new FG_Html_Form_Input_Checkbox();
		$this->assertEquals('<input type="checkbox" value="1" />', $input->setHiddenInput(false)->render());
	}
}