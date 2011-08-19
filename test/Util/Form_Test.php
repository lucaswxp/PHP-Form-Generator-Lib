<?php
/**
 * Test class
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.Util
 */
require_once realpath(dirname(__FILE__) . '../../') . 'fg/Util/Form.php';

class Form_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testReturnType(){
		$this->assertInstanceOf('FG_HTML_Form_Input_Text', Form::text('name'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Hidden', Form::hidden('name'));
		$this->assertInstanceOf('FG_HTML_Form_Input_TextArea', Form::textArea('name'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Select', Form::select('name'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Radio', Form::radio('name'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Checkbox', Form::checkbox('name'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Text', Form::text('invalid'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Submit', Form::submit('val'));
		$this->assertInstanceOf('FG_HTML_Form_Input_File', Form::file('name'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Password', Form::password('name'));
		$this->assertInstanceOf('FG_HTML_Element_Form', Form::create('action'));
		$this->assertInstanceOf('FG_HTML_Element_Form', Form::start('action'));
		$this->assertInstanceOf('FG_HTML_Form_DataHandler', Form::init());
		$this->assertInstanceOf('FG_HTML_Form_Input_Collection_Checkbox', Form::checkboxes('some'));
		$this->assertInstanceOf('FG_HTML_Form_Input_Collection_Radio', Form::radios('some'));
	}
/**
 * test method
 * 
 * @return void
 */
	public function testFormCreate(){
		$this->assertEquals('<form>', Form::create(true)->render());
		$this->assertEquals('<form action="">', Form::create('', true)->render());
		$this->assertEquals('<form></form>', Form::create()->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testBasics(){
		$this->assertEquals('<input type="text" name="name" />', Form::text('name')->render());
		$this->assertEquals('<label for="name">Label</label><input type="text" name="name" id="name" />', Form::text('name')->setLabel('Label')->render());
		$this->assertEquals('<select name="name"><option value="value">Option</option></select>', Form::select('name')->add('value', 'Option')->render());
		$this->assertEquals('<input type="text" name="name" />', Form::text('name')->render());
	}
}