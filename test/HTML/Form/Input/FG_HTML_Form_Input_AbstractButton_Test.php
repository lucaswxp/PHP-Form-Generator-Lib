<?php
/**
 * Tests of class FG_HTML_Form_Input_AbstractButton
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_AbstractButton.php';

class FG_HTML_Form_Input_AbstractButton_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElementWithLabelAlignedToRight(){
		$input = $this->getMocked();
		$this->assertEquals('<input /><label>my</label>', $input->setLabel('my')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testFillChecked(){
		$input = $this->getMocked();
		$this->assertEquals('<input checked="checked" />', $input->fill(true)->render());
	}
	
/**
 * get mock
 * 
 * @return FG_HTML_Form_Input_AbstractInput
 */
	public function getMocked(){
		return $this->getMockForAbstractClass('FG_HTML_Form_Input_AbstractButton');
	}
}