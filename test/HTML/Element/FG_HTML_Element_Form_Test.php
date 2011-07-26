<?php
/**
 * Tests of class FG_HTML_Element_Form
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Element
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Element/FG_HTML_Element_Form.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Text.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_TextArea.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_File.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Select.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Password.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/Collection/FG_HTML_Form_Input_Collection_Checkbox.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/Collection/FG_HTML_Form_Input_Collection_Radio.php';

class FG_HTML_Element_Form_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testCreateSimpleForm(){
		$tag = new FG_HTML_Element_Form();
		$this->assertEquals('<form></form>', $tag->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testSimpleForm(){
		$tag = new FG_HTML_Element_Form();
		
		$this->assertEquals(
			$this->output('
			<form>
			</form>
			'), $tag->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testAddInputs(){
		$tag = new FG_HTML_Element_Form();
		$text = new FG_HTML_Form_Input_Text();
		$textarea = new FG_HTML_Form_Input_TextArea();
		
		$this->assertEquals(
			$this->output('
			<form>
				<input type="text" />
				<textarea></textarea>
			</form>
			'), $tag->add($text)->add($textarea)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddFileInput(){
		$tag = new FG_HTML_Element_Form();
		$text = new FG_HTML_Form_Input_Text();
		$file = new FG_HTML_Form_Input_File();
		$textarea = new FG_HTML_Form_Input_TextArea();
		
		$this->assertEquals(
			$this->output('
			<form enctype="multipart/form-data">
				<input type="text" />
				<textarea></textarea>
				<input type="file" />
			</form>
			'), $tag->add($text)->add($textarea)->add($file)->render());
			
		$this->assertEquals(
			$this->output('
			<form>
				<input type="text" />
				<textarea></textarea>
				<input type="file" />
			</form>
			'), $tag->setMultipart(false)->render());
			
		$this->assertEquals(
			$this->output('
			<form enctype="something">
				<input type="text" />
				<textarea></textarea>
				<input type="file" />
				<input type="file" />
			</form>
			'), $tag->setMultipart(true)->setEnctype('something')->add($file)->render());
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