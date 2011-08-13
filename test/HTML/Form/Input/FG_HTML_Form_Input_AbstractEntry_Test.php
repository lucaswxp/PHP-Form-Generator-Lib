<?php
/**
 * Tests of class FG_HTML_Form_Input_AbstractEntry
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_AbstractEntry.php';

class FG_HTML_Form_Input_AbstractEntry_Test extends PHPUnit_Framework_TestCase{

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
 * test method
 * 
 * @return void
 */
	public function testSetContentBefore(){
		$input = $this->getMocked();
		$this->assertEquals('before<input />', $input->setContentBefore('before')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetContentAfter(){
		$input = $this->getMocked();
		$this->assertEquals('<input />after', $input->setContentAfter('after')->render());
	}
	
/**
 * get mock
 * 
 * @return FG_HTML_Form_Input_AbstractEntry
 */
	public function getMocked(){
		$mock = $this->getMockForAbstractClass('FG_HTML_Form_Input_AbstractEntry');
		$mock->expects($this->any())->method('getField')->will($this->returnValue('<input />'));
		return $mock;
	}
}