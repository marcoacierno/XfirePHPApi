<?php
include_once ("xerrors.php");

class XScreenshots {
	private $totalshots = 0;		// sdeve essere disponibile già dal costruttore 
	private $name  		= NULL;
	private $type		= 0;		// 0 => Game | 1 => User
	public  $error  	= XErrors::NO_ERROR;
	public  $errmsg 	= NULL;	
	private $screenshots = NULL;
		
	function __construct ($name, $type) {
		if (isset ($name) && isset($type)) {
			$this->name 	 = $name;
			$this->type		 = $type;	
		}
	}
	
	public function changeName ($name, $type) {
		if (isset ($name) && isset($type)) {
			$this->name 	 = $name;
			$this->type		 = $type;	
		}		
	}
	
	public function sarchSHByUser ($user) {
		if (is_null($this->screenshots)) {
			return false;	
		}
		
		$result = array ();
		$idx    = 0;
		
		foreach ($this->screenshots as $screen) {
			if ($screen["username"] == $user) {
				//$result[0] = array("Hello" => "HIO");
				$result[$idx] = $screen; // 
				$idx ++;
			}
		}
		
		return $result;
	}
	
	public function getScreenshots ($force = false) {
		if ($force || is_null($this->screenshots)) {
			$dom = new DOMDocument;
			
			if ($this->type == 0) {
				// 0 => game
				$url = "http://www.xfire.com/xml/".$this->name."/popular_screenshots"; 	
			}
			else {
				// 1 => user
				$url = "http://www.xfire.com/xml/".$this->name."/screenshots";
			}
			
			if ($dom->load($url)) {
				if ($dom->getElementsByTagName("error")->length > 0) {
					// Si è verificato un errore
					$this->error  = XErrors::INVALID_USERORCLAN;	
					$this->errmsg = $dom->getElementsByTagName("error")->item(0)->nodeValue;
				}
				else {
					$screenshots = $dom->getElementsByTagName("screenshot");
					$lastIdx     = 0;
					
					foreach ($screenshots as $screenshot) {
						$elements = $screenshot->getElementsByTagName("*");
							
						$this->screenshots[$lastIdx] = array();
												
						foreach ($elements as $element) {
							$tag = $element->tagName;
							if ($tag == "sizes") {
								$this->screenshots[$lastIdx][$tag] = array();
								
								$sizes = $element->getElementsByTagName("*");
								/*
								foreach ($sizes as $size) {
									$this->screenshots[$lastIdx][$tag][$size->getAttribute("size")] = $size->nodeValue;
								}*/
								
								$this->screenshots[$lastIdx][$tag][$sizes->item(0)->getAttribute("size")] = $sizes->item(0)->nodeValue;				
								$this->screenshots[$lastIdx][$tag][$sizes->item(1)->getAttribute("size")] = $sizes->item(1)->nodeValue;
								$this->screenshots[$lastIdx][$tag][$sizes->item(2)->getAttribute("size")] = $sizes->item(2)->nodeValue;				
								$this->screenshots[$lastIdx][$tag][$sizes->item(3)->getAttribute("size")] = $sizes->item(3)->nodeValue;	
								$this->screenshots[$lastIdx][$tag][$sizes->item(4)->getAttribute("size")] = $sizes->item(4)->nodeValue;									
							}
							else
							{
								$this->screenshots[$lastIdx][$tag] = $element->nodeValue;
							}
						}
						
						$lastIdx ++;
					}
				}
			}
			else {
				$this->error = XErrors::XML_ERROR;	
			}
		}
		
		return $this->screenshots;
	}
}
//popular_screenshots
?>