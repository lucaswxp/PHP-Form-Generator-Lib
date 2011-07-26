<?php
/**
 * Tests of class FG_HTML_Form_Input_Collection_AbstractCollection
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input.Collection
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_AbstractButton.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/Collection/FG_HTML_Form_Input_Collection_AbstractCollection.php';

class FG_HTML_Form_Input_Collection_AbstractCollection_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$c = $this->getMocked();
		$this->assertEquals('', $c->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddElementWithNoLabel(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<div>
				<input value="myvalue" id="name_1" name="name[]" />
			</div>'
		), $c->add('myvalue', false)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddElementWithJustLabel(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<div>
				<input value="1" id="name_1" name="name[]" />
				<label for="name_1">My label</label>
			</div>'
		), $c->add('My label')->render());
		
		// label object
		$c = $this->getMocked();
		$label = new FG_HTML_Element_Label();
		$this->assertEquals($this->output(
			'<div>
				<input value="1" id="name_1" name="name[]" />
				<label></label>
			</div>'
		), $c->add($label)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddElementWithLabelAndWithValue(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<div>
				<input value="myvalue" id="name_1" name="name[]" />
				<label for="name_1">Label</label>
			</div>'
		), $c->add('myvalue', 'Label')->render());
		
		// label object
		$c = $this->getMocked();
		$label = new FG_HTML_Element_Label();
		$this->assertEquals($this->output(
			'<div>
				<input value="myvalue" id="name_1" name="name[]" />
				<label></label>
			</div>'
		), $c->add('myvalue', $label)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddElementWithLabelAndAttrs(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<div>
				<input attr="attr" value="1" id="name_1" name="name[]" />
				<label for="name_1">Label</label>
			</div>'
		), $c->add('Label', array('attr' => 'attr'))->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddElementWithLabelAndAttrValue(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<div>
				<input attr="attr" value="value" id="name_1" name="name[]" />
				<label for="name_1">Label</label>
			</div>'
		), $c->add('value', 'Label', array('attr' => 'attr'))->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testAddElementWithValueAndLabelAndAttr(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<div>
				<input attr="attr" value="value" id="name_1" name="name[]" />
				<label for="name_1">Label</label>
			</div>'
		), $c->add('value', 'Label', array('attr' => 'attr'))->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testLIAsWrapper(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<li>
				<input value="1" id="name_1" name="name[]" />
				<label for="name_1">label</label>
			</li>'
		), $c->add('label')->setWrapper(new FG_HTML_Element('li'))->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testWithNoWrapper(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'
				<input value="1" id="name_1" name="name[]" />
				<label for="name_1">label</label>
			'
		), $c->add('label')->setWrapper(null)->render());
	}

	
/**
 * test method
 * 
 * @return void
 */
	public function testUseAHiddenField(){
		$c = $this->getMocked('name');
		$this->assertEquals($this->output(
			'	<input type="hidden" value="" name="name" />
				<input value="1" id="name1" name="name" />
				<label for="name1">label</label>
			'
		), $c->add('label')->setHiddenInput(true)->setWrapper(null)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testUseAHiddenFieldWithBackBraces(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'	<input type="hidden" value="" name="name" />
				<input value="1" id="name_1" name="name[]" />
				<label for="name_1">label</label>
			'
		), $c->add('label')->setHiddenInput(true)->setWrapper(null)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddSeveralInputs(){
		$c = $this->getMocked();
		$this->assertEquals($this->output(
			'<div>
				<input value="1" id="name_1" name="name[]" />
				<label for="name_1">label</label>
			</div>
			<div>
				<input value="2" id="name_2" name="name[]" />
				<label for="name_2">label2</label>
			</div>
			<div>
				<input value="3" id="name_3" name="name[]" />
				<label for="name_3">label3</label>
			</div>
			<div>
				<input value="4" id="name_4" name="name[]" />
				<label for="name_4">label4</label>
			</div>'
		), $c->add('label')->add('label2')->add('label3')->add('label4')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testFillValues(){
		$c = $this->getMocked();
		
		$this->assertEquals($this->output(
			'<div>
				<input value="1" id="name_1" name="name[]" checked="checked" />
				<label for="name_1">label</label>
			</div>
			<div>
				<input value="2" id="name_2" name="name[]" />
				<label for="name_2">label2</label>
			</div>
			<div>
				<input value="3" id="name_3" name="name[]" checked="checked" />
				<label for="name_3">label3</label>
			</div>
			<div>
				<input value="4" id="name_4" name="name[]" />
				<label for="name_4">label4</label>
			</div>'
		), $c->add('label')->add('label2')->add('label3')->add('label4')->fill(array(1,3))->render());
	}
	
/**
 * get mock
 * 
 * @return FG_HTML_Form_Input_Collection_AbstractCollection
 */
	public function getMocked($name = 'name[]'){
		$v = get_class($this->getMockForAbstractClass('FG_HTML_Form_Input_AbstractButton'));
		$s = $this->getMockForAbstractClass('FG_HTML_Form_Input_Collection_AbstractCollection', array($name));
		$s->expects($this->any())->method('getInputClass')->will($this->returnValue($v));
		return $s;
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