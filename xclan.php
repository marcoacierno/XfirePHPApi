<?php
include_once ("xerrors.php");

class XClan
{
	private $team     = NULL;
	private $tmembers = 0;
	private $thiddens = 0;
	private $arrcache = NULL;
	public  $error    = XErrors::NO_ERROR;
	public  $errmsg   = NULL;
	
	/**
	 * Team info
	 */
	
	private $teamname;
	private $teamtype;
	private $foundedts;
	private $teamlogo;
	private $teamsite;
	private $tdescription;
	
	function __construct($clan) {
		if (isset($clan)) {
			$this->team = $clan;
			
			/**
			 * store basic infos
			 */
			
			$this->__parseData();
		}
	}
	
	public function setClan($clan) {
		if (isset($clan)) {
			$this->team = $clan;
			$this->arrcache = NULL;
			
			$this->__parseData();
		}
	}
	
	private function __parseData () {
		$dom = new DOMDocument;
		
		if ($dom->load ('http://www.xfire.com/xml/'.$this->team.'/clan_profile')) {
			if ($dom->getElementsByTagName("error")->length > 0) {
				// Si è verificato un errore
				$this->error  = XErrors::INVALID_USERORCLAN;	
				$this->errmsg = $dom->getElementsByTagName("error")->item(0)->nodeValue;
			}
			else {
				$this->teamname  = $dom->getElementsByTagName("longname")->item(0)->nodeValue;
				$this->teamtype  = $dom->getElementsByTagName("clantype")->item(0)->nodeValue;
				$this->foundedts = $dom->getElementsByTagName("founded")->item(0)->nodeValue;
				$this->teamlogo  = $dom->getElementsByTagName("logo")->item(0)->nodeValue;
				$this->tdescription  = $dom->getElementsByTagName("description")->item(0)->nodeValue;
				$this->teamsite  = $dom->getElementsByTagName("website")->item(0)->nodeValue;
				$this->tmembers  = (int)$dom->getElementsByTagName("members")->item(0)->nodeValue;
				
				$this->error = XErrors::NO_ERROR;
			}
		}	
		else {
			$this->error = XErrors::XML_ERROR;	
		}
	}
	
	/**
	 * Returns an array w/ team members
	 */
	
	public function getTeamMembers($force = false) {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}
		
		if (is_null($this->team)) {
			return false;	
		}
		
		if (is_null($this->arrcache) || $force == true) {
			$dom = new DOMDocument;
			
			if ($dom->load('http://www.xfire.com/xml/'.$this->team.'/clan_members')) {
				$roster = $dom->getElementsByTagName("roster");

				$this->thiddens = (int)$roster->item(0)->getAttribute("hidden");
				$this->tmembers = (int)$roster->item(0)->getAttribute("members");
				
				$members = $dom->getElementsByTagName("member");
				$lastIdx = 0;
				
				foreach ($members as $member) {
					$elements = $member->getElementsByTagName("*");
					
					$this->arrcache[$lastIdx] = array();
					
					foreach($elements as $element) {
						$this->arrcache[$lastIdx][$element->tagName] = $element->nodeValue;
					}
					
					$lastIdx ++;
				}
			}
		}
		
		return $this->arrcache;
	}
	
	public function getTeamName() {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}
		
		return $this->teamname;
	}
	
	public function getTeamType () {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}
		
		return $this->teamtype;
	}

	public function getFoundedTime () {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}
		
		return $this->foundedts;
	}	
	
	public function getTeamLogo () {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}

		return $this->teamlogo;
	}	

	public function getTeamSite () {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}
		
		return $this->teamsite;
	}	
	
	public function getTeamDescription () {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}
		
		return $this->tdescription;
	}	
	
	public function getTeamNMembers () {
		if ($this->error == XErrors::INVALID_USERORCLAN) {
			return false;	
		}
		
		return $this->tmembers;	
	}
}
?>	