<?php
require ("xerrors.php");

class XUser
{
	private $user = NULL;
	
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
	
	function ____construct($name) {
		if (isset($name)) {
			$this->user = $name;	
			
			$dom = new DOMDocument;
			
			if ($dom->load ('http://www.xfire.com/xml/'.$name.'/profile'))
			{
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
			}
		}
	}
	
}
?>