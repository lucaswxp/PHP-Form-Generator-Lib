<?php
/**
 * Class representing a form data structure
 * 
 * @author Lucas Pelegrino <lucas.wxp@gmail.com>
 * @package fg.HTML.Form
 */

class FG_HTML_Form_DataHandler{
	
/**
 * Array of FG_HTML_Form_Input_Fillable and strings
 * 
 * @var array
 */
	protected $content = array();
	
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
 * Adds content to the form
 * 
 * @param FG_HTML_Form_Input_Fillable|string $content
 * @return FG_HTML_Form_DataHandler this object for method chaining
 */
	public function add($content){
		$this->content[] = $content;
		return $this;
	}
	
/**
 * get form html
 * 
 * @return string
 */
	public function render(){
		$innerContent = array();
		foreach($this->content as $content){
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
		
		return join('', $innerContent);
	}
	
/**
 * Gets $path from the data
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
 * Outputs
 * 
 * @return string
 */
	public function __toString(){
		return $this->render();
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
 * Populates the form fields with $data
 * 
 * @param array $data
 * @return FG_HTML_Form_DataHandler this object for method chaining
 */
	public function populate(Array $data){
		$this->data = $data;
		return $this;
	}
}