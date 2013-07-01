<?php
/**
 * Xfire-Users
 * Gestisce le informazioni riguardo i players
 */
 
class XUsers extends XErrors
{
	private $user 		= NULL;
	private $user_data  = array();
	
	function __construct($user)
	{
		if (!isset($user))
		{
			$this->SetError("Invalid USER.");
		}
		else
		{
			$this->user = $user;
			
			$dom = new DOMDocument;
			
			if ($dom->load("http://www.xfire.com/xml/" . $user . "/profile"))
			{
				if ($dom->getElementsByTagName("error")->length == 1)
				{
					$this->SetError($dom->getElementsByTagName("error")->item(0)->nodeValue);
				}
				else
				{
					$this->user_data["nickname"]  	= $dom->getElementsByTagName("nickname")->item(0)->nodeValue;
					$this->user_data["avatar"]  	= $dom->getElementsByTagName("avatar")->item(0)->nodeValue;
					$this->user_data["friends"]   	= (int)$dom->getElementsByTagName("friends_count")->item(0)->nodeValue;
					$this->user_data["gender"]    	= (int)$dom->getElementsByTagName("gender")->item(0)->nodeValue; // can be M or F
					$this->user_data["gstyle"] 	 	= $dom->getElementsByTagName("gaming_style")->item(0)->nodeValue;
					$this->user_data["country"] 	= $dom->getElementsByTagName("country")->item(0)->nodeValue;
					$this->user_data["location"]  	= $dom->getElementsByTagName("location")->item(0)->nodeValue;
					$this->user_data["joindate"]  	= $dom->getElementsByTagName("joindate")->item(0)->nodeValue;
					$this->user_data["status"]  	= $dom->getElementsByTagName("status")->item(0)->nodeValue;
					$this->user_data["website"]   	= $dom->getElementsByTagName("website")->item(0)->nodeValue;
					$this->user_data["realname"]  	= $dom->getElementsByTagName("realname")->item(0)->nodeValue;
					$this->user_data["occupation"]	= $dom->getElementsByTagName("occupation")->item(0)->nodeValue;
					$this->user_data["bio"]			= $dom->getElementsByTagName("bio")->item(0)->nodeValue;
					$this->user_data["interessi"]	= $dom->getElementsByTagName("interests")->item(0)->nodeValue;					
				}
			}
			else
			{
				$this->SetError("Invalid XML");	
			}
		}
	}
	
	public function GetUserInfo($info)
	{
		if (!isset($this->user_data[$info])) {
			$this->SetError($info . " non esiste.");
			return 0;
		}
		else
		{
			return $this->user_data[$info];
		}
	}
}
?>