<?php
/**
 * All tests
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 */
class AllTests{
	
/**
 * suite method
 */
    public static function suite(){
        $suite = new PHPUnit_Framework_TestSuite('PHP Form Generator API Tests');
 		self::addDir('HTML', $suite);
 		self::addDir('HTML/Element', $suite);
 		self::addDir('HTML/Form', $suite);
 		self::addDir('HTML/Form/Input', $suite);
 		self::addDir('HTML/Form/Input/Collection', $suite);
 		self::addDir('Markup', $suite);
        return $suite;
	}
    
/**
 * Add dir to $suite
 * 
 * @param string $dir
 * @param object $suite
 */
    public static function addDir($dir, $suite){
    	$files = array();
    	$dirname = dirname(__FILE__) . '/' . $dir;
	    foreach (glob($dirname . "/*Test.php") as $filename) {
	    	$suite->addTestFile($filename);
		}
    }
}