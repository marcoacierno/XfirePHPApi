<?php
include_once ("xerrors.php");

class XUser
{
	private $user   = NULL;
	public  $error  = XErrors::NO_ERROR;
	public  $errmsg = NULL;	
	
	/**
	 * User data
	 */
	 
	private $nickname 	= NULL;
	private $avatar   	= NULL;
	private $friends  	= 0;
	private $gender   	= NULL;
	private $gstyle     = NULL;
	private $age        = 0;
	private $joindate   = NULL;
	private $status     = NULL; /* Can be online or the game? */
	private $website    = NULL;
	private $realname   = NULL;
	private $occupation = NULL;
	private $interessi  = NULL; // interests
	private $bio		= NULL;
	private $country    = NULL;
	private $location   = NULL;
	
	private $ufriends    = NULL;
	private $screenshots = NULL;
	
	function __construct($name) {
		if (isset($name)) {
			$this->user = $name;	
			$this->__parseData();
			$this->ufriends = NULL;
		}
	}
	
	private function __parseData () {
		
		$dom = new DOMDocument;
		
		if ($dom->load ('http://www.xfire.com/xml/'.$this->user.'/profile'))
		{
			if ($dom->getElementsByTagName("error")->length > 0) {
				$this->error = XErrors::INVALID_USERORCLAN;
				$this->errmsg = $dom->getElementsByTagName("error")->item(0)->nodeValue;
			}
			else {
				$this->nickname  	= $dom->getElementsByTagName("nickname")->item(0)->nodeValue;
				$this->avatar  	 	= $dom->getElementsByTagName("avatar")->item(0)->nodeValue;
				$this->friends   	= (int)$dom->getElementsByTagName("friends_count")->item(0)->nodeValue;
				$this->gender    	= (int)$dom->getElementsByTagName("gender")->item(0)->nodeValue; // can be M or F
				$this->gstyle 	 	= $dom->getElementsByTagName("gaming_style")->item(0)->nodeValue;
				$this->country 	 	= $dom->getElementsByTagName("country")->item(0)->nodeValue;
				$this->location  	= $dom->getElementsByTagName("location")->item(0)->nodeValue;
				$this->joindate  	= $dom->getElementsByTagName("joindate")->item(0)->nodeValue;
				$this->status  	 	= $dom->getElementsByTagName("status")->item(0)->nodeValue;
				$this->website   	= $dom->getElementsByTagName("website")->item(0)->nodeValue;
				$this->realname  	= $dom->getElementsByTagName("realname")->item(0)->nodeValue;
				$this->occupation	= $dom->getElementsByTagName("occupation")->item(0)->nodeValue;
				$this->bio			= $dom->getElementsByTagName("bio")->item(0)->nodeValue;
				$this->interessi	= $dom->getElementsByTagName("interests")->item(0)->nodeValue;
				
				$this->error = XErrors::NO_ERROR;
			}
		}
		else {
			$this->error = XErrors::XML_ERROR;	
		}
	}
	
	public function setUser ($user) {
		if (isset($user)) {
			$this->user = $user;
			$this->__parseData ();	
			return true;
		}
		return false;
	}
	
	public function getFriends ($limit, $force = false) {
		$dom = new DOMDocument;
		
		if ($dom->load ('http://www.xfire.com/xml/'.$this->user.'/friends'))
		{
			if ($dom->getElementsByTagName("error")->length > 0) {
				// SHOULD BE IMPROVED
				// ERROR CAN BE INVALID USER OR THE USER HIDDEN INFOS
				$this->error = XErrors::INVALID_USERORCLAN;
				$this->errmsg = $dom->getElementsByTagName("error")->item(0)->nodeValue;
				return false;
			}
			
			if (is_null($this->ufriends) || $force == true) {
				$friends = $dom->getElementsByTagName("friend");
				$lastIdx = 0;
				
				foreach ($friends as $friend) {
					$elements = $friend->getElementsByTagName("*");
					
					$this->ufriends[$lastIdx] = array();
					
					foreach($elements as $element) {
						$this->ufriends[$lastIdx][$element->tagName] = $element->nodeValue;
					}
					
					if ($lastIdx > $limit) {
						break;	
					}
					
					$lastIdx ++;
				}
			}
			
			return $this->ufriends;
		}
		else {
			$this->error = XErrors::XML_ERROR;	
			return false;	
		}
	}
}
?>