<?php
/**
 * Tests of class FG_HTML_Form_Input_AbstractIdentifiable
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_AbstractIdentifiable.php';

class FG_HTML_Form_Input_AbstractIdentifiable_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testBaseNameWithArrayName(){
		$input = $this->getMocked();
		
		$input->expects($this->any())->method('getName')->will($this->returnValue('myarray[name]'));
		$this->assertEquals('myarray', $input->getBaseName());
	}
/**
 * test method
 * 
 * @return void
 */
	public function testBaseNameWithNonArrayName(){
		$input = $this->getMocked();
		$input->expects($this->any())->method('getName')->will($this->returnValue('regular_name'));
		$this->assertEquals('regular_name', $input->getBaseName());
	}
	
/**
 * get mock
 * 
 * @return FG_HTML_Form_Input_AbstractInput
 */
	public function getMocked(){
		return $this->getMockForAbstractClass('FG_HTML_Form_Input_AbstractIdentifiable');
	}
}