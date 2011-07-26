<?php
/**
 * Tests of class FG_HTML_Form_Input_Hidden
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form.Input
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Hidden.php';

class FG_HTML_Form_Input_Hidden_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testConstructElement(){
		$input = new FG_HTML_Form_Input_Hidden();
		$this->assertEquals('<input type="hidden" />', $input->render());
	}
}