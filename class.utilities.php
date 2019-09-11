<?php
class utilities{

	public function fromCamelCase($camelCaseString) {
		$re = '/(?<=[a-z])(?=[A-Z])/x';
		$a = preg_split($re, $camelCaseString);
		return ucfirst(join($a, " " ));
	}
	
	public function getParams(){
		
	}
	
	public function getParam($parameter){
		
	}
	
	public function parseURL(){
		$url = "http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
		$res = explode('/', parse_url($url, PHP_URL_PATH));
		
		print_r($res);
	}
	

}
?>