<?
class nhlAPI {
	
	private $_base_stats_url = "https://statsapi.web.nhl.com/api/v1";
	private $_base_records_url = "https://records.nhl.com/site/api";
	private $_curl = NULL;
	
	function __construct(){
		date_default_timezone_set("America/Toronto");
	}
	
	function __destruct(){
		
	}
	
	/**
	*  Performs cURL call and returns array
	**/
	private function _call($url, $params=array(), $method="get"){
		$this->_curl = curl_init();
		$curlConfig = array(
			CURLOPT_URL            => $url,
			CURLOPT_POST           => ($method == "post" ? true : false),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_VERBOSE		   => true,
			CURLOPT_SSL_VERIFYPEER => false		# DO NOT DO THIS.  Get a proper cacert.pem file
		);
		
		
		if($method == "post" && !empty($params) && is_array($params)){
			$curlConfig[CURLOPT_POSTFIELDS] = $params;
		}
		
		curl_setopt_array($this->_curl, $curlConfig);
		
		$result = curl_exec($this->_curl);
		$curl_err = curl_error($this->_curl);
		curl_close($this->_curl);
		
		if($result){
			return json_decode($result,TRUE);	
		} else {
			throw new Exception("No result from NHL API. " . $curl_err);
		}
	}
	
	/**
	* Get games for a single date
	* @param date Date - default NULL will get current day's game
	**/
	public function getGamesForDate($date=NULL){
		$ret = array();
		if(is_null($date)){
			$strDate = date('Y-m-d');
		} elseif ($date instanceof DateTime) {
			$strDate = $date->format('Y-m-d');
		} elseif (is_string($date)){
			$objDate = new DateTime($date);
			$strDate = $objDate->format('Y-m-d');
		}
		
		if($strDate){
			$url = $this->_base_stats_url . "/schedule?date=".$strDate;
			return $this->_call($url);
		}
		
		return FALSE;
	}
	
	/**
	* Gets box score for a single game ID
	**/
	public function getBoxScore($gameId){
		if($gameId){
			$url = $this->_base_stats_url . "/game/".$gameId."/boxscore";
			return $this->_call($url);
		}
		return FALSE;
	}
	
	
	/**
	* Gets all teams
	**/
	private function _getAllTeams(){
		$url = $this->_base_stats_url .= "/teams/";
		return $this->_call($url);
	}
	
	/**
	* Gets single team
	**/
	private function getTeam($teamId){
		$url = $this->_base_stats_url .= "/teams/".$teamId;
		return $this->_call($url);
	}


}
?>