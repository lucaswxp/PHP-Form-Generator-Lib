<?php
/**
 * Tests of class FG_HTML_Form_DataHandler
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.HTML.Form
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/FG_HTML_Form_DataHandler.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Text.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_TextArea.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_File.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Select.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/FG_HTML_Form_Input_Password.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/Collection/FG_HTML_Form_Input_Collection_Checkbox.php';
require_once realpath(dirname(__FILE__) . '../../') . 'fg/HTML/Form/Input/Collection/FG_HTML_Form_Input_Collection_Radio.php';

class FG_HTML_Form_DataHandler_Test extends PHPUnit_Framework_TestCase{
	
/**
 * @var array
 */
	public $_data = array(
			'user' => array('name' => 'Lucas', 'password' => 'something'), // text
			'gender' => 'M', // radio
			'question' => array('yes', 'maybe', 'no'),
			'like' => array(
				'yes' => array('develop', 'games', 'animes', 'ofcourse_girls'), // checkbox like[yes][]
				'no' =>  array('idontknow', 'everything')), // select multiple like[no][]
			'newsletter' => 'N', // select
		);

/**
 * test method
 * 
 * @return void
 */
	public function testFindPathFor(){
		$form = new FG_HTML_Form_DataHandler();
		$method = new ReflectionMethod(
          $form, '_findPathFor'
        );
 
        $method->setAccessible(TRUE);
 
        $this->assertEquals(
          array('name', 'of', 'my', '1', 'field'), $method->invoke($form, 'name[of][my][1][field]')
        );
        
        $this->assertEquals(
          array('name'), $method->invoke($form, 'name')
        );
	}
	
	
/**
 * test method
 * 
 * @return void
 */
	public function testGetDataByPath(){
		$form = new FG_HTML_Form_DataHandler();
		
		$form->populate($this->_data);
		
		// user
		$this->assertEquals($this->_data['user'], $form->getDataByPath('user'));
		$this->assertEquals($this->_data['user']['name'], $form->getDataByPath('user[name]'));
		$this->assertEquals($this->_data['user']['password'], $form->getDataByPath('user[password]'));
		
		// gender
		$this->assertEquals('M', $form->getDataByPath('gender'));
		
		// question
		$this->assertEquals('yes', $form->getDataByPath('question[]'));
		$this->assertEquals('maybe', $form->getDataByPath('question[]'));
		$this->assertEquals('no', $form->getDataByPath('question[]'));
		
		try{
			$form->getDataByPath('question[]');
			$this->assertTrue(false);
		} catch(OutOfBoundsException $e){}
		
		$this->assertEquals('maybe', $form->getDataByPath('question[1]'));
		
		// like
		$this->assertEquals('develop', $form->getDataByPath('like[yes][]'));
		$this->assertEquals($this->_data['like']['yes'], $form->getDataByPath('like[yes][]', true));
		$this->assertEquals($this->_data['like']['no'], $form->getDataByPath('like[no][]', true));
		$this->assertEquals('everything', $form->getDataByPath('like[no][1]'));
		
		// newslleter
		$this->assertEquals('N', $form->getDataByPath('newsletter'));
	
		# fails
		try{
			$form->getDataByPath('invalid');
			$this->assertTrue(false); 
		}catch(InvalidArgumentException $e){}
	
		try{
			$form->getDataByPath('user[invalid]');
			$this->assertTrue(false); 
		}catch(InvalidArgumentException $e){}
	
		try{
			$form->getDataByPath('user[]');
			$this->assertTrue(false); 
		}catch(OutOfBoundsException $e){}
	
		try{
			$form->getDataByPath('like[yes][9]');
			$this->assertTrue(false); 
		}catch(OutOfBoundsException $e){}
		
		try{
			$form->getDataByPath('gender[]');
			$this->assertTrue(false); 
		}catch(InvalidArgumentException $e){}
	
		try{
			$form->getDataByPath('');
			$this->assertTrue(false); 
		}catch(InvalidArgumentException $e){}
		
		try{
			$form->getDataByPath('[]');
			$this->assertTrue(false); 
		}catch(InvalidArgumentException $e){}
	}

