<?php

class renderNHL{
	
	private $_nhl_api = NULL;
	private $_utilities = NULL;
	
	function __construct(){
		include('class.nhl_api.php');
		$this->_nhl_api = new nhlAPI();
		$this->_utilities = new utilities();
	}
	
	function __destruct(){
		
	}
	
	public function renderTodaysGames(){
		$output = "";
		$return = $this->_nhl_api->getGamesForDate('19-11-2018');
		if(!empty($return)){
			$gamesInfo = $return["dates"][0];
			$num_games = $gamesInfo["totalGames"];
			$games = $gamesInfo["games"];
		
			$output .= "<div class='grid-container'>";	
			$output .= "<h1>NHL Games for Today</h1>";
			$output .= "<h3>There are " . $num_games . " games today</h3>";
			//$output .= $this->renderTeamsDropdown($games);
			foreach($games as $game){
				//print_r($game);
				$venue = $game["venue"]["name"];
				$game_status = $game["status"]["abstractGameState"];
				$game_id = $game["gamePk"];
				$box_score = $this->_nhl_api->getBoxScore($game_id);
				
				$home_team = $box_score["teams"]["home"];
				$home_team_stats = $home_team["teamStats"]["teamSkaterStats"];
				$home_team_goals = $home_team_stats["goals"];
				unset($home_team_stats["goals"]);
				
				$away_team = $box_score["teams"]["away"];
				$away_team_stats = $away_team["teamStats"]["teamSkaterStats"];
				$away_team_goals = $away_team_stats["goals"];
				unset($away_team_stats["goals"]);
				$status_class = ($game_status == "Live" ? "live" : "");
				$output .= "<div class='grid-x game ".$status_class."'>";
					$output .= "<div class='cell small-4 medium-3 columns team home'>";
						$output .= "<div class='title'>".$home_team["team"]["name"]." : $home_team_goals</div>";
						$output .= "<div class='team_stats hide'>";
						if(!empty($home_team_stats)){
							foreach($home_team_stats as $stat => $value){
								$stat = $this->_utilities->fromCamelCase($stat);
								$output .= "<div class='stat_name'>".$stat." : ".$value."</div>";
							}
						}
						$output .= "</div>";
					$output .= "</div>"; 	// close home team
					
					$output .= "<div class='cell small-4 medium-3 columns team away'>";
						$output .= "<div class='title'>".$away_team["team"]["name"]." : $away_team_goals</div>";
						$output .= "<div class='team_stats hide'>";
						if(!empty($away_team_stats)){
							foreach($away_team_stats as $stat => $value){
								$stat = $this->_utilities->fromCamelCase($stat);
								$output .= "<div class='stat_name'>".$stat." : ".$value."</div>";
							}
						}
						$output .= "</div>";
					$output .= "</div>";	// close away team
					$output .= "<div class='hide-for-small medium-3 venu_status show-for-landscape'>" . $game_status . " from " . $venue . "</div>";
					$output .= "<div class='cell small-4 medium-3 columns toggle_stats'>Toggle Stats <i class='fa fa-fw fa-chevron-down'></i></div>";
				$output .= "</div>";
			
			}
			$output .= "</div>"; // close grid container
		} else {
			$output .= "<div class='well warning'>No games found for the given date</div>";
		}			
		return $output;
	}


	/**
	*  Renders a dropdown of teams.  
	*  I don't remember where I was going with this
	**/
	public function renderTeamsDropdown($todaysGames){
		$ret = "";
		if(!empty($todaysGames)){
			foreach($todaysGames as $game){
				
			}
		}
	}

	

}
?>