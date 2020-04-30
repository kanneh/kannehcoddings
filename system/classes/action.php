<?php
	/**
	 * 
	 */
	class Action
	{
		private $id;
		private $route;
		private $method='index';
		
		function __construct($route)
		{
			# code...
			$this->id=$route;
			$parts=explode("/",$route);
			if (count($parts)>2) {
				# code...
				$this->method=array_pop($parts);
			}

			$route=$parts[0].'/'.$parts[1];

		}

		
	}





?>