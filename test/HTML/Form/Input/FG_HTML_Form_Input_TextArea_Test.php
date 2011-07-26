<?php
/**
 * Tests of class FG_HTML_Form_Input_TextArea
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_TextArea.php';

class FG_HTML_Form_Input_TextArea_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$input = new FG_Html_Form_Input_TextArea();
		$this->assertEquals('<textarea></textarea>', $input->render());
	}
/**
 * test method
 * 
 * @return void
 */
	public function testTextAreaContent(){
		$input = new FG_Html_Form_Input_TextArea();
		$this->assertEquals('<textarea>value</textarea>', $input->setValue('value')->render());
		$this->assertEquals('value', $input->getValue());
	}
}