/**
 * test method
 * 
 * @return void
 */
	public function testSimpleFormWithString(){
		$tag = new FG_HTML_Form_DataHandler();
		
		$this->assertEquals(
			$this->output('
				texttext2
			'), $tag->add('text')->add('text2')->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testAddInputs(){
		$tag = new FG_HTML_Form_DataHandler();
		$text = new FG_HTML_Form_Input_Text();
		$textarea = new FG_HTML_Form_Input_TextArea();
		
		$this->assertEquals(
			$this->output('
				<input type="text" />
				<textarea></textarea>
			'), $tag->add($text)->add($textarea)->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testReturnTheFieldsWithAddMethod(){
		$handler = new FG_HTML_Form_DataHandler(true);
		$text = new FG_HTML_Form_Input_Text();
		
		$handler->populate(array('hey' => 'yoo'));
		
		$this->assertSame($text, $handler->add($text));
		
		$this->assertEquals('<input type="text" name="hey" value="yoo" />', $handler->add($text->setName('hey'))->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testGetOnlyFieldsFromAddedContent(){
		$tag = new FG_HTML_Form_DataHandler();
		$text = new FG_HTML_Form_Input_Text();
		$textarea = new FG_HTML_Form_Input_TextArea();
		
		$this->assertEquals(2, count($tag->add($text)->add('dummy')->add($textarea)->add('another')->getFillable()));
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAddFileInput(){
		$tag = new FG_HTML_Form_DataHandler();
		$text = new FG_HTML_Form_Input_Text();
		$file = new FG_HTML_Form_Input_File();
		$textarea = new FG_HTML_Form_Input_TextArea();
		
		$this->assertEquals(
			$this->output('
				<input type="text" />
				<textarea></textarea>
				<input type="file" />
			'), $tag->add($text)->add($textarea)->add($file)->render());
			
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testCompleteForm(){
		$form = new FG_HTML_Form_DataHandler();
		
		$user['name'] = new FG_HTML_Form_Input_Text();
		$user['password'] = new FG_HTML_Form_Input_Password();
		$gender = new FG_HTML_Form_Input_Collection_Radio('gender');
		$like['yes'] = new FG_HTML_Form_Input_Collection_Checkbox('like[yes][]');
		$like['no'] = new FG_HTML_Form_Input_Select();
		$newsletter = new FG_HTML_Form_Input_Select();
		
		/** config **/
		$user['name']->setName('user[name]');
		$user['password']->setName('user[password]');
		$gender->add('M', 'Male')->add('F', 'Female');
		$like['yes']->add('option1', 'Option 1')->add('develop', 'Develop')->add('games', 'Games')->add('animes', 'Animes')->add('ofcourse_girls', 'Girls')->add('others', 'Others');
		$like['no']->setName('like[no][]')->setMultiple(true)->add('idontknow', 'Who knows?')->add('jb', 'Justin Bieber')->add('everything', 'Everything');
		$newsletter->setName('newsletter')->add('Y', 'Yes')->add('N', 'No');
		
		$form->add($user['name'])->add($user['password'])->add($gender)->add($like['yes'])->add($like['no'])->add($newsletter);
		
		$this->assertEquals(
			$this->output('
				<input type="text" name="user[name]" />
				<input type="password" name="user[password]" />
				<input type="hidden" value="" name="gender" />
				
				<div>
					<input type="radio" value="M" id="gender1" name="gender" />
					<label for="gender1">Male</label>
				</div>
				<div>
					<input type="radio" value="F" id="gender2" name="gender" />
					<label for="gender2">Female</label>
				</div>
				
				<div>
					<input type="checkbox" value="option1" id="like_yes_1" name="like[yes][]" />
					<label for="like_yes_1">Option 1</label>
				</div>
				<div>
					<input type="checkbox" value="develop" id="like_yes_2" name="like[yes][]" />
					<label for="like_yes_2">Develop</label>
				</div>
				<div>
					<input type="checkbox" value="games" id="like_yes_3" name="like[yes][]" />
					<label for="like_yes_3">Games</label>
				</div>
				<div>
					<input type="checkbox" value="animes" id="like_yes_4" name="like[yes][]" />
					<label for="like_yes_4">Animes</label>
				</div>
				<div>
					<input type="checkbox" value="ofcourse_girls" id="like_yes_5" name="like[yes][]" />
					<label for="like_yes_5">Girls</label>
				</div>
				<div>
					<input type="checkbox" value="others" id="like_yes_6" name="like[yes][]" />
					<label for="like_yes_6">Others</label>
				</div>
				
				<select name="like[no][]" multiple="multiple">
					<option value="idontknow">Who knows?</option>
					<option value="jb">Justin Bieber</option>
					<option value="everything">Everything</option>
				</select>
				
				<select name="newsletter">
					<option value="Y">Yes</option>
					<option value="N">No</option>
				</select>
			'), $form->render());
			
			
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testCompleteFormPopulated(){
		$form = new FG_HTML_Form_DataHandler();
		
		$user['name'] = new FG_HTML_Form_Input_Text();
		$user['password'] = new FG_HTML_Form_Input_Password();
		$gender = new FG_HTML_Form_Input_Collection_Radio('gender');
		$like['yes'] = new FG_HTML_Form_Input_Collection_Checkbox('like[yes][]');
		$like['no'] = new FG_HTML_Form_Input_Select();
		$newsletter = new FG_HTML_Form_Input_Select();
		
		/** config **/
		$user['name']->setName('user[name]');
		$user['password']->setName('user[password]');
		$gender->add('M', 'Male')->add('F', 'Female');
		$like['yes']->add('option1', 'Option 1')->add('develop', 'Develop')->add('games', 'Games')->add('animes', 'Animes')->add('ofcourse_girls', 'Girls')->add('others', 'Others');
		$like['no']->setName('like[no][]')->setMultiple(true)->add('idontknow', 'Who knows?')->add('jb', 'Justin Bieber')->add('everything', 'Everything');
		$newsletter->setName('newsletter')->add('Y', 'Yes')->add('N', 'No');
		
		$form->add($user['name'])->add($user['password'])->add($gender)->add($like['yes'])->add($like['no'])->add($newsletter);
		
		
		$form->populate($this->_data);
		
		$this->assertEquals(
			$this->output('
				<input type="text" name="user[name]" value="Lucas" />
				<input type="password" name="user[password]" value="something" />
				<input type="hidden" value="" name="gender" />
				
				<div>
					<input type="radio" value="M" id="gender1" name="gender" checked="checked" />
					<label for="gender1">Male</label>
				</div>
				<div>
					<input type="radio" value="F" id="gender2" name="gender" />
					<label for="gender2">Female</label>
				</div>
				
				<div>
					<input type="checkbox" value="option1" id="like_yes_1" name="like[yes][]" />
					<label for="like_yes_1">Option 1</label>
				</div>
				<div>
					<input type="checkbox" value="develop" id="like_yes_2" name="like[yes][]" checked="checked" />
					<label for="like_yes_2">Develop</label>
				</div>
				<div>
					<input type="checkbox" value="games" id="like_yes_3" name="like[yes][]" checked="checked" />
					<label for="like_yes_3">Games</label>
				</div>
				<div>
					<input type="checkbox" value="animes" id="like_yes_4" name="like[yes][]" checked="checked" />
					<label for="like_yes_4">Animes</label>
				</div>
				<div>
					<input type="checkbox" value="ofcourse_girls" id="like_yes_5" name="like[yes][]" checked="checked" />
					<label for="like_yes_5">Girls</label>
				</div>
				<div>
					<input type="checkbox" value="others" id="like_yes_6" name="like[yes][]" />
					<label for="like_yes_6">Others</label>
				</div>
				
				<select name="like[no][]" multiple="multiple">
					<option value="idontknow" selected="selected">Who knows?</option>
					<option value="jb">Justin Bieber</option>
					<option value="everything" selected="selected">Everything</option>
				</select>
				
				<select name="newsletter">
					<option value="Y">Yes</option>
					<option value="N" selected="selected">No</option>
				</select>
			'), $form->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testCompleteFormPopulatedButWithSomeFieldsAreadyFilled(){
		$form = new FG_HTML_Form_DataHandler();
		
		$user['name'] = new FG_HTML_Form_Input_Text();
		$user['password'] = new FG_HTML_Form_Input_Password();
		$gender = new FG_HTML_Form_Input_Collection_Radio('gender');
		$like['yes'] = new FG_HTML_Form_Input_Collection_Checkbox('like[yes][]');
		$like['no'] = new FG_HTML_Form_Input_Select();
		$newsletter = new FG_HTML_Form_Input_Select();
		
		/** config **/
		$user['name']->setName('user[name]');
		$user['password']->setName('user[password]')->fill('uhuuu');
		$gender->add('M', 'Male')->add('F', 'Female');
		$like['yes']->add('option1', 'Option 1')->add('develop', 'Develop')->add('games', 'Games')->add('animes', 'Animes')->add('ofcourse_girls', 'Girls')->add('others', 'Others');
		$like['no']->setName('like[no][]')->setMultiple(true)->add('idontknow', 'Who knows?')->add('jb', 'Justin Bieber')->add('everything', 'Everything')->fill('everything');
		$newsletter->setName('newsletter')->add('Y', 'Yes')->add('N', 'No');
		
		$form->add($user['name'])->add($user['password'])->add($gender)->add($like['yes'])->add($like['no'])->add($newsletter);
		
		
		$form->populate($this->_data);
		
		$this->assertEquals(
			$this->output('
				<input type="text" name="user[name]" value="Lucas" />
				<input type="password" name="user[password]" value="uhuuu" />
				<input type="hidden" value="" name="gender" />
				
				<div>
					<input type="radio" value="M" id="gender1" name="gender" checked="checked" />
					<label for="gender1">Male</label>
				</div>
				<div>
					<input type="radio" value="F" id="gender2" name="gender" />
					<label for="gender2">Female</label>
				</div>
				
				<div>
					<input type="checkbox" value="option1" id="like_yes_1" name="like[yes][]" />
					<label for="like_yes_1">Option 1</label>
				</div>
				<div>
					<input type="checkbox" value="develop" id="like_yes_2" name="like[yes][]" checked="checked" />
					<label for="like_yes_2">Develop</label>
				</div>
				<div>
					<input type="checkbox" value="games" id="like_yes_3" name="like[yes][]" checked="checked" />
					<label for="like_yes_3">Games</label>
				</div>
				<div>
					<input type="checkbox" value="animes" id="like_yes_4" name="like[yes][]" checked="checked" />
					<label for="like_yes_4">Animes</label>
				</div>
				<div>
					<input type="checkbox" value="ofcourse_girls" id="like_yes_5" name="like[yes][]" checked="checked" />
					<label for="like_yes_5">Girls</label>
				</div>
				<div>
					<input type="checkbox" value="others" id="like_yes_6" name="like[yes][]" />
					<label for="like_yes_6">Others</label>
				</div>
				
				<select name="like[no][]" multiple="multiple">
					<option value="idontknow">Who knows?</option>
					<option value="jb">Justin Bieber</option>
					<option value="everything" selected="selected">Everything</option>
				</select>
				
				<select name="newsletter">
					<option value="Y">Yes</option>
					<option value="N" selected="selected">No</option>
				</select>
			'), $form->render());
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