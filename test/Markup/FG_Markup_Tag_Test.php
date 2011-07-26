<?php
/**
 * Tests of class FG_Markup_Tag
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.test.Markup
 */

require_once realpath(dirname(__FILE__) . '../../') . 'fg/Markup/FG_Markup_Tag.php';

class FG_Markup_Tag_Test extends PHPUnit_Framework_TestCase{

/**
 * test method
 * 
 * @return void
 */
	public function testBasicTag(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag></tag>', $tag->render());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testVoidTag(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag />', $tag->setVoid(true)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testIfTagWithNoContentReturnsFalse(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertFalse($tag->getContent());
	}

/**
 * test method
 * 
 * @return void
 */
	public function testSetTagContent(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag>content</tag>', $tag->setContent('content')->render());
		
		// with array
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag>content content2</tag>', $tag->setContent(array('content', ' content2'))->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetAnAttribute(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag attr="value"></tag>', $tag->setAttribute('attr', 'value')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testUnsetAnAttribute(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag></tag>', $tag->setAttribute('attr', 'value')->unsetAttribute('attr')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testSetAttributeList(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag attr="value" attr2="value"></tag>', $tag->setAttributes(array('attr' => 'value', 'attr2' => 'value'))->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testIfAttrNotDefinedReturnFalse(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertFalse($tag->getAttribute('fail'));
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testAttrAliasMethod(){		
		// basic
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag attr="value"></tag>', $tag->attr('attr', 'value')->render());
		
		// list
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag attr="value" attr2="value2"></tag>', $tag->attr(array('attr' => 'value', 'attr2' => 'value2'))->render());
		
		// get
		$this->assertEquals('value2', $tag->attr('attr2'));
		
		// get all
		$this->assertEquals(array('attr' => 'value', 'attr2' => 'value2'), $tag->attr());
		
		// delete
		$this->assertEquals('<tag attr="value"></tag>', $tag->attr('attr2', false)->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testEscapeAttribute(){
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag attr="Something &quot;somethinging...&quot; an&#039;&gt;"></tag>', $tag->attr('attr', 'Something "somethinging..." an\'>')->render());
	}
	
/**
 * test method
 * 
 * @return void
 */
	public function testDynamicCallAttributeMethods(){
		// normal
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag myattr="attr"></tag>', $tag->setMyattr('attr')->render());
		
		// list
		$tag = new FG_Markup_Tag('tag');
		$this->assertEquals('<tag attr="value" attr2="value2"></tag>', $tag->setMyattr(array('attr' => 'value', 'attr2' => 'value2'))->render());
		
		// get
		$this->assertEquals('value2', $tag->getAttr2('attr2'));
		
		try{
			$tag->thisMustFail();
		}catch(RuntimeException $e){}
	}
}