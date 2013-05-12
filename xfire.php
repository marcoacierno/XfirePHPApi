<?php
class XClan
{
	private $team     = NULL;
	private $tmembers = 0;
	private $thiddens = 0;
	private $arrcache = NULL;
	
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
			
			$dom = new DOMDocument;
			
			if ($dom->load ('http://www.xfire.com/xml/'.$clan.'/clan_profile')) {
				$this->teamname  = $dom->getElementsByTagName("longname")->item(0)->nodeValue;
				$this->teamtype  = $dom->getElementsByTagName("clantype")->item(0)->nodeValue;
				$this->foundedts = $dom->getElementsByTagName("founded")->item(0)->nodeValue;
				$this->teamlogo  = $dom->getElementsByTagName("logo")->item(0)->nodeValue;
				$this->tdescription  = $dom->getElementsByTagName("description")->item(0)->nodeValue;
				$this->teamsite  = $dom->getElementsByTagName("website")->item(0)->nodeValue;
			}
		}
	}
	
	public function setClan($clan) {
		if (isset($clan)) {
			$this->team = $clan;
		}
	}
	
	/**
	 * Returns an array w/ team members
	 */
	
	public function getTeamMembers($force = false) {
		if (is_null($this->team)) {
			return false;	
		}
		
		if (is_null($this->arrcache) || $force == true) {
			$dom = new DOMDocument;
			
			if ($dom->load('http://www.xfire.com/xml/'.$this->team.'/clan_members')) {
				$roster = $dom->getElementsByTagName("roster");

				$this->thiddens = $roster->item(0)->getAttribute("hidden");
				$this->tmembers = $roster->item(0)->getAttribute("members");
				
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
		return $this->teamname;
	}
	
	public function getTeamType () {
		return $this->teamtype;
	}

	public function getFoundedTime () {
		return $this->foundedts;
	}	
	
	public function getTeamLogo () {
		return $this->teamlogo;
	}	

	public function getTeamSite () {
		return $this->teamsite;
	}	
	
	public function getTeamDescription () {
		return $this->tdescription;
	}	
}
?>	