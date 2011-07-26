<?php
/**
 * Class representing a HTML form element
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.HTML.Element
 */

require_once dirname(dirname(__FILE__)) . '/FG_HTML_Element.php';

class FG_HTML_Element_Form extends FG_HTML_Element{
	
/**
 * Array of FG_HTML_Form_Input_Fillable
 * 
 * @var array
 */
	protected $formContent = array();
	
/**
 * Fields data
 * 
 * @var array
 */
	public $data = array();
	
/**
 * @var array
 */
	private $_pathStorage = array();
	
/**
 * Initializes the element
 */
	public function __construct(){
		parent::__construct('form');
	}
	
/**
 * Adds content to the form
 * 
 * @param FG_HTML_Form_Input_Fillable|string $content
 * @return FG_HTML_Element_Form this object for method chaining
 */
	public function add($content){
		if(is_a($content, 'FG_HTML_Form_Input_File') && !$this->attr('enctype')){
			$this->setMultipart(true);
		}

		$this->formContent[] = $content;
		return $this;
	}
	
/**
 * get form html
 * 
 * @return string
 */
	public function render(){
		$innerContent = array();
		foreach($this->formContent as $content){
			if(is_a($content, 'FG_HTML_Form_Input_Fillable')){
				if(!$content->isFilled()){
					try {
						$fieldData = $this->getDataByPath($content->getName(), is_a($content, 'FG_HTML_Form_Input_MultiFillable') && $content->isMultiFillable());
						$haveData = true;
					}catch(Exception $e){
						$haveData = false;
					}
	
					if($haveData)
						$content->fill($fieldData);
				}
			}
			$innerContent[] = $content;
		}
		
		$this->setContent($innerContent);
		return parent::render();
	}
	
/**
 * Gets $path from the form data
 * 
 * @param string $path
 * @param bool $isMultiple
 * @throws OutOfBoundsException
 * @throws InvalidArgumentException
 */
	public function getDataByPath($path, $isMultiple = false){
		$path = self::_findPathFor($path);
		$count = count($path)-1;
		$data = $this->data;
		$pathUntilNow = '';
		
		if($path[0] != ''){ // invalid
			foreach($path as $i => $current){
				$isLast = $count == $i;
				$pathUntilNow .= $current . ($isLast ? '' : '.');
				
				if($current === ''){
					if($isMultiple && $isLast){
						return $data;
					}elseif(!$isMultiple){
						if(isset($this->_pathStorage[$pathUntilNow])){
							$this->_pathStorage[$pathUntilNow]++;
						}else{
							$this->_pathStorage[$pathUntilNow] = 0;
						}
						
						$current = $this->_pathStorage[$pathUntilNow];
					}
				}
				
				if(isset($data[$current])){
					if($isLast){
						return $data[$current];
					}else{
						if(!is_array($data[$current])){
							break;
						}else{
							$data = $data[$current];
						}
					}
				}elseif(is_numeric($current)){
					throw new OutOfBoundsException(sprintf('This field do not have a "%s" index', $current));
				}
			}
		}
		
		throw new InvalidArgumentException('Pass a valid path');
	}
	
/**
 * Find "array path" for a name
 * 
 * @param string $name
 */
	private static function _findPathFor($name){
		$pieces = explode('[', $name);
		foreach($pieces as &$piece){
			$piece = str_replace(']', '', $piece);
		}
		return $pieces;
	}
	
/**
 * Check if $str have a "["
 * 
 * @param string $str
 */
	private function _isArrayName($str){
		return strpos($str, '[') !== false;
	}
	
/**
 * Sets form with attr enctype = multipart/form-data
 * 
 * @param boolean $bool
 * @return FG_HTML_Element_Form this object for method chaining
 */
	public function setMultipart($bool){
		$enc = 'multipart/form-data';
		if($bool){
			$this->setAttribute('enctype', $enc);
		}else{
			if($this->attr('enctype') == $enc){
				$this->attr('enctype', false);
			}
		}
		return $this;
	}
	
/**
 * Populates the form fields with $data
 * 
 * @param array $data
 * @return FG_HTML_Element_Form this object for method chaining
 */
	public function populate(Array $data){
		$this->data = $data;
		return $this;
	}
}