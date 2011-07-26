<?php
/**
 * Tests of class FG_HTML_Form_Input_Select
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Select.php';

class FG_HTML_Form_Input_Select_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$input = new FG_Html_Form_Input_Select();
		$this->assertEquals('<select></select>', $input->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testSelectWithOptionAsString(){
		$input = new FG_Html_Form_Input_Select();
		$this->assertEquals(
			$this->output(
				'<select>
					<option value="value">Text</option>
				</select>'
						)
			, $input->add('value', 'Text')->render());
	}
/**
 * test method
 * 
 * @return void
 */
	public function testAddStringOptionWithoutText(){
		$input = new FG_Html_Form_Input_Select();
	
		try{
			$input->add('value');
		}catch (InvalidArgumentException $e){}
	}

/**
 * test method
 * 
 * @return void
 */
	public function testSelectWithOptionWithOptionSpecificObject(){
		$input = new FG_Html_Form_Input_Select();
		$option = new FG_HTML_Element_Option();
		
		$this->assertEquals(
			$this->output(
				'<select>
					<option value="value" class="myoption">Text</option>
				</select>'
						)
			, $input->add($option->setValue('value')->setClass('myoption')->setContent('Text'))->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testSetSelectedOptionNotMultiple(){
		$input = new FG_Html_Form_Input_Select();
		
		// add some options
		$input->add('option1', 'option 1')
				->add('option2', 'option 2')
				->add('option3', 'option 3')
				->add('option4', 'option 4');
		
				
		// selected
		$this->assertEquals('option3', $input->setValue('option3')->getValue());

		$this->assertEquals(
			$this->output(
				'<select>
					<option value="option1">option 1</option>
					<option value="option2">option 2</option>
					<option value="option3" selected="selected">option 3</option>
					<option value="option4">option 4</option>
				</select>'
						)
			, $input->render());
			
		$this->assertEquals('option1', $input->setValue(array('option3', 'option1'))->getValue()); // brings just one value because is not multiple
	}

/**
 * test method
 * 
 * @return void
 */
	public function testSetSelectedOptionMultiple(){
		$input = new FG_Html_Form_Input_Select();
		
		// add some options
		$input->add('option1', 'option 1')
				->add('option2', 'option 2')
				->add('option3', 'option 3')
				->add('option4', 'option 4');
		
				
		// selected
		$this->assertFalse($input->isMultiFillable());
		$this->assertEquals(array('option3'), $input->setMultiple(true)->setValue(array('option3'))->getValue());
		$this->assertTrue($input->isMultiFillable());
		
		$this->assertEquals(
			$this->output(
				'<select multiple="multiple">
					<option value="option1">option 1</option>
					<option value="option2">option 2</option>
					<option value="option3" selected="selected">option 3</option>
					<option value="option4">option 4</option>
				</select>'
						)
			, $input->render());
			
		$this->assertEquals(array('option1', 'option3'), $input->setValue(array('option3', 'option1'))->getValue());
		
		// multiple values
		$this->assertEquals(
			$this->output(
				'<select multiple="multiple">
					<option value="option1" selected="selected">option 1</option>
					<option value="option2">option 2</option>
					<option value="option3" selected="selected">option 3</option>
					<option value="option4">option 4</option>
				</select>'
						)
			, $input->render());
	}
	
/**
 * Gets output with no tabs and newlines
 * 
 * @param string $output
 */
	public function output($output){
		return str_replace(array("\t", "\n"), '', $output);
	}
}