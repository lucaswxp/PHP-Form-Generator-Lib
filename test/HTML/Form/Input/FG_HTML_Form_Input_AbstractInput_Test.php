<?php
/**
 * Tests of class FG_HTML_Form_Input_AbstractInput
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_AbstractInput.php';

class FG_HTML_Form_Input_AbstractInput_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$input = $this->getMocked();
		$this->assertEquals('<input />', $input->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testDecoratorPatternFromAttrMethod(){
		$input = $this->getMocked();
		$this->assertFalse($input->attr('do-not-exists'));
		$this->assertSame($input, $input->attr('attr', 'value'));
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testDecoratorPatternFromDynamicAttrMethod(){
		$input = $this->getMocked();
		$this->assertSame($input, $input->setAttr('val'));
		
		try{
			$input->doNotExists();
		}catch(RuntimeException $e){}
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testIsFilled(){
		$input = $this->getMocked();
		$this->assertFalse($input->isFilled());
		$input->setDefault(false)->render(); // setDefault should "not" fill the element
		$this->assertFalse($input->isFilled());
		$this->assertTrue($input->fill(false)->isFilled());
		$this->assertTrue($input->fill('')->isFilled());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testDefaultValue(){
		$input = $this->getMocked();
		$this->assertEquals(array('test'), $input->setDefault(array('test'))->getDefault());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetLabelWithString(){
		$input = $this->getMocked();
		$this->assertEquals('<label>My label: </label><input />', $input->setLabel('My label: ')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetLabelWithStringWhenNameOfInputIsNotEmpty(){
		$input = $this->getMocked();
		$this->assertEquals('<label for="myname">My label: </label><input name="myname" id="myname" />', $input->attr('name', 'myname')->setLabel('My label: ')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetLabelWithStringWhenNameOfInputIsNotEmptyAndHaveInvalidCharsForIdAttribute(){
		$input = $this->getMocked();
		$this->assertEquals('<label for="myname_">My label: </label><input name="myname[]" id="myname_" />', $input->attr('name', 'myname[]')->setLabel('My label: ')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetLabelWithStringWhenIdOfInputIsNotEmpty(){
		$input = $this->getMocked();
		$this->assertEquals('<label for="myid">My label: </label><input id="myid" />', $input->attr('id', 'myid')->setLabel('My label: ')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetLabelWithALabelSpecificObject(){
		$input = $this->getMocked();
		$label = new FG_HTML_Element_Label();
		$this->assertEquals('<label class="custom">My label: </label><input id="myid" />', $input->attr('id', 'myid')->setLabel($label->attr('class', 'custom')->setContent('My label: '))->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testInputWithAllFeatures(){
		$input = $this->getMocked();
		$this->assertEquals('<label>My label: </label>before<input />after', $input->setLabel('My label: ')->setContentBefore('before')->setContentAfter('after')->render());
	}
	
/**
 * get mock
 * 
 * @return FG_HTML_Form_Input_AbstractInput
 */
	public function getMocked(){
		return $this->getMockForAbstractClass('FG_HTML_Form_Input_AbstractInput');
	}
}