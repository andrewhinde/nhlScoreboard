<?php

require_once("class.utilities.php");
require_once("class.renderNHL.php");

$nhl = new renderNHL();

$output = $nhl->renderTodaysGames();

?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.1/css/foundation.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
	
	<style>
		.game {
			border: thin solid #efefef;
			margin: 5px 0;
			padding: 5px 10px;
		}
		.game .team .title {
			font-weight: bold;
		}
		.game .team .team_stats {
			font-size: 0.9em;
			color: #666666;
		}
		.game .toggle_stats {
			font-size: 0.8em;
			color: #999999;
		}
		.game .toggle_stats:hover {
			cursor: pointer;
		}
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.1/js/foundation.js"></script>
</head>
<body>
	<? echo $output ?>
	
	<script>
		setTimeout(function(){
			window.location.reload();
		},10000);
		
		$(".toggle_stats").on("click", function(event){
			event.stopPropagation();
			let $this = $(this);
			$this.find("i.fa").toggleClass("fa-chevron-down fa-chevron-up");
			$this.parents(".game").find(".team_stats").toggleClass("hide");
		});
	</script>
</body>
</html